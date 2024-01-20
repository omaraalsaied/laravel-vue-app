<?php

namespace App\Http\Controllers;

use App\Mail\NewOffer;
use App\Models\User;
use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendWelcomeEmail($user)
    {
        Mail::to($user->email)->send(new WelcomeEmail);
    }

    public function SendOffersMail()
    {
        $users = User::all();
        foreach($users as $user)
        {
            Mail::to($user->email)->send(new NewOffer);
        }
    }
}
