<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('pages.auth.login');
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|min:8',
        ]);

        try {
            $login = Auth::attempt(['email' => $request->email, 'password' => $request->password]);
            if ($login) {
                return redirect('/')->with('success', 'Login successful.');
            }
            return redirect()->back()->withErrors('Invalid email or password. Please try again.');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Login failed. Please try again.');
        }
    }
}
