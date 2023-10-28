<?php

namespace App\Listeners;

use App\Events\CreateNewResult;
use App\Mail\ResultMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class DispatchNewResult
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CreateNewResult $event): void
    {
        $result = $event->result;
        // send mail
        Mail::to($result->Enrollment->User->email)
//            ->cc("mail nhan vien")
//            ->bcc("mail quan ly")
            ->send(new ResultMail($result));
    }
}
