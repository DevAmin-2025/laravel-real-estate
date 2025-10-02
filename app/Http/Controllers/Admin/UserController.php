<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $users = User::latest()->get();
        return view('admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.user.create');
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
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|regex:/^[0-3]\d{8}$/|unique:users,phone',
            'password' => 'required|min:6|confirmed',
        ]);

        $fileName = null;
        if ($request->file('photo')) {
            $fileName = Carbon::now()->micro . '-' . $request->photo->getClientOriginalName();
            $request->photo->storeAs('user-images', $fileName);
        };

        $token = Str::random(64);
        $user = User::create([
            'name' => ucwords($request->name),
            'email' => $request->email,
            'phone' => '09' . $request->phone,
            'password' => Hash::make($request->password),
            'photo' => $fileName,
            'token' => $token,
        ]);

        try {
            Mail::send(
                'email.register_email',
                [
                    'token' => $token,
                    'adminUser' => $user,
                    'request' => $request,
                ],
                function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Email Verification');
            });
            return redirect()->route('admin.users.index')->with('success', 'Verification email has been sent to user\'s email address.');
        } catch (\Exception) {
            $user->forceDelete();
            return back()->with('error', 'Failed to send verification email. Please try again later.');
        };
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'photo' => 'nullable|image|max:2048',
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|regex:/^[0-3]\d{8}$/|unique:users,phone,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'status' => 'required',
        ]);

        $updates = [
            'status' => $request->status,
        ];

        if (
            $request->filled('password')
            || $request->name != $user->name
            || $request->email != $user->email
            || $request->phone != substr($user->phone, 2)
        ) {
            try {
                Mail::send(
                    'email.admin_user_edit',
                    [
                        'user' => 'user',
                        'request' => $request,
                    ],
                    function ($message) use ($request) {
                    $message->to($request->email);
                    $message->subject('Account Information Updated');
                });
                $updates['name'] = ucwords($request->name);
                $updates['email'] = $request->email;
                $updates['phone'] = '09' . $request->phone;
                if (Auth::guard('web')->id() == $user->id) {
                    Auth::guard('web')->logout();
                };
            } catch (\Exception) {
                return back()->with('error', 'Failed to send email. Please try again later.');
            };
        };
        if ($request->filled('password')) {
            $updates['password'] = Hash::make($request->password);
        };
        if ($request->file('photo')) {
            Storage::delete('user-images/' . $user->photo);
            $fileName = Carbon::now()->micro . '-' . $request->photo->getClientOriginalName();
            $request->photo->storeAs('user-images', $fileName);
            $updates['photo'] = $fileName;
        };
        $user->update($updates);
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        Storage::delete('user-images/' . $user->photo);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
