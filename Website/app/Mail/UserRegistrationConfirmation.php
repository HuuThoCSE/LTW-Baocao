<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $confirmationUrl;

    public function __construct($user, $confirmationUrl)
    {
        $this->user = $user;
        $this->confirmationUrl = $confirmationUrl;
    }

    public function build()
    {
        return $this->subject('Xác nhận đăng ký tài khoản')
                    ->view('emails.registration-confirmation');
    }
}
