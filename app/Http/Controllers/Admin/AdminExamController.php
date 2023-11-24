<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminExamController extends Controller
{
    // Exams
    public function exam() {
        $exams = Exam::orderBy("id","desc")->get();
        return view("pages.admin.exam.admin-exam", compact("exams"));
    }

    public function examDetails(Exam $exam) {
        return view("pages.admin.exam.exam-details")->with('exam', $exam);
    }

    public function examAdd() {
        $subjects = Subject::all();
        $classes = Classes::all();
        $exam_questions = ExamQuestion::where("status", "=", ExamQuestion::CONFIRMED)->get();
        return view("pages.admin.exam.exam-add",
            compact("subjects", "classes", "exam_questions"));
    }

    public function examStore(Request $request) {
        $request->validate([
            "exam_name"=> "required | min:3",
            "description"=> "required",
            "datetime"=> "required",
            "thumbnail" => "nullable|mimeTypes:image/*|mimes:jpeg,png,jpg,gif|max:2048", // max:2048 là dung lượng tối đa (đơn vị KB)
            "retaken_fee"=> "required | numeric | min: 0",
            "type_of_exam"=> "required",
            "subject"=> "required",
            "classes" => "required",
            "exam_question"=> "required",
        ]);
        try {
            // get instructor
            $instructor = auth()->user()->id;

//             get start date + end date
            // Lấy giá trị datetime từ request
            $dateTime = explode(" - ", $request->get("datetime"));

            // Tách lấy startdate + enddate
            $startDate = $dateTime[0];
            $endDate = $dateTime[1];

            // Tạo đối tượng DateTime với định dạng ban đầu
            $startDateObj = \DateTime::createFromFormat('m/d/Y h:i A', $startDate);
            $endDateObj = \DateTime::createFromFormat('m/d/Y h:i A', $endDate);

            // Chuyển đổi sang định dạng mới
            $newStartDate = $startDateObj->format('Y/m/d H:i:s');
            $newEndDate = $endDateObj->format('Y/m/d H:i:s');

            // Check startDate có legit hay không
            $currentTime = now();
            $validStartDate = $startDateObj->format('Y-m-d H:i:s');
            if ($validStartDate < $currentTime) {
                return redirect()->back()->with("outOfDate", "Please pick the start date in the future.");
            }

            $thumbnail = null;
            // Xử lí upload file
            if ($request->hasFile("thumbnail")) {
                $path = public_path("uploads");
                $file = $request->file("thumbnail");
                $file_name = Str::random(5).time().Str::random(5).".".$file->getClientOriginalExtension();
                $file->move($path, $file_name);
                $thumbnail = "/uploads/".$file_name;
            }

            // get status
            $status = Exam::PENDING;

            // get an unique id
            $entranceId = uniqid("examEntranceId");

            // create new exam
            $examId = Exam::insertGetId([
                "exam_name" => $request->get("exam_name"),
                "exam_description"=>$request->get("description"),
                "exam_thumbnail"=>$thumbnail,
                "retaken_fee"=>$request->get("retaken_fee"),
                "type_of_exam"=>$request->get("type_of_exam"),
                "created_by" => $instructor,
                "subject_id"=>$request->get("subject"),
                "exam_question_id"=>$request->get("exam_question"),
                "entrance_id"=> $entranceId,
                "status"=>$status,
                "start_date"=>$newStartDate,
                "end_date"=>$newEndDate,
            ]);

            // get participants
            $participants = $request->get("classes");
            foreach ($participants as $participant) {
                $classes = Classes::find($participant);
                // Create new Enrollment
                foreach ($classes->Students as $student) {
                    DB::table("enrollments")
                        ->insert([
                            "student_id" => $student->id,
                            "exam_id" => $examId,
                            "status" => Enrollment::PENDING
                        ]);
                }
            }

            return redirect()->to("admin/admin-exam")->with("add-success", "Add new exam successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function examEdit(Exam $exam) {
        $subjects = Subject::all();
        $classes = Classes::all();
        $exam_questions = ExamQuestion::all();

        // Lấy giá trị datetime từ exam
        $startDate = $exam->start_date;
        $endDate = $exam->end_date;

        // Tạo đối tượng DateTime với định dạng ban đầu
        $startDateObj = \DateTime::createFromFormat('Y-m-d H:i:s', $startDate);
        $endDateObj = \DateTime::createFromFormat('Y-m-d H:i:s', $endDate);

        // Chuyển đổi sang định dạng mới
        $newStartDate = $startDateObj->format('m/d/Y h:i A');
        $newEndDate = $endDateObj->format('m/d/Y h:i A');

        return view("pages.admin.exam.exam-edit",
            compact("exam", "subjects", "classes", "exam_questions", "newStartDate", "newEndDate"));
    }

    public function examUpdate(Request $request, Exam $exam) {
        $request->validate([
            "exam_name"=> "required | min:3",
            "description"=> "required",
            "datetime"=> "required",
            "thumbnail" => "nullable|mimeTypes:image/*|mimes:jpeg,png,jpg,gif|max:2048", // max:2048 là dung lượng tối đa (đơn vị KB)
            "retaken_fee"=> "required | numeric | min: 0",
            "type_of_exam"=> "required",
            "subject"=> "required",
            "classes" => "required",
            "exam_question"=> "required",
        ]);
        try {
            $thumbnail = null;
            // Xử lí upload file
            if ($request->hasFile("thumbnail")) {
                $path = public_path("uploads");
                $file = $request->file("thumbnail");
                $file_name = Str::random(5).time().Str::random(5).".".$file->getClientOriginalExtension();
                $file->move($path, $file_name);
                $thumbnail = "/uploads/".$file_name;

                $exam->exam_thumbnail = $thumbnail;
            }

            // get instructor
            $instructor = auth()->user()->id;

            // get start date + end date

            // Lấy giá trị datetime từ request
            $dateTime = explode(" - ", $request->get("datetime"));

            // Tách lấy startdate + enddate
            $startDate = $dateTime[0];
            $endDate = $dateTime[1];

            // Tạo đối tượng DateTime với định dạng ban đầu
            $startDateObj = \DateTime::createFromFormat('m/d/Y h:i A', $startDate);
            $endDateObj = \DateTime::createFromFormat('m/d/Y h:i A', $endDate);

            // Chuyển đổi sang định dạng mới
            $newStartDate = $startDateObj->format('Y/m/d H:i:s');
            $newEndDate = $endDateObj->format('Y/m/d H:i:s');

            // edit exam
            $exam = Exam::find($exam->id);
            $exam->update([
                "exam_name" => $request->get("exam_name"),
                "exam_description"=>$request->get("description"),
                "retaken_fee"=>$request->get("retaken_fee"),
                "type_of_exam"=>$request->get("type_of_exam"),
                "created_by" => $instructor,
                "subject_id"=>$request->get("subject"),
                "exam_question_id"=>$request->get("exam_question"),
                "start_date"=>$newStartDate,
                "end_date"=>$newEndDate,
            ]);
            return redirect()->to("admin/admin-exam")->with("edit-success", "Edit exam successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function examDelete(Exam $exam) {
        try {
            // delete exam
            $to_delete_exam = Exam::find($exam->id);
            $to_delete_exam->delete();
            return redirect()->to("admin/admin-exam")->with("delete-success", "Delete exam successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function examConfirm(Exam $exam) {
        try {
            // confirm exam
            $exam->update([
                "status"=> Exam::CONFIRMED,
            ]);

            $enrollments = Enrollment::where("exam_id", $exam->id)->get();
            foreach ($enrollments as $enrollment) {
                $enrollment->update([
                    "status"=> Enrollment::CONFIRMED,
                ]);
            }

            return redirect()->to("admin/admin-exam")->with("edit-success", "Edit exam successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function examCancel(Exam $exam) {
        try {
            // cancel exam
            $exam->update([
                "status"=> Exam::CANCEL,
            ]);

            $enrollments = Enrollment::where("exam_id", $exam->id)->get();
            foreach ($enrollments as $enrollment) {
                $enrollment->update([
                    "status"=> Enrollment::CANCELED,
                ]);
            }
            return redirect()->to("admin/admin-exam")->with("edit-success", "Edit exam successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function examTrash() {
        $exams = Exam::onlyTrashed()->orderBy("id","desc")->get();
        return view("pages.admin.exam.admin-exam", compact("exams"))->with("examTrash");
    }

    public function examRecover(Exam $exam) {
        try {
            // recover exam
            $exam->update([
                "deleted_at"=> null,
            ]);
            return redirect()->to("admin/admin-exam")->with("recover-success", "Recover exam $exam->exam_name successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
