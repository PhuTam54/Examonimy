<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\Order;
use App\Models\Product;
use App\Models\Question;
use App\Models\EnrollmentResult;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class MyResultController extends Controller
{
    public function myResult() {
        try{
            $total_score = 0;

            $student = auth()->user();
            $enrollments = Enrollment::where('student_id', '=', $student->id)
                ->where("status", Enrollment::COMPLETED)
                ->orderBy("updated_at", "desc")
                ->get();

            $enrollment_results = null;
            foreach ($enrollments as $enrollment) {
                $enrollment_results = EnrollmentResult::where("enrollment_id", $enrollment->id)
                    ->orderBy("id", "desc")
                    ->get();
            }

            return view("pages.result.my-result",
                compact("enrollments", "enrollment_results", "total_score"));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function examRetaken($entrance_id) {
        $exam = Exam::where("entrance_id", "=", $entrance_id)->first();
        try{
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
            $retakenEnrollmentId = Enrollment::insertGetId([
                'student_id' => $student->id,
                'exam_id' => $exam->id,
                'status' => Enrollment::PENDING,
                'attempt' => $enrollment->attempt + 1,
                'is_paid' => false,
                'created_at' => Carbon::now()
            ]);

//            return redirect()->back()->with("retaken", "You have been retaken $exam->exam_name. We'll send you an email when your exam get started!");
//            // Go to Paypal
            return redirect()->to("paypal-process/$retakenEnrollmentId");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function examResult(Enrollment $enrollment) {
        try{
            $enrollment = Enrollment::find($enrollment->id);
            $examination = $enrollment->Exam;
            $enrollment_result = $enrollment->EnrollmentResult;
            $questions = $enrollment->Exam->ExamQuestion->Questions;

            // Get total score
            $total_score = 0;
            foreach ($questions as $question) {
                $total_score += $question->question_mark;
            }

            return view("pages.result.exam-result", [
                "examination" => $examination,
                "enrollment_result" => $enrollment_result,
                "enrollment" => $enrollment,
                "questions" => $questions,
                "total_score" => $total_score,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
