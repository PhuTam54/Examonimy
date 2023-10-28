<?php

namespace App\Listeners;

use App\Events\ConfirmRetakenExam;
use App\Mail\ConfirmRetakenMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class DispatchConfirmRetakenExam
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
    public function handle(ConfirmRetakenExam $event): void
    {
        $retakenEnrollment = $event->retakenEnrollment;
        // send email
        Mail::to($retakenEnrollment->User->email)
//            ->cc("mail nhan vien")
//            ->bcc("mail quan ly")
            ->send(new ConfirmRetakenMail($retakenEnrollment));
    }
}
