<?php

namespace App\Http\Controllers\Admin;

use App\Events\CreateNewResult;
use App\Http\Controllers\Controller;
use App\Models\EnrollmentResult;

class AdminResultController extends Controller
{

    // Exam Result
    public function result() {
        $results = EnrollmentResult::orderBy("created_at","desc")->get();
        return view("pages.admin.result.admin-result", compact("results"));
    }

    public function resultApprove(EnrollmentResult $result) {
        $result->update([
            "status" => EnrollmentResult::APPROVED
        ]);
        // Send mail
        event(new CreateNewResult($result));
        return redirect()->back()->with("approve-success", "Approve result successfully!!!");
    }

    public function resultDecline(EnrollmentResult $result) {
        $result->update([
            "status" => EnrollmentResult::DECLINED
        ]);
        return redirect()->back()->with("decline-success", "Decline result successfully!!!");
    }

}
