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
        $total_score = 0;

        $student = auth()->user();
        $enrollments = Enrollment::where('student_id', '=', $student->id)
            ->where("status", Enrollment::COMPLETED)
            ->orderBy("updated_at", "desc")
            ->paginate(5);
//            ->get();

        $exam_results = null;
        foreach ($enrollments as $enrollment) {
            $exam_results = ExamResult::where("enrollment_id", $enrollment->id)
                ->orderBy("id", "desc")
                ->get();

//            foreach ($enrollment->Exam->Questions as $question) {
//                $total_score += $question->question_mark;
//            }
        }

        return view("pages.result.my-result",
            compact("enrollments", "exam_results", "total_score"));
    }
}
