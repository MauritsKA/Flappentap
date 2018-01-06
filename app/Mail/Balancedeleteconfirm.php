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

    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($balance,$user)
    {
        $this->balance = $balance;
        $this->user = $user;
     
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdf = base64_encode(getPDF($this->balance,$this->user)->output());
        
        return $this->subject('Confirmation of the removal of \''. $this->balance->name. '\' ')
            ->markdown('emails.deleteconfirm')->attachData(base64_decode($pdf), $this->balance->name.'.pdf');
    }
}


            