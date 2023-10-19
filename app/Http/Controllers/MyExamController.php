<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\ExamAnswer;
use App\Models\ExamQuestion;
use App\Models\ExamResult;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MyExamController extends Controller
{
    public function myExam() {
        $student = auth()->user();
        $data_wow_delay = -0.1;
        $enrollments = Enrollment::where('student_id', '=', $student->id)
            ->where("status", Enrollment::CONFIRMED)
            ->get();
        return view("pages.exam.my-exam", compact("enrollments", "data_wow_delay"));
    }

    public function examInfo(Exam $exam) {
        $examination = Exam::find($exam->id);
        return view("pages.exam.exam-info", compact("examination"));
    }

    public function examTaking(Exam $exam) {
        $question_counter = 0; //
//        $questionsEasy = ExamQuestion::where("exam_id", $exam->id)
//            ->where("difficulty", ExamQuestion::EASY)->get();
//
//        $questionsMedium = ExamQuestion::where("exam_id", $exam->id)
//            ->where("difficulty", ExamQuestion::MEDIUM)->get();
//
//        $questionsDifficult = ExamQuestion::where("exam_id", $exam->id)
//            ->where("difficulty", ExamQuestion::DIFFICULT)->get();
        $questions = ExamQuestion::where("exam_id", $exam->id)
            //->where("type_of_question", 1)
            ->orderBy("difficulty")
//            ->paginate(1);
            ->get();
        $examination = Exam::find($exam->id);
        return view("pages.exam.exam-taking", // "questionsEasy","questionsMedium", "questionsDifficult",
            compact("examination", "questions",
                "question_counter"));
    }

    public function examSubmit(Request $request, Exam $exam) {
        $questions = ExamQuestion::where("exam_id", $exam->id)
            //->where("type_of_question", 1)
            ->orderBy("difficulty")
//            ->paginate(1);
            ->get();
        $student = auth()->user();
        $enrollment = Enrollment::where('student_id', '=', $student->id)
            ->where('exam_id', '=', $exam->id)
            ->first();

        try {
//            $status = 0;
            $answerString = null;
            $isCorrect = false;
            // Check is_correct
//                if ($question->type_of_question == 1) {
//                    foreach ($question->QuestionOptions as $option) {
//                        $answers = explode(",", $request->get("multipleChoice-$option->id"));
//                        $isCorrect = $question->checkMultipleChoiceExact($answers);
//                        echo $isCorrect;
//                        $answerString = implode(",", $answers);
//                        echo $answerString; //...
//                    }
//                    dd($isCorrect);
            foreach ($questions as $question) {
                if ($question->type_of_question == 1) {
                    $isCorrect = true;
                    foreach ($question->QuestionOptions as $option) {
                        $answers = explode(",", $request->get("multipleChoice-$option->id"));

                        foreach ($answers as $answer) {
                            if ($answer != null && $answer != "") {
                                $isThisCorrect = $question->checkChoiceExact($answer);

                                echo "Is correct: ". $isCorrect;
//                                $answerString = implode(",", $answers);
//                                echo " Answers: ".$answerString; //...
                                $answerString = implode(",", $answers);
                                echo " Answers: ".$answerString; //...
                            }
                        }
//                    dd($isCorrect);
                    }
                    $answers = $answerString;
//                    $answerString = implode(",", $answers);
//                    echo $answerString; //...
//                    }
//                    dd($isCorrect);
//                    break;
                } elseif ($question->type_of_question == 2) {
                    $answers = $request->get("oneChoice-$question->id");
                    if ($answers != null) {
                        $isCorrect = $question->checkChoiceExact($answers);
                    }
                } else {
                    $answers = $request->get("fillInBlank-$question->id");
                    if ($answers != null) {
                        $isCorrect = $question->checkFillInBlankExact($answers);
                    }
                }

                // Set status
                if ($answers == null) {
                    $status = 0;
                } elseif ($isCorrect) {
                    $status = 1;
                } else {
                    $status = 2;
                }
//                dd($status);
                // create new exam answer
                ExamAnswer::create([
                    "enrollment_id" => $enrollment->id,
                    "question_id" => $question->id,
                    "answers" => $answers,
                    "status" => $status,
                ]);
//                dd($isCorrect);
            }
//            dd($status);
            return redirect()->to('exam-result/'.$exam->id)
                ->with("exam-submit-success" , "Submit exam successfully!!!");

        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function examResult(Exam $exam) {
        $correct_counter = 0;
        $incorrect_counter = 0;
        $score_counter = 0;
        $total_score = 0;
        $time_counter = 0;
        $status = 1;

        $examination = Exam::find($exam->id);
        $questions = ExamQuestion::where("exam_id", $exam->id)
            ->orderBy("difficulty")
            //->where("type_of_question", 1)
//            ->paginate(1);
            ->get();
        $student = auth()->user();
        $enrollment = Enrollment::where('student_id', '=', $student->id)
            ->where('exam_id', '=', $exam->id)
            ->first();

        $answer_limit = $questions->count();
        foreach ($questions as $question) {
            $total_score += $question->question_mark;
            $exam_answers = ExamAnswer::where("enrollment_id", $enrollment->id)
                ->where("question_id", $question->id)
                ->orderBy("id", "desc")
                ->limit(1)
                ->get();

            foreach ($exam_answers as $exam_answer) {
                if ($exam_answer->status === 1) {
                    $score_counter += $exam_answer->Question->question_mark;
                    $correct_counter += 1;
                } elseif($exam_answer->status === 2) {
                    $incorrect_counter += 1;
                } else {
                    $incorrect_counter += 1;
//                    dd($exam_answer);
                }
            }
        }

        // Get the time ( test )
        $time_counter = $examination->duration;

        // Get the status ( test )
        if($score_counter > ($total_score / 1.3)) {
            $status = ExamResult::EXCELLENT;
        } elseif($score_counter >= ($total_score / 1.6)) {
            $status = ExamResult::VERYGOOD;
        } elseif($score_counter >= ($total_score / 1.9)) {
            $status = ExamResult::GOOD;
        } elseif($score_counter >= ($total_score / 2.2)) {
            $status = ExamResult::ACCEPTABLE;
        }else {
            $status = ExamResult::FAIL;
        }

        // Create new Result
        $exam_result = ExamResult::create([
            "enrollment_id" => $enrollment->id,
            "score" => $score_counter,
            "time_taken" => $time_counter,
            "status" => $status,
            "note" => "This is a note for you."
        ]);

        // Update the status of Enrollment to completed
        $enrollment->status = Enrollment::COMPLETED;
        $enrollment->save();

        return view("pages.exam.exam-result",
            compact("examination", "exam_result",
                "correct_counter","incorrect_counter", "total_score"));
    }
}
