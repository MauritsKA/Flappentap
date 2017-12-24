<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Adminmail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $inviter;
    public $balance;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$balance,$inviter)
    {
        $this->user = $user;
        $this->balance = $balance;
        $this->inviter = $inviter;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this->subject($this->inviter->name. ' added you as admin of \''.$this->balance->name.'\'')
            ->markdown('emails.admin');
    }
}
