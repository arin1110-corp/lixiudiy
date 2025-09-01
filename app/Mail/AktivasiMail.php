<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AktivasiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;

    public function __construct($token, $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function build()
    {
        return $this->subject('Aktivasi Akun Lixiudiy')
            ->view('emails.aktivasi');
    }
}
