<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;

class OTPMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new message instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $arr = explode(' ', $this->user['name']);
        $name= count($arr) > 1 ? $arr[1] : $arr[0];

        // Return the view with the necessary data
        return $this->subject('Verify your Email')
                    ->view('auth.forgot-password')
                    ->with([
                        'name' => $name,
                    ]);
    }
}
