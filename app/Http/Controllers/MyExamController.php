<?php

namespace App\Http\Controllers;

use App\Events\CreateNewResult;
use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\EnrollmentAnswer;
use App\Models\Question;
use App\Models\EnrollmentResult;
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

    public function examInfo($entrance_id) {
        $examination = Exam::where("entrance_id", "=", $entrance_id)->first();
        return view("pages.exam.exam-info", compact("examination"));
    }

    public function examCancel($entrance_id) {
        $examination = Exam::where("entrance_id", "=", $entrance_id)->first();
        $student = auth()->user();
        $enrollment = Enrollment::where('student_id', '=', $student->id)
            ->where('exam_id', $examination->id)
            ->orderBy("id", 'desc')
            ->first();

        // Update enrollment status to Canceled: 4
        $enrollment->update([
            "status" => Enrollment::CANCELED
        ]);
        return redirect()->back()->with("canceled", "You have been canceled $examination->exam_name.");
    }

    public function examTaking($entrance_id) {
        $examination = Exam::where("entrance_id", "=", $entrance_id)->first();
        $questions = Question::where("exam_question_id", $examination->ExamQuestion->id)
//            ->orderBy("question_no")
            ->inRandomOrder()
            ->get();
        return view("pages.exam.exam-taking", // "questionsEasy","questionsMedium", "questionsDifficult",
            compact("examination", "questions"));
    }

    public function mockExamTaking($entrance_id) {
        $examination = Exam::where("entrance_id", "=", $entrance_id)->first();
        $questions = Question::where("exam_question_id", $examination->ExamQuestion->id)
            ->orderBy("id")
            ->get();
        return view("pages.exam.exam-taking", // "questionsEasy","questionsMedium", "questionsDifficult",
            compact("examination", "questions"));
    }

    public function examSubmit(Request $request) {
        // Nhận dữ liệu từ request
        $entrance_id = $request->get('entrance_id');

        $examination = Exam::where("entrance_id", "=", $entrance_id)->first();
        // Get the questions
        $questions = Question::where("exam_question_id", $examination->ExamQuestion->id)
            ->orderBy("question_no")
            ->get();

        // Get the enrollments
        $student = auth()->user();

        $enrollment = Enrollment::where('student_id', '=', $student->id)
            ->where('exam_id', '=', $examination->id)
            ->orderBy('id', 'desc')
            ->first();

        try {
            $correct_counter = 0;
            $incorrect_counter = 0;
            $unanswered_counter = 0;
            $score_counter = 0;
            $total_score = 0;
            $grade = EnrollmentResult::FAIL;
            $note = "Sorry bro, you're failed. You have to learn and keep learning!!!";
            // Question 1
            $answerString = null;
            $isCorrect_total = 0;
            $isCorrect_counter = 0;

            // Check is_correct
            foreach ($questions as $question) {
                if ($question->type_of_question == Question::MULTIPLE_CHOICE) {
                    foreach ($question->QuestionOptions as $option) {
                        // get total is_correct answers
                        if ($option->is_correct) {
                            $isCorrect_total += 1;
                        }

                        // convert answers to array
                        $answers = explode(",", $request->get("multipleChoice-$option->id"));

                        // check options is correct
                        foreach ($answers as $answer) {
                            if ($answer != null) {
                                $isMultipleCorrect = $question->checkChoiceExact($answer);
                                if ($isMultipleCorrect) {
                                    $isCorrect_counter += 1;
                                } else {
                                    $isCorrect_counter -= 1;
                                }

                                // convert answers to string
                                $answerString .= implode(",", $answers) . ',';
                            }
                        }
                    }

                    // get final is_correct
                    if ($isCorrect_counter == $isCorrect_total) {
                        $isCorrect = true;
                    } else {
                        $isCorrect = false;
                    }
                    // Set 0 $isCorrect_counter & $isCorrect_total
                    $isCorrect_counter = 0;
                    $isCorrect_total = 0;

                    // get final answers
                    if ($answerString == null || $answerString == "") {
                        $answers = null;
                    } else {
                        $answers = substr($answerString, 0, -1);
                    }
                    // Set null answer string
                    $answerString = null;

                } elseif ($question->type_of_question == Question::CHOICE) {
                    $answers = $request->get("oneChoice-$question->id");
                    $isCorrect = $question->checkChoiceExact($answers);
                } else {
                    $answers = $request->get("fillInBlank-$question->id");
                    $isCorrect = $question->checkFillInBlankExact($answers);
                }

                // Set answer status
                if ($isCorrect) {
                    $answer_status = EnrollmentAnswer::CORRECT;
                } elseif($answers == null || $answers == "") {
                    $answer_status = EnrollmentAnswer::UNANSWERED;
                } else{
                    $answer_status = EnrollmentAnswer::INCORRECT;
                }

                // create new exam answer
                EnrollmentAnswer::create([
                    "enrollment_id" => $enrollment->id,
                    "question_id" => $question->id,
                    "answers" => $answers,
                    "status" => $answer_status,
                ]);

                // Get total score
                $total_score += $question->question_mark;

                // Get the exam answer to check the score + correct + incorrect
                $enrollment_answers = EnrollmentAnswer::where("enrollment_id", $enrollment->id)
                    ->where("question_id", $question->id)
                    ->orderBy("id", "desc")
                    ->limit(1)
                    ->get();
                foreach ($enrollment_answers as $exam_answer) {
                    if ($exam_answer->status === 1) {
                        $score_counter += $exam_answer->Question->question_mark;
                        $correct_counter ++;
                    } elseif ($exam_answer->status === 2) {
                        $incorrect_counter ++;
                    } else {
                        $unanswered_counter ++;
                    }
                }
            }
            // Get the time taken
            $duration = $request->get("duration");
            $time_counter = $examination->ExamQuestion->duration - $duration;

            // Get the result status
            if ($score_counter >= ($total_score / 1.25)) {
                $grade = EnrollmentResult::EXCELLENT;
                $note = "How did you do that ???";
            } elseif ($score_counter >= ($total_score / 1.5)) {
                $grade = EnrollmentResult::VERYGOOD;
                $note = "You're genius !!!";
            } elseif ($score_counter >= ($total_score / 2)) {
                $grade = EnrollmentResult::GOOD;
                $note = "Congratulation !!!";
            } elseif ($score_counter >= ($total_score / 3)) {
                $grade = EnrollmentResult::ACCEPTABLE;
                $note = "Make more effort !!!";
            }

            // Create new Enrollment Result
            EnrollmentResult::create([
                "enrollment_id" => $enrollment->id,
                "score" => $score_counter,
                "correct" => $correct_counter,
                "incorrect" => $incorrect_counter,
                "unanswered" => $unanswered_counter,
                "time_taken" => $time_counter,
                "grade" => $grade,
                "status" => 0,
                "note" => $note
            ]);

            // Update the status of Enrollment to completed
            $enrollment->status = Enrollment::COMPLETED;
            $enrollment->save();

            return redirect()->to("exam-result/$enrollment->id");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
