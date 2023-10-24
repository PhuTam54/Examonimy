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
            ->get();

        $exam_results = null;
        foreach ($enrollments as $enrollment) {
            $exam_results = ExamResult::where("enrollment_id", $enrollment->id)
                ->orderBy("id", "desc")
                ->get();
        }

        return view("pages.result.my-result",
            compact("enrollments", "exam_results", "total_score"));
    }

    public function examRetaken(Exam $exam) {
        $student = auth()->user();
        $enrollment = Enrollment::where('student_id', $student->id)
            ->where("exam_id", $exam->id)
            ->orderBy("id", "desc")
            ->first();

        // Update status to retaken
        $enrollment->update([
            "status", Enrollment::RETAKEN
        ]);

        // Create new enrollment with attempt = 2
        Enrollment::create([
            'student_id' => $student->id,
            'exam_id' => $exam->id,
            'status' => Enrollment::PENDING,
            'attempt' => $enrollment->attempt + 1
        ]);

        return redirect()->back()->with("retaken", "You have been retaken $exam->exam_name. We'll send you an email when your exam get started!");
    }
}
