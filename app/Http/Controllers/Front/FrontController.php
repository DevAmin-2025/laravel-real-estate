<?php

namespace App\Http\Controllers\Front;

use App\Models\Faq;
use App\Models\Blog;
use App\Models\Plan;
use App\Models\Agent;
use App\Models\Header;
use App\Models\Amenity;
use App\Models\Location;
use App\Models\Property;
use Illuminate\View\View;
use App\Models\Subscriber;
use App\Models\Testimonial;
use App\Models\WhyChooseUs;
use Illuminate\Support\Str;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    /**
     * Display the front-facing homepage.
     *
     * @return View
     */
    public function index(): View
    {
        $randomProperties = Property::where('status', 1)
            ->inRandomOrder()
            ->take(6)
            ->with('propertyType', 'location', 'agent')
            ->get();
        $popularLocations = Location::withCount([
            'properties' => function ($query) {
                $query->where('status', 1);
            }
        ])->orderByDesc('properties_count')->take(8)->get();
        $agents = Agent::where('status', 1)
            ->inRandomOrder()
            ->take(8)
            ->get();
        $header = Header::first();
        $whyChooseUsItems = WhyChooseUs::all();
        $testimonials = Testimonial::all();
        $posts = Blog::latest()
            ->take(3)
            ->get();
        $locations = Location::all();
        $propertyTypes = PropertyType::all();

        return view(
            'front.index',
            compact(
                'randomProperties',
                'popularLocations',
                'agents',
                'header',
                'whyChooseUsItems',
                'testimonials',
                'posts',
                'locations',
                'propertyTypes',
            )
        );
    }

    /**
     * Show the user type selection page.
     *
     * @return View
     */
    public function selectUser(): View
    {
        return view('front.pages.select_user');
    }

    /**
     * Show user dashboard entry point.
     *
     * @return View
     */
    public function userDashboard(): View
    {
        $user = Auth::guard('web')->user();
        return view('front.user.dashboard.index', compact('user'));
    }

    /**
     * Show agent dashboard entry point.
     *
     * @return View
     */
    public function agentDashboard(): View
    {
        $agent = Auth::guard('agent')->user();
        return view('front.agent.dashboard.index', compact('agent'));
    }

    /**
     * Show pricing page.
     *
     * @return View
     */
    public function pricing(): View
    {
        $plans = Plan::all();
        return view('front.pages.pricing', compact('plans'));
    }

    /**
     * Display a single property detail page along with related properties.
     *
     * This method loads the full details of a given property, including its
     * associated photos, videos, agent, location, property type, and amenities.
     * It also fetches up to 4 related properties of the same type,
     * ensuring they are active and randomized for variety.
     *
     * @param Property $property
     * @return View
     */
    public function property(Property $property): View
    {
        $property->load('photos', 'videos', 'agent', 'location', 'propertyType', 'amenities');
        $relatedProperties = Property::where('property_type_id', $property->property_type_id)
            ->where('status', 1)
            ->where('id', '!=', $property->id)
            ->with('location', 'propertyType', 'agent')
            ->inRandomOrder()
            ->take(4)
            ->get();
        return view('front.pages.property', compact('property', 'relatedProperties'));
    }

    /**
     * Handle user inquiry submission for a specific property.
     *
     * Validates the inquiry form input, then sends an email to the property's agent
     * containing the user's message. If the email is successfully sent, a success
     * message is flashed to the session. Otherwise, an error message is returned.
     *
     * @param Request $request
     * @param Property $property
     * @return RedirectResponse
     */
    public function inquirySubmit(Request $request, Property $property): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|regex:/^09[0-3]\d{8}$/',
            'message' => 'required|string|min:10',
        ]);

        $agentEmail = $property->agent->email;
        try {
            Mail::send('email.user_inquiry', [
                'property' => $property,
                'request' => $request,
            ], function ($message) use ($agentEmail, $property) {
                $message->to($agentEmail);
                $message->subject("Inquiry About The Property $property->name");
            });
            return back()->with('success', 'Message was successfully sent to the agent.');
        } catch (\Exception $e) {
            return back()->with('error', 'Message could not be sent to the agent. Please try again.');
        };
    }

    /**
     * Display a filtered and paginated list of active properties based on user search criteria.
     *
     * Validates that the minimum price does not exceed the maximum price. Then applies dynamic filters
     * using the `scopeSearch()` method on the `Property` model. Filters include title, location, type,
     * purpose, amenities, bedroom/bathroom count, featured status, and price range.
     *
     * Eager loads related models: `propertyType`, `location`, and `agent` for each property.
     * Also retrieves all locations, property types, and amenities for use in the filter UI.
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function properties(Request $request): View|RedirectResponse
    {
        if ($request->min_price > $request->max_price) {
            return back()->with('error', 'Minimum price must be less than maximum price.');
        };

        $properties = Property::where('status', 1)
            ->with('propertyType', 'location', 'agent')
            ->latest()
            ->search(
                word: $request->title,
                locationId: $request->location_id,
                propertyTypeId: $request->type_id,
                purpose: $request->purpose,
                amenity: $request->amenity,
                bedroom: $request->bedroom,
                bathroom: $request->bathroom,
                isFeatured: $request->is_featured,
                minPrice: $request->min_price,
                maxPrice: $request->max_price,
            )
            ->paginate(8);
        $locations = Location::all();
        $propertyTypes = PropertyType::all();
        $amenities = Amenity::all();
        return view(
            'front.pages.properties',
            compact(
                'properties',
                'locations',
                'propertyTypes',
                'amenities',
            ));
    }

    /**
     * Display a paginated list of active properties for a given location.
     *
     * This method retrieves all properties with `status = 1` that belong to the specified location.
     * It eager loads related models for each property: property type, location, and agent,
     * and paginates the results to show 12 properties per page.
     *
     * @param Location $location
     * @return View
     */
    public function location(Location $location): View
    {
        $properties = Property::where('status', 1)
            ->where('location_id', $location->id)
            ->with('propertyType', 'location', 'agent')
            ->paginate(12);
        return view('front.pages.location', compact('properties', 'location'));
    }

    /**
     * Display a paginated list of locations ranked by active property count.
     *
     * This method retrieves all locations along with a count of their associated properties
     * where `status = 1`. The locations are sorted in descending order based on the number
     * of active properties and paginated to show 16 per page.
     *
     * @return View
     */
    public function locations(): View
    {
        $locations = Location::withCount([
            'properties' => function ($query) {
                $query->where('status', 1);
            }
        ])->orderByDesc('properties_count')->paginate(16);
        return view('front.pages.locations', compact('locations'));
    }

    /**
     * Display a paginated list of agents.
     *
     * This method retrieves all agents where `status = 1`.
     * The agents are sorted in descending order based on the creation date.
     *
     * @return View
     */
    public function agents(): View
    {
        $agents = Agent::where('status', 1)->latest()->paginate(15);
        return view('front.pages.agents', compact('agents'));
    }

    /**
     * Display a paginated list of active properties associated with a specific agent.
     *
     * This method retrieves all properties with `status = 1` that belong to the given agent.
     * It eager loads related models: `propertyType` and `location` for each property,
     * and paginates the results to show 12 properties per page.
     *
     * @param Agent $agent
     * @return View
     */
    public function agent(Agent $agent): View
    {
        $properties = Property::where('status', 1)
            ->where('agent_id', $agent->id)
            ->latest()
            ->with('propertyType', 'location')
            ->paginate(12);
        return view('front.pages.agent', compact('agent', 'properties'));
    }

    /**
     * Display a paginated list of posts.
     *
     * @return View
     */
    public function blog(): View
    {
        $posts = Blog::latest()->paginate(15);
        return view('front.pages.blog', compact('posts'));
    }

    /**
     * Display a single post detail page.
     *
     * @param Blog $blog
     * @return View
     */
    public function post(Blog $blog): View
    {
        return view('front.pages.post', ['post' => $blog]);
    }

    /**
     * Display the FAQ page with all published FAQs.
     *
     * Retrieves all FAQ records from the database and passes them to the
     * front.pages.faq Blade view for rendering.
     *
     * @return View
     */
    public function faq(): View
    {
        $faqs = Faq::all();
        return view('front.pages.faq', compact('faqs'));
    }

    /**
     * Handle AJAX subscription form submission.
     *
     * Validates the submitted email, ensures it's unique, and creates a new subscriber record
     * with a verification token. Sends a confirmation email to the user with a verification link.
     * If email sending fails, the subscriber record is rolled back.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function subscribe(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribers,email',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'code'=> 0,
                    'error_message'=> $validator->errors()->toArray(),
                ]
            );
        }

        $token = Str::random(64);
        $subscriber = Subscriber::create([
            'email' => $request->email,
            'token' => $token,
        ]);

        try {
            Mail::send('email.subscriber', ['token' => $token], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Subscription Verification');
            });
            return response()->json(
                [
                    'code'=> 1,
                    'success_message'=> 'Please check your email to confirm subscription',
                ]
            );
        } catch (\Exception) {
            $subscriber->delete();
            return response()->json(
                [
                    'code'=> 0,
                    'error_message'=> 'Failed to send verification email. Please try again later.',
                ]
            );
        };
    }

    /**
     * Verify a subscriber using the provided token.
     *
     * Looks up the subscriber by token. If found, marks the subscription as verified
     * by clearing the token and setting the status to active. Redirects to the homepage
     * with a success or error message.
     *
     * @param string $token
     * @return RedirectResponse
     */
    public function subscribeVerify(string $token): RedirectResponse
    {
        $subscriber = Subscriber::where('token', $token)->first();
        if (!$subscriber) {
            return redirect()->route('home')->with('error', 'Subscription not Verified.');
        };

        $subscriber->update([
            'token' => '',
            'status' => 1
        ]);
        return redirect()->route('home')->with('success', 'Subscription Verified.');
    }
}
