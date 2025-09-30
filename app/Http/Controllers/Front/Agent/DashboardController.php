<?php

namespace App\Http\Controllers\Front\Agent;

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

class DashboardController extends Controller
{
    /**
     * Show the profile edit form for the authenticated agent.
     *
     * @return View
     */
    public function editProfile(): View
    {
        $agent = Auth::guard('agent')->user();
        return view('front.agent.dashboard.edit_profile', compact('agent'));
    }

    /**
     * Handle profile update submission for the given agent.
     *
     * Validates input, updates profile fields, handles photo upload,
     * and manages sensitive changes like email and password.
     * If email or password changes, sends verification email and logs out the agent.
     *
     * @param Request $request
     * @param Agent $agent
     * @return RedirectResponse
     */
    public function editProfileSubmit(Request $request, Agent $agent): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $agent->id,
            'phone' => 'required|regex:/^[0-3]\d{8}$/|unique:users,phone,' . $agent->id,
            'password' => 'nullable|min:6|confirmed',
            'photo' => 'nullable|image|max:2048',
            'designation' => 'required|string|min:3',
            'company' => 'required|string|min:2',
            'address' => 'nullable|string|min:10',
            'country' => 'nullable|string|',
            'state' => 'nullable|string|',
            'city' => 'nullable|string|',
            'website' => 'nullable|string|url',
            'facebook' => 'nullable|string|url',
            'twitter' => 'nullable|string|url',
            'linkedin' => 'nullable|string|url',
            'instagram' => 'nullable|string|url',
            'biography' => 'nullable|string|min:10',
        ]);

        $updates = [
            'name' => ucwords($request->name),
            'phone' => '09' . $request->phone,
            'designation' => ucwords($request->designation),
            'company' => ucwords($request->company),
            'address' => $request->address,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'website' => $request->website,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin,
            'instagram' => $request->instagram,
            'biography' => $request->biography,
        ];

        $emailChanged = $request->email !== $agent->email;
        if ($emailChanged) {
            $token = Str::random(64);
            try {
                Mail::send(
                    'email.register_email',
                    ['token' => $token, 'agent' => 'agent'],
                    function ($message) use ($request) {
                    $message->to($request->email);
                    $message->subject('Email Verification');
                });
                $updates['token'] = $token;
                $updates['status'] = 0;
                $updates['email'] = $request->email;
            } catch (\Exception) {
                return back()->with('error', 'Failed to send verification email. Please try again later.');
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
        if ($emailChanged || $request->filled('password')) {
            Auth::guard('agent')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $message = $emailChanged
            ? 'Sensitive credentials were changed. Verification email has been sent to your email address.'
            : 'Sensitive credentials were changed. Please log in again.';
            return redirect()->route('agent.login')->with('success', $message);
        };
        return back()->with('success', 'Profile updated successfully.');
    }
}
