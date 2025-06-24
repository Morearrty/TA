<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form.
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send password reset link.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email tidak terdaftar di sistem kami.'
        ]);

        // Generate token
        $token = Str::random(64);
        $email = $request->email;

        // Save token in password_resets table
        PasswordReset::updateOrCreate(
            ['email' => $email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        // Get reset password URL with token
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $email]);

        // Send email with password reset link
        // In a real system, you would use Laravel's Mail functionality
        // For now, we'll store the reset URL in session for demo purposes
        session()->flash('reset_link', $resetUrl);

        return redirect()->route('password.email.sent')
            ->with('success', 'Link reset password telah dikirim ke email Anda.');
    }

    /**
     * Show confirmation page that reset link has been sent.
     */
    public function emailSent()
    {
        return view('auth.email-sent');
    }

    /**
     * Show password reset form.
     */
    public function showResetForm(Request $request)
    {
        $token = $request->token;
        $email = $request->email;

        // Validate token
        $passwordReset = PasswordReset::where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$passwordReset) {
            return redirect()->route('password.request')
                ->with('error', 'Token reset password tidak valid.');
        }

        // Check if token is expired (default: 60 minutes)
        $createdAt = Carbon::parse($passwordReset->created_at);
        if (Carbon::now()->diffInMinutes($createdAt) > 60) {
            return redirect()->route('password.request')
                ->with('error', 'Token reset password telah kedaluwarsa. Silakan meminta link baru.');
        }

        return view('auth.reset-password', compact('token', 'email'));
    }

    /**
     * Reset the password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $token = $request->token;
        $email = $request->email;
        $password = $request->password;

        // Validate token
        $passwordReset = PasswordReset::where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$passwordReset) {
            return redirect()->route('password.request')
                ->with('error', 'Token reset password tidak valid.');
        }

        // Update user password
        $user = User::where('email', $email)->first();
        $user->password = Hash::make($password);
        $user->save();

        // Update member's registration_password if exists
        if ($user->member) {
            $user->member->registration_password = $password;
            $user->member->save();
        }

        // Delete token
        PasswordReset::where('email', $email)->delete();

        return redirect()->route('login')
            ->with('success', 'Password Anda telah berhasil diubah. Silakan login dengan password baru Anda.');
    }
}
