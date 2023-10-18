<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamResult;
use Illuminate\Http\Request;

class MyResultController extends Controller
{
    public function myResult() {
        $student = auth()->user();
        $data_wow_delay = -0.1;
        $enrollment = Enrollment::where('student_id', '=', $student->id)
            ->where("status", Enrollment::COMPLETED)
            ->first();

        $exam_results = ExamResult::where("enrollment_id", $enrollment->id)
            ->orderBy("id", "desc")
            ->paginate(5);
        return view("pages.result.my-result", compact("exam_results", "data_wow_delay"));
    }
}
