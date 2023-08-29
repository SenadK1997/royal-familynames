<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class ForgotPasswordController extends Controller
{
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }
    // public function forgotPassword(Request $request)
    // {

    // }
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);
    }
    protected function broker()
    {
        return Password::broker();
    }

    // Customize the subject and view for reset link email
    protected function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    // Customize the success response for sending reset link
    protected function sendResetLinkResponse($response)
    {
        return back()->with('status', trans($response));
    }

    // Customize the failed response for sending reset link
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()->withErrors(
            ['email' => trans($response)]
        );
    }

    // Customize the reset password form view
    public function showResetForm(Request $request, $token = null)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        return view('auth.reset-password')->with(
            ['token' => $token, 'email' => $request->email, 'user' => $user]
        );
    }

    // Handle password reset process
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
        return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
    }
}
