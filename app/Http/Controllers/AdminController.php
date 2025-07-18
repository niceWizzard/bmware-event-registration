<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('admins.index', compact('users'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user?->is_superadmin) {
            return redirect()->route('admin.index');
        }
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'confirmed', 'email', 'unique:users,email'],
            'password' => ['required'],
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return Redirect::route('admin.index');
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user?->is_superadmin) {
            return redirect()->route('admin.index');
        }
        $autoPassword = Str::random(12);
        return view('admins.create', compact('autoPassword'));
    }

    public function delete(string $id)
    {
        $user = Auth::user();
        if (!$user?->is_superadmin) {
            return redirect()->route('admin.index');
        }
        $userToDelete = User::findOrFail($id);
        if ($userToDelete->id === Auth::id()) {
            return redirect()->route('admin.index');
        }
        $userToDelete->delete();
        return Redirect::route('admin.index');
    }

}
