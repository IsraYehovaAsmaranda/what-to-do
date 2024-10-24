<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class registerController extends Controller
{
    public function index()
    {
        return view('pages.auth.register');
    }

    public function registerNewAccount(Request $request)
    {
        // validate the request data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        // create a new user
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Registration failed. Please try again.');
        }

        return redirect('/login')->with('success', 'Registration successful. You can now log in.');
    }
}
