<?php

namespace App\Http\Controllers\Admin;

use App\Events\ConfirmRetakenExam;
use App\Http\Controllers\Controller;
use App\Models\Enrollment;

class AdminEnrollmentController extends Controller
{

    // Enrollments
    public function enrollment() {
        $enrollments = Enrollment::orderBy("id","desc")->get();
        return view("pages.admin.enrollment.admin-enrollment", compact("enrollments"));
    }

    public function enrollmentConfirm(Enrollment $enrollment) {
        try {
            $enrollment->update([
                'status' => Enrollment::CONFIRMED
            ]);

            // Send mail
            event(new ConfirmRetakenExam($enrollment));

            return redirect()->back()->with("confirm-success", "Confirm enrollment successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function enrollmentCancel(Enrollment $enrollment) {
        try {
            $enrollment->update([
                'status' => Enrollment::CANCELED
            ]);
            return redirect()->back()->with("cancel-success", "Cancel enrollment successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

}
