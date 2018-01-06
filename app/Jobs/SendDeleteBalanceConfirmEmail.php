<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\Mail\Balancedeleteconfirm;

class SendDeleteBalanceConfirmEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 2;
    
    protected $balance;
    protected $user;  
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($balance,$user)
    {
        $this->balance = $balance;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new Balancedeleteconfirm($this->balance,$this->user);
        Mail::to($this->user)->send($email); 
    }
}
