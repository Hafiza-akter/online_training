<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserVerificationListener
{
   

    public function handle($event)
    {

        \Mail::to($event->user->email)->send(new \App\Mail\EmailController($event));
    
    }
}
