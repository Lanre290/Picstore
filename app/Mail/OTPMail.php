<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
        // Generate the OTP and extract the user's name
        $otp = mt_rand(1000, 9999);
        $name = 'Sheriff';  // Hardcoded name or $this->user->name for dynamic

        // Return the view with the necessary data
        return $this->subject('Verify your Email')
                    ->view('auth.otp')
                    ->with([
                        'otp' => $otp,
                        'name' => $name,
                    ]);
    }
}
