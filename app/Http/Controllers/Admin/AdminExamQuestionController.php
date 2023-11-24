<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExamQuestion;
use App\Models\Question;
use Illuminate\Http\Request;

class AdminExamQuestionController extends Controller
{

    // ExamQuestions
    public function examquestion() {
        $questions = Question::where("exam_question_id", "=", null)->orderBy("id","desc")->get();
        $examquestions = ExamQuestion::orderBy("id","desc")->get();
        return view("pages.admin.examquestion.admin-examquestion", compact("examquestions", "questions"));
    }

    public function examquestionDetails(ExamQuestion $examquestion) {
        return view("pages.admin.examquestion.examquestion-details")->with('examquestion', $examquestion);
    }

    public function examquestionAdd() {
        return view("pages.admin.examquestion.examquestion-add");
    }

    public function examquestionStore(Request $request) {
        $request->validate([
            "examquestion_name"=> "required | min:3",
            "description"=> "required",
            "total_mark"=> "required | numeric | min: 1",
            "passing_mark"=> "required | numeric | min: 1",
            "number_of_question"=> "required | numeric | min: 1",
            "durationHour"=> "required",
            "durationMinute"=> "required",
            "durationSecond"=> "required",
        ]);
        try {
            // Lấy giá trị time từ request
            $hour = $request->get("durationHour");
            $minute = $request->get("durationMinute");
            $second = $request->get("durationSecond");

            // get duartion
            $duration = $hour * 3600 + $minute * 60 + $second;

            // get status
            $status = ExamQuestion::PENDING;

            // create new examquestion
            ExamQuestion::create([
                "exam_question_name" => $request->get("examquestion_name"),
                "exam_question_description"=>$request->get("description"),
                "total_marks"=>$request->get("total_mark"),
                "passing_marks"=>$request->get("passing_mark"),
                "number_of_questions"=>$request->get("number_of_question"),
                "duration"=> $duration,
                "status"=>$status,
            ]);

            return redirect()->to("admin/admin-examquestion")->with("add-success", "Add new examquestion successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function examquestionEdit(ExamQuestion $examquestion) {
        // get duartion
        $duration = $examquestion->duration;

        if($duration / 3600 > 1) {
            $hour = floor($duration / 3600);
            $minute = floor($duration % 3600 / 60);
            $second = $duration % 60;
        }
        else if(($duration % 3600) / 60 > 1) {
            $hour = 0;
            $minute = floor($duration % 3600 / 60);
            $second = 0;
        }
        else if($duration % 60 > 1) {
            $hour = 0;
            $minute = 0;
            $second = $duration % 60;
        }

        return view("pages.admin.examquestion.examquestion-edit",
            compact("examquestion", "hour", "minute", "second"));
    }

    public function examquestionUpdate(Request $request, ExamQuestion $examquestion) {
        $request->validate([
            "examquestion_name"=> "required | min:3",
            "description"=> "required",
            "total_mark"=> "required | numeric | min: 1",
            "passing_mark"=> "required | numeric | min: 1",
            "number_of_question"=> "required | numeric | min: 1",
            "durationHour"=> "required",
            "durationMinute"=> "required",
            "durationSecond"=> "required",
        ]);
        try {
            // Lấy giá trị time từ request
            $hour = $request->get("durationHour");
            $minute = $request->get("durationMinute");
            $second = $request->get("durationSecond");

            // get duartion
            $duration = $hour * 3600 + $minute * 60 + $second;

            // update examquestion
            $examquestion->update([
                "exam_question_name" => $request->get("examquestion_name"),
                "exam_question_description"=>$request->get("description"),
                "total_marks"=>$request->get("total_mark"),
                "passing_marks"=>$request->get("passing_mark"),
                "number_of_questions"=>$request->get("number_of_question"),
                "duration"=> $duration,
            ]);

            return redirect()->to("admin/admin-examquestion")->with("edit-success", "Edit examquestion successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function examquestionDelete(ExamQuestion $examquestion) {
        try {
            // delete examquestion
            $to_delete_examquestion = ExamQuestion::find($examquestion->id);
            $to_delete_examquestion->delete();
            return redirect()->to("admin/admin-examquestion")->with("delete-success", "Delete examquestion successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function examquestionConfirm(ExamQuestion $examquestion) {
        try {
            // confirm examquestion
            $examquestion->update([
                "status"=> ExamQuestion::CONFIRMED,
            ]);
            return redirect()->to("admin/admin-examquestion")->with("edit-success", "Edit examquestion successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function examquestionCancel(ExamQuestion $examquestion) {
        try {
            // cancel examquestion
            $examquestion->update([
                "status"=> ExamQuestion::CANCELED,
            ]);
            return redirect()->to("admin/admin-examquestion")->with("edit-success", "Edit examquestion successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function examquestionTrash() {
        $examquestions = ExamQuestion::onlyTrashed()->orderBy("id","desc")->get();
        $questions = Question::where("exam_question_id", "=", null)->get();
        return view("pages.admin.examquestion.admin-examquestion", compact("examquestions", "questions"));
    }

    public function examquestionRecover(ExamQuestion $examquestion) {
        try {
            // recover examquestion
            $examquestion->update([
                "deleted_at"=> null,
            ]);
            return redirect()->to("admin/admin-examquestion")->with("recover-success", "Recover examquestion $examquestion->examquestion_name successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function examQuestionAddQuestion(Request $request) {
        $questionIds = $request->get("questions");
        $examquestionId = $request->get("examquestion_id");
        foreach ($questionIds as $questionId) {
            $question = Question::find($questionId);
            $question->update([
                "exam_question_id" => $examquestionId
            ]);
        }
        return redirect()->to("admin/admin-examquestion")->with("addQuestion-success", "Add question successfully!!!");
    }

    public function examQuestionDeleteQuestion(Question $question) {
        $question->update([
            "exam_question_id" => null
        ]);
        return redirect()->to("admin/admin-examquestion")->with("deleteQuestion-success", "Delete question successfully!!!");
    }

}
