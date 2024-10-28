<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Exception;

class sendMail implements ShouldQueue
{
    use Queueable;

    private $user,$mail;
    public function __construct($user,$mail)
    {
        $this->user = $user;
        $this->mail = $mail;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {

            Mail::to($this->user)->send($this->mail);

            } catch (Exception $e) {

                return response()->json($e->getMessage());

            }


    }
}
