<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailVerifiedController extends Controller
{
    

    public function notice() {
        return view('auth.verify-email');
    }

    public function verify(EmailVerificationRequest $request) {
        $request->fulfill();
        Alert::toast("Email Vérifiée Avec Succès !",'success');
        return redirect('/home');
    }

    public function send(Request $request) {
        $request->user()->sendEmailVerificationNotification();
    
        return back()->with('success', 'Verification link sent!');
    }
}
