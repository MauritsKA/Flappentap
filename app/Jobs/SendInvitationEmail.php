<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\Mail\Invitationmail;

class SendInvitationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $tries = 5;
    
    protected $email;
    protected $user;
    protected $url;
    protected $balance;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $user,$balance,$url)
    {
        $this->email = $email;
        $this->user = $user; 
        $this->balance = $balance;
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new Invitationmail($this->user,$this->balance,$this->url);
        Mail::to($this->email)->send($email);
    }
}
