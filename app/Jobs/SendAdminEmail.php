<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\Mail\Adminmail;

class SendAdminEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;
    
    protected $user;
    protected $balance;
    protected $inviter;
    
    /**
     * Create a new job instance.
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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new Adminmail($this->user,$this->balance,$this->inviter);
        Mail::to($this->user)->send($email);
    }
}
