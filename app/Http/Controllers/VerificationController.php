<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerificationController extends Controller
{
    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response(['message' => 'Already verified']);
        }

        $request->user()->sendEmailVerificationNotification();

        return response(['message' => 'Verification link sent']);
    }
    public function showVerifyMail()
    {
        return view('auth.verify-email');
    }
    // public function verify(EmailVerificationRequest $request)
    // {
    //     dd('asdsad');
    //     dd($request->all());
    //     if ($request->route('id') == $request->user()->getKey() &&
    //         hash_equals((string) $request->route('hash'), sha1($request->user()->getEmailForVerification()))) {
    //         if ($request->user()->hasVerifiedEmail()) {
    //             return redirect($this->redirectPath());
    //         }

    //         if ($request->user()->markEmailAsVerified()) {
    //             event(new Verified($request->user()));
    //         }

    //         return redirect($this->redirectPath())->with('verified', true);
    //     }

    //     return redirect($this->redirectPath())->with('verified', false);
    // }
}
