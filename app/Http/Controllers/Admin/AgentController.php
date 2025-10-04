<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Agent;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $agents = Agent::latest()->get();
        return view('admin.agent.index', compact('agents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.agent.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'photo' => 'nullable|image|max:2048',
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:agents,email',
            'phone' => 'required|regex:/^[0-3]\d{8}$/|unique:agents,phone',
            'password' => 'required|min:6|confirmed',
            'company' => 'required|min:2|string',
            'designation' => 'required|min:4|string',
            'address' => 'nullable|string',
            'country' => 'nullable|min:3|string',
            'state' => 'nullable|min:2|string',
            'city' => 'nullable|string',
            'website' => 'nullable|url',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|url',
            'biography' => 'nullable|string|min:10',
        ]);

        $fileName = null;
        if ($request->file('photo')) {
            $fileName = Carbon::now()->micro . '-' . $request->photo->getClientOriginalName();
            $request->photo->storeAs('user-images/' . $fileName);
        };

        $token = Str::random(64);
        $agent = Agent::create([
            'photo' => $fileName,
            'name' => ucwords($request->name),
            'email' => $request->email,
            'phone' => '09' . $request->phone,
            'password' => Hash::make($request->password),
            'company' => ucwords($request->company),
            'designation' => ucwords($request->designation),
            'address' => $request->address,
            'country' => ucwords($request->country),
            'state' => ucwords($request->state),
            'city' => ucwords($request->city),
            'website' => $request->website,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'instagram' => $request->instagram,
            'biography' => $request->biography,
            'token' => $token,
        ]);
        try {
            Mail::send(
                'email.register_email',
                [
                    'token' => $token,
                    'adminAgent' => $agent,
                    'request' => $request
                ],
                function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Email Verification');
            });
            return redirect()->route('admin.agents.index')->with('success', 'Verification email has been sent to agent\'s email.');
        } catch (\Exception) {
            $agent->forceDelete();
            return redirect()->back()->with('error', 'Failed to send verification email. Please try again.');
        };
    }

    /**
     * Display the specified resource.
     *
     * @param Agent $agent
     * @return View
     */
    public function show(Agent $agent): View
    {
        return view('admin.agent.show', compact('agent'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Agent $agent
     * @return View
     */
    public function edit(Agent $agent): View
    {
        return view('admin.agent.edit', compact('agent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Agent $agent
     * @return RedirectResponse
     */
    public function update(Request $request, Agent $agent): RedirectResponse
    {
        $request->validate([
            'photo' => 'nullable|image|max:2048',
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:agents,email,' . $agent->id,
            'phone' => 'required|regex:/^[0-3]\d{8}$/|unique:agents,phone,' . $agent->id,
            'password' => 'nullable|min:6|confirmed',
            'company' => 'required|min:2|string',
            'designation' => 'required|min:4|string',
            'address' => 'nullable|string',
            'country' => 'nullable|min:3|string',
            'state' => 'nullable|min:2|string',
            'city' => 'nullable|string',
            'website' => 'nullable|url',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|url',
            'biography' => 'nullable|string|min:10',
            'status' => 'required',
        ]);

        $updates = [
            'company' => ucwords($request->company),
            'designation' => ucwords($request->designation),
            'address' => $request->address,
            'country' => ucwords($request->country),
            'state' => ucwords($request->state),
            'city' => ucwords($request->city),
            'website' => $request->website,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'instagram' => $request->instagram,
            'biography' => $request->biography,
            'status' => $request->status,
        ];

        if (
            $request->filled('password')
            || $request->name != $agent->name
            || $request->email != $agent->email
            || $request->phone != substr($agent->phone, 2)
        ) {
            try {
                Mail::send(
                    'email.admin_user_edit',
                    [
                        'agent' => 'agent',
                        'request' => $request,
                    ],
                    function ($message) use ($request) {
                    $message->to($request->email);
                    $message->subject('Account Information Updated');
                });
                $updates['name'] = ucwords($request->name);
                $updates['email'] = $request->email;
                $updates['phone'] = '09' . $request->phone;
                if (Auth::guard('agent')->id() == $agent->id) {
                    Auth::guard('agent')->logout();
                };
            } catch (\Exception) {
                return back()->with('error', 'Failed to send email. Please try again later.');
            };
        };
        if ($request->filled('password')) {
            $updates['password'] = Hash::make($request->password);
        };
        if ($request->file('photo')) {
            Storage::delete('user-images/' . $agent->photo);
            $fileName = Carbon::now()->micro . '-' . $request->photo->getClientOriginalName();
            $request->photo->storeAs('user-images', $fileName);
            $updates['photo'] = $fileName;
        };
        $agent->update($updates);
        return redirect()->route('admin.agents.index')->with('success', 'Agent updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Agent $agent
     * @return RedirectResponse
     */
    public function destroy(Agent $agent): RedirectResponse
    {
        Storage::delete('user-images/' . $agent->photo);
        $agent->delete();
        return redirect()->route('admin.agents.index')->with('success', 'Agent deleted successfully');
    }
}
