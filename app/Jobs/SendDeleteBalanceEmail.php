<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\Mail\Balancedelete;

class SendDeleteBalanceEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;
    
    protected $editor; 
    protected $balance; 
    protected $url; 
    protected $user;
    /**
     * Create a new job instance.
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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new Balancedelete($this->editor,$this->balance,$this->url,$this->user);
        Mail::to($this->user)->send($email); 
    }
}
