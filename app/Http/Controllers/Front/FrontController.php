<?php

namespace App\Http\Controllers\Front;

use App\Models\Plan;
use App\Models\Property;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;

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
        return view(
            'front.index',
            compact(
                'randomProperties',
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
}
