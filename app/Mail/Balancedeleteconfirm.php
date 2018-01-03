<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Balancedeleteconfirm extends Mailable
{
    use Queueable, SerializesModels;
    public $balance;
    public $user;
    public $pdf;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($balance,$user,$pdf)
    {
        $this->balance = $balance;
        $this->user = $user;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    
        return $this->subject('Confirmation of the removal of \''. $this->balance->name. '\' ')
            ->markdown('emails.deleteconfirm')->attachData($this->pdf, $this->balance->name.'.pdf');
    }
}
