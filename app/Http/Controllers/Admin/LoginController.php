<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
class LoginController extends Controller
{
    public function loginAction(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Attempt to log in the user
        if (Auth::attempt($credentials)) {
            // Authentication passed
            return redirect()->intended('/admin/dashboard'); // Change this to your admin dashboard route
        }

        // Authentication failed
        return back()->withInput($request->only('email', 'remember'))->with('error','Invalid email or password');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('admin.login');

    }
}
