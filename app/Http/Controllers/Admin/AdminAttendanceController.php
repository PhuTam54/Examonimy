<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;

class AdminAttendanceController extends Controller
{

    // Attendances
    public function attendance() {
        $attendances = Attendance::all();
        return view("pages.admin.attendance.admin-attendance", compact("attendances"));
    }

}
