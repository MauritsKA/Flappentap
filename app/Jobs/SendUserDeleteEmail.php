<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;
use App\Mail\Userdelete;

class SendUserDeleteEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;
    
    protected $editor;
    protected $balance;
    protected $url;
    protected $removeduser;
    protected $admin;
    
    /**
     * Create a new job instance.
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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new Userdelete($this->editor,$this->balance,$this->url,$this->removeduser,$this->admin);
        Mail::to($this->admin)->send($email);
    }
}
