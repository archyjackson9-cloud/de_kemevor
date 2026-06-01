<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private const EMAIL    = 'admin@thehealingroom.com';
    private const PASSWORD = 'HealAdmin2025';

    public function loginForm()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($request->email === self::EMAIL && $request->password === self::PASSWORD) {
            session(['admin_logged_in' => true, 'admin_email' => $request->email]);
            return redirect()->route('admin.dashboard')
                ->with('success', 'Welcome back, Administrator!');
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_email']);
        return redirect()->route('admin.login')->with('success', 'You have been logged out.');
    }
}
