<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MyEmail;

class EmailController extends Controller
{
    // ------------- [ Send email ] --------------------
    public function sendEmailToUser() {

        $to_email = "emu.cctl@gmail.com";

        Mail::to($to_email)->send(new MyEmail);

        return "<p> Your E-mail has been sent successfully. </p>";

    }
}