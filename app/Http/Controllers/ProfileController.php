<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function updateInfo(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->save();

        return Redirect::route('profile.index')->with([
            'message.info' => 'Name changed successfully!',
        ]);
    }

    public function updateEmail(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'confirmed',
                Rule::unique('users')->ignore(Auth::id()),
            ],
        ]);

        $user->email = $request->email;
        $user->email_verified_at = null;
        $user->save();

        return Redirect::route('profile.index')->with([
            'message.email' => 'Email updated successfully!',
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string', 'min:8'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password not correct!',
            ]);
        }
        $user->password = Hash::make($request->password);
        $user->save();

        return Redirect::route('profile.index')->with([
            'message.password' => 'Password changed!',
        ]);
    }

    public function delete(Request $request): RedirectResponse
    {
        $request->validate([
            'delete_password' => ['required', 'string', 'min:8'],
        ]);
        $user = Auth::user();
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'delete_password' => 'Password not correct!',
            ]);
        }
        $user->delete();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::route('login');
    }
}
