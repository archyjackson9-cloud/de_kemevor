<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminPasswordResetCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
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

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
        }

        session([
            'admin_logged_in' => true,
            'admin_email'     => $user->email,
            'admin_name'      => $user->name,
            'admin_user_id'   => $user->id,
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Welcome back, ' . $user->name . '!');
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_email', 'admin_name', 'admin_user_id']);
        return redirect()->route('admin.login')->with('success', 'You have been logged out.');
    }

    // ── Forgot Password ───────────────────────────────────────────────────

    public function forgotPasswordForm()
    {
        return view('admin.forgot-password');
    }

    public function sendResetCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No admin account found with that email.'])->withInput();
        }

        $code = (string) random_int(100000, 999999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            ['token' => Hash::make($code), 'created_at' => now()]
        );

        Mail::to($user->email)->send(new AdminPasswordResetCode($code));

        return redirect()->route('admin.password.reset.form', ['email' => $user->email])
            ->with('success', 'A 6-digit reset code has been sent to your email.');
    }

    public function resetPasswordForm(Request $request)
    {
        return view('admin.reset-password', ['email' => $request->query('email')]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'code'     => 'required|digits:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record || !Hash::check($request->code, $record->token)) {
            return back()->withErrors(['code' => 'Invalid or expired reset code.'])->withInput();
        }

        if (now()->diffInMinutes($record->created_at) > 15) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['code' => 'This reset code has expired. Please request a new one.'])->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No admin account found with that email.'])->withInput();
        }

        $user->update(['password' => $request->password]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('admin.login')->with('success', 'Your password has been reset. Please sign in.');
    }
}
