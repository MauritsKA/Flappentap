<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Userdelete extends Mailable
{
    use Queueable, SerializesModels;
    public $removeduser;
    public $url;
    public $balance;
    public $editor;
    public $admin;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($editor,$balance,$url,$removeduser,$admin)
    {
        $this->editor = $editor;
        $this->balance = $balance;
        $this->url = $url;
        $this->removeduser = $removeduser;
        $this->admin = $admin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('A request to remove '. $this->removeduser->name. ' from \''.$this->balance->name.'\'')
            ->markdown('emails.removal');
    }
}
