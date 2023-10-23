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
use function Webmozart\Assert\Tests\StaticAnalysis\integer;
use function Webmozart\Assert\Tests\StaticAnalysis\length;

class MyExamController extends Controller
{
    public function myExam() {
        $student = auth()->user();
        $data_wow_delay = -0.1;
        $enrollments = Enrollment::where('student_id', '=', $student->id)
            ->where("status", Enrollment::CONFIRMED)
            ->orderBy('id', 'desc')
            ->get();
        return view("pages.exam.my-exam", compact("enrollments", "data_wow_delay"));
    }

    public function examInfo(Exam $exam) {
        $examination = Exam::find($exam->id);
        return view("pages.exam.exam-info", compact("examination"));
    }

    public function examCancel(Exam $exam) {
        $student = auth()->user();
        $enrollment = Enrollment::where('student_id', '=', $student->id)
            ->where('exam_id', $exam->id)
            ->orderBy("id")
            ->first();

        // Update enrollment status to Canceled: 4
        $enrollment->update([
            "status" => Enrollment::CANCELED
        ]);
        return redirect()->back()->with("canceled", "You have been canceled $exam->exam_name.");
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
            ->orderBy("difficulty")
            ->get();
        $examination = Exam::find($exam->id);
        return view("pages.exam.exam-taking", // "questionsEasy","questionsMedium", "questionsDifficult",
            compact("examination", "questions",
                "question_counter"));
    }

    public function examSubmit(Request $request, Exam $exam) {
        // Get the questions
        $questions = ExamQuestion::where("exam_id", $exam->id)
            ->orderBy("difficulty")
            ->get();

        // Get the enrollments
        $student = auth()->user();
        $examination = Exam::find($exam->id);

        $enrollment = Enrollment::where('student_id', '=', $student->id)
            ->where('exam_id', '=', $examination->id)
            ->orderBy('id', 'desc')
            ->first();

//        dd($enrollment);
        try {
//            $answer_status = 0;
            $correct_counter = 0;
            $incorrect_counter = 0;
            $score_counter = 0;
            $total_score = 0;
//            $time_counter = 0;
            $result_status = ExamResult::FAIL;
            // Question 1
            $answerString = null;
            $isCorrect = true;
            $isCorrect_total = 0;
            $isCorrect_counter = 0;

            // Check is_correct

//            foreach ($question->QuestionOptions as $option) {
//                $answers = explode(",", $request->get("multipleChoice-$option->id"));
//                $isCorrect = $question->checkMultipleChoiceExact($answers);
//            }

            foreach ($questions as $question) {
                if ($question->type_of_question == ExamQuestion::MULTIPLE_CHOICE) {
                    foreach ($question->QuestionOptions as $option) {
                        // get total is_correct answers
                        if ($option->is_correct) {
                            $isCorrect_total += 1;
                        }

                        //echo 'Iscorrect: '.$option->is_correct.'<br>';
                        //echo 'Iscorrect Total: '.$isCorrect_total.'<br>';
                        // convert answers to array
                        $answers = explode(",", $request->get("multipleChoice-$option->id"));

                        // check options is correct
                        foreach ($answers as $key => $answer) {
                            if ($answer != null) {
                                $isMultipleCorrect = $question->checkChoiceExact($answer);
//                                //echo " Answer: ". $answer.'<br>';
//                                foreach ($isMultipleCorrect as $isEachCorrect) {
                                if ($isMultipleCorrect) {
                                    $isCorrect_counter += 1;
                                } else {
                                    $isCorrect_counter -= 1;
                                }
                                //echo 'Iscorrect Counter: '.$isCorrect_counter.'<br>';

                                // convert answers to string
                                $answerString .= implode(",", $answers).',';
                                //echo "Answers: ".$answerString; //...
                                //echo " - Is correct: ". $isMultipleCorrect.'<br>';
                            }
                        }

//                    dd($isCorrect);
                    }

                    // get final is_correct
                    if ($isCorrect_counter == $isCorrect_total) {
                        $isCorrect = true;
                    } else {
                        $isCorrect = false;
                    }
                    //echo 'Iscorrect Final: '.$isCorrect.'<br>';
                    // Set 0 $isCorrect_counter & $isCorrect_total
                    $isCorrect_counter = 0;
                    $isCorrect_total = 0;

                    //echo "End foreach".'<br>';
//                    $isCorrect = $isMultipleCorrect;
//                    //echo "Final isCorrect: ".$isCorrect;

                    // get final answers
                    if ($answerString == null || $answerString == "") {
                        $answers = null;
                    } else {
                        $answers = substr($answerString, 0, -1);
                    }
                    // Set null answer string
                    $answerString = null;

                    //echo "Final answer: ".$answers;
//                    //echo " - Final Answers: ".$answers;
//                    $answerString = implode(",", $answers);
//                    //echo $answerString; //...
//                    }
//                    dd($isCorrect);
//                    break;
                } elseif ($question->type_of_question == ExamQuestion::CHOICE) {
                    $answers = $request->get("oneChoice-$question->id");
                    $isCorrect = $question->checkChoiceExact($answers);
                } else {
                    $answers = $request->get("fillInBlank-$question->id");
                    $isCorrect = $question->checkFillInBlankExact($answers);
                }

                // Set answer status
                if ($isCorrect) {
                    $answer_status = 1;
                } else{
                    $answer_status = 2;
                }
//                dd($answer_status);
//
                // create new exam answer
                ExamAnswer::create([
                    "enrollment_id" => $enrollment->id,
                    "question_id" => $question->id,
                    "answers" => $answers,
                    "status" => $answer_status,
                ]);
//                dd($isCorrect);

                // Get total score
                $total_score += $question->question_mark;

                // Get the exam answer to check the score + correct + incorrect
                $exam_answers = ExamAnswer::where("enrollment_id", $enrollment->id)
                    ->where("question_id", $question->id)
                    ->orderBy("id", "desc")
                    ->limit(1)
                    ->get();
                foreach ($exam_answers as $exam_answer) {
                    if ($exam_answer->status === 1) {
                        $score_counter += $exam_answer->Question->question_mark;
                        $correct_counter += 1;
                    } else {
                        $incorrect_counter += 1;
//                    dd($exam_answer);
                    }
                }
                //echo '<br>'."Final Answer status: ".$answer_status.'<br>';
            }
//            dd($answer_status);

            // Get the time taken
            $duration = $request->get("duration");
            $time_counter = $examination->duration - $duration;

            // Get the result status
            if($score_counter >= ($total_score / 1.25)) {
                $result_status = ExamResult::EXCELLENT;
            } elseif($score_counter >= ($total_score / 1.5)) {
                $result_status = ExamResult::VERYGOOD;
            } elseif($score_counter >= ($total_score / 2)) {
                $result_status = ExamResult::GOOD;
            } elseif($score_counter >= ($total_score / 3)) {
                $result_status = ExamResult::ACCEPTABLE;
            }

            // Create new Exam Result
            $exam_result = ExamResult::create([
                "enrollment_id" => $enrollment->id,
                "score" => $score_counter,
                "time_taken" => $time_counter,
                "status" => $result_status,
                "note" => Null
            ]);

            // Update the status of Enrollment to completed
            $enrollment->status = Enrollment::COMPLETED;
            $enrollment->save();

            return view("pages.exam.exam-result", compact("examination","exam_result",
                "correct_counter","incorrect_counter", "total_score"))
                ->with("exam-submit-success" , "Submit exam successfully!!!");

        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
