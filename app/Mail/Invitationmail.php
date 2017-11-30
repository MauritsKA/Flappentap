<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Invitationmail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $url;
    public $balance;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$balance,$url)
    {
        $this->user = $user;
        $this->balance = $balance;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.invite');
    }
}
