<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Balancedelete extends Mailable
{
    use Queueable, SerializesModels;
    public $url;
    public $balance;
    public $editor;
    public $user;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($editor,$balance,$url,$user)
    {
        $this->editor = $editor;
        $this->balance = $balance;
        $this->url = $url;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('A request to remove \''. $this->balance->name. '\' from '.$this->editor->name)
            ->markdown('emails.delete');
    }
}
