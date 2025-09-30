<?php

namespace App\Http\Controllers\Front\User;

use Carbon\Carbon;
use App\Models\User;
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
     * Show the profile edit form for the authenticated user.
     *
     * @return View
     */
    public function editProfile(): View
    {
        $user = Auth::guard('web')->user();
        return view('front.user.dashboard.edit_profile', compact('user'));
    }

    /**
     * Handle profile update submission for the given user.
     *
     * Validates input, updates profile fields, handles photo upload,
     * and manages sensitive changes like email and password.
     * If email or password changes, sends verification email and logs out the user.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function editProfileSubmit(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|regex:/^[0-3]\d{8}$/|unique:users,phone,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'photo' => 'nullable|image|max:2048',
        ]);

        $emailChanged = $request->email !== $user->email;
        if ($emailChanged) {
            $token = Str::random(64);
            try {
                Mail::send(
                    'email.register_email',
                    ['token' => $token, 'user' => 'user'],
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

        $fileName = $user->photo;
        if ($request->file('photo')) {
            Storage::delete('user-images/' . $user->photo);
            $fileName = Carbon::now()->micro . '-' . $request->photo->getClientOriginalName();
            $request->photo->storeAs('user-images', $fileName);
        };

        $updates['name'] = ucwords($request->name);
        $updates['phone'] = '09' . $request->phone;
        $updates['photo'] = $fileName;
        $user->update($updates);

        if ($emailChanged || $request->filled('password')) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $message = $emailChanged
            ? 'Sensitive credentials were changed. Verification email has been sent to your email address.'
            : 'Sensitive credentials were changed. Please log in again.';
            return redirect()->route('user.login')->with('success', $message);
        };
        return back()->with('success', 'Profile updated successfully.');
    }
}
