<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailController extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    public $type;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($listen)
    {
        //
        $this->details = $listen->user;
        $this->type = $listen->type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Online Training Verification')->view('email.verification');
    }
}
