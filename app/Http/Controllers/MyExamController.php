<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\ExamAnswer;
use App\Models\ExamQuestion;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MyExamController extends Controller
{
    public function myExam(User $student) {
        $data_wow_delay = -0.1;
        $enrollments = Enrollment::where('student_id', '=', $student->id)->get();
        return view("pages.my-exam", compact("enrollments", "data_wow_delay"));
    }

    public function examInfo(Exam $exam) {
        $examination = Exam::find($exam->id);
        return view("pages.exam-info", compact("examination"));
    }

    public function examTaking(Exam $exam, Request $request) {
        $question_counter = 0;
        $correct_counter = 0;
        $incorrect_counter = 0;
        $score_counter = 0;
        $total_score = 0;

//        $questionsEasy = ExamQuestion::where("exam_id", $exam->id)
//            ->where("difficulty", ExamQuestion::EASY)->get();
//
//        $questionsMedium = ExamQuestion::where("exam_id", $exam->id)
//            ->where("difficulty", ExamQuestion::MEDIUM)->get();
//
//        $questionsDifficult = ExamQuestion::where("exam_id", $exam->id)
//            ->where("difficulty", ExamQuestion::DIFFICULT)->get();

        $questions = ExamQuestion::where("exam_id", $exam->id)
//            ->where("type_of_question", 2)
            ->orderBy("difficulty")
//            ->paginate(1);
//            ->limit(1)
            ->get(); //

        foreach ($questions as $question) {
            $total_score += $question->question_mark;
        }

//        $answer = ExamAnswer::find("question_id", $questions->id);
//        $options = $answer->Options;

        $examination = Exam::find($exam->id);
        return view("pages.exam-taking", // "questionsEasy","questionsMedium", "questionsDifficult",
            compact("examination", "questions",
                "question_counter", "correct_counter", "incorrect_counter",
                "request", "score_counter", "total_score"));
    }

    public function examSubmit(Request $request, Exam $exam) {

//        $question = ExamQuestion::where("exam_id", $exam->id)
//            ->where("type_of_question", 2)
//            ->orderBy("difficulty")
//            ->limit(1)
//            ->get(); //paginate(1)

//        $answerId = 26; // Giả sử câu trả lời được chọn có ID là 26
//        $isCorrect = $question->checkRadioExact($answerId);

//        dd($isCorrect);

//        $cart = session()->has("cart")?session("cart"):[];
//        foreach($cart as $item) {
//            if($item->id == $exam->id) {
//                session(["cart"=>$cart]);
//                return redirect()->back()->with("success", "Submit successfully!");
//            }
//        }
//        $cart[] = $exam;
//        session(["cart"=>$cart]);
//        return redirect()->back()->with("success", "Submit successfully!");

//        $request->validate([
//            "checkbox123"=> "required",
//        ],[
//            "required"=>"Please choose the answer before submit."
//        ]);

//        $student = auth()->user()->id;
//        $enrollment = Enrollment::where('student_id', '=', $student->id)
//                                    ->where('exam_id', '=', $exam->id)->get();
//
//        if (0) {
//            $status = 0;
//        } elseif (1) {
//            $status = 1;
//        } else {
//            $status = 2;
//        }

        try {
//            // create new exam answer
//            ExamAnswer::create([
//                "enrollment_id"=> $enrollment->id,
////                "option_id"=>$request->get("course"),
//                "answer_text"=>$request->get("answer_text"),
//                "status"=>$status,
//            ]);

            return redirect()->back()->with("exam-submit-success", "Submit exam successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function submit() {
        return redirect()->back()->with("exam-submit-success", "Submit exam successfully!!!");
    }
}
