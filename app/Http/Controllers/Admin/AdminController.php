<?php

namespace App\Http\Controllers\Admin;

use App\Events\ConfirmRetakenExam;
use App\Events\CreateNewResult;
use App\Http\Controllers\Controller;
use App\Imports\QnaImport;
use App\Models\Attendance;
use App\Models\Classes;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\EnrollmentAnswer;
use App\Models\ExamQuestion;
use App\Models\Question;
use App\Models\EnrollmentResult;
use App\Models\QuestionOption;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function dashboard() {
        $exams = Exam::all();
        $subjects = Subject::all();
        $users = User::all();
        $classroom = Classes::all();

        // Lấy thời gian hiện tại
        $currentTime = now();
        foreach ($exams as $exam) {
            if ($exam->status == Exam::CONFIRMED && $currentTime >= $exam->start_date && $currentTime <= $exam->end_date) {
                $exam->update([
                    "status" => Exam::PROCESSING
                ]);
            } elseif ($exam->status == Exam::PROCESSING && $currentTime > $exam->end_date) {
                $exam->update([
                    "status" => Exam::COMPLETE
                ]);
            }
        }
        return view("pages.admin.admin-dashboard", compact("exams", "subjects", "users", "classroom"));
    }

    // Answers
    public function answer() {
        $answers = EnrollmentAnswer::orderBy("id","desc")->get();
        return view("pages.admin.answer.admin-answer", compact("answers"));
    }

}
