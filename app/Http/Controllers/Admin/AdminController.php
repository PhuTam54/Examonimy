<?php

namespace App\Http\Controllers\Admin;

use App\Events\ConfirmRetakenExam;
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
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    public function dashboard() {
        $exams = Exam::all();
        $subjects = Subject::all();
        $users = User::all();
        $classroom = Classes::all();
        return view("pages.admin.admin-dashboard", compact("exams", "subjects", "users", "classroom"));
    }

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
        $exam_questions = ExamQuestion::all();
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
        ],[
//            "required"=>"Vui lòng nhập thông tin"
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
            }

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

            // get status
            $status = Exam::PENDING;

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
                "status"=>$status,
                "start_date"=>$newStartDate,
                "end_date"=>$newEndDate,
            ]);

            // get participants
            $participant = $request->get("classes");
            $classes = Classes::find($participant);
            // Create new Enrollment
            foreach ($classes->Students as $student) {
                DB::table("enrollments")
                    ->insert([
                        "student_id" => $student->id,
                        "exam_id" => $examId,
                        "status" => 1
                    ]);
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

        return view("pages.admin.exam.exam-edit",
            compact("exam", "subjects", "classes", "exam_questions"));
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
        ],[
//            "required"=>"Vui lòng nhập thông tin"
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
                "exam_thumbnail"=>$thumbnail,
                "retaken_fee"=>$request->get("retaken_fee"),
                "type_of_exam"=>$request->get("type_of_exam"),
                "created_by" => $instructor,
                "subject_id"=>$request->get("subject"),
                "exam_question_id"=>$request->get("exam_question"),
//                "start_date"=>$newStartDate,
//                "end_date"=>$newEndDate,
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

    // ExamQuestions
    public function examquestion() {
        $examquestions = ExamQuestion::orderBy("id","desc")->get();
        return view("pages.admin.examquestion.admin-examquestion", compact("examquestions"));
    }

    public function examquestionDetails(ExamQuestion $examquestion) {
        return view("pages.admin.examquestion.examquestion-details")->with('examquestion', $examquestion);
    }

    public function examquestionAdd() {
        $subjects = Subject::all();
        $classes = Classes::all();
        $exam_questions = ExamQuestion::all();
        return view("pages.admin.examquestion.examquestion-add",
            compact("subjects", "classes", "exam_questions"));
    }

    public function examquestionStore(Request $request) {
        $request->validate([
            "examquestion_name"=> "required | min:3",
            "description"=> "required",
            "datetime"=> "required",
            "thumbnail"=> "nullable | mimes:png, jpg, jpeg, gif | mimeTypes:image/*",
            "retaken_fee"=> "required | numeric | min: 0",
            "type_of_examquestion"=> "required",
            "subject"=> "required",
            "classes" => "required",
            "examquestion_question"=> "required",
        ],[
//            "required"=>"Vui lòng nhập thông tin"
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

            // get status
            $status = ExamQuestion::PENDING;

            // create new examquestion
            ExamQuestion::create([
                "examquestion_name" => $request->get("examquestion_name"),
                "examquestion_description"=>$request->get("description"),
                "examquestion_thumbnail"=>$thumbnail,
                "retaken_fee"=>$request->get("retaken_fee"),
                "type_of_examquestion"=>$request->get("type_of_examquestion"),
                "created_by" => $instructor,
                "subject_id"=>$request->get("subject"),
                "examquestion_question_id"=>$request->get("examquestion_question"),
                "status"=>$status,
                "start_date"=>$newStartDate,
                "end_date"=>$newEndDate,
            ]);

            return redirect()->to("admin/admin-examquestion")->with("add-success", "Add new examquestion successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function examquestionEdit(ExamQuestion $examquestion) {
        $subjects = Subject::all();
        $classes = Classes::all();
        $examquestion_questions = ExamQuestion::all();

        return view("pages.admin.examquestion.examquestion-edit",
            compact("examquestion", "subjects", "classes", "examquestion_questions"));
    }

    public function examquestionUpdate(Request $request, ExamQuestion $examquestion) {
        $request->validate([
            "examquestion_name"=> "required | min:3",
            "description"=> "required",
            "datetime"=> "required",
            "thumbnail" => "nullable|mimeTypes:image/*|mimes:jpeg,png,jpg,gif|max:2048", // max:2048 là dung lượng tối đa (đơn vị KB)
            "retaken_fee"=> "required | numeric | min: 0",
            "type_of_examquestion"=> "required",
            "subject"=> "required",
            "classes" => "required",
            "examquestion_question"=> "required",
        ],[
//            "required"=>"Vui lòng nhập thông tin"
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

            // edit examquestion
            $examquestion = ExamQuestion::find($examquestion->id);
            $examquestion->update([
                "examquestion_name" => $request->get("examquestion_name"),
                "examquestion_description"=>$request->get("description"),
                "examquestion_thumbnail"=>$thumbnail,
                "retaken_fee"=>$request->get("retaken_fee"),
                "type_of_examquestion"=>$request->get("type_of_examquestion"),
                "created_by" => $instructor,
                "subject_id"=>$request->get("subject"),
                "examquestion_question_id"=>$request->get("examquestion_question"),
//                "start_date"=>$newStartDate,
//                "end_date"=>$newEndDate,
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
        return view("pages.admin.examquestion.admin-examquestion", compact("examquestions"))->with("examquestionTrash");
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

    // Exam Result
    public function result() {
        $results = EnrollmentResult::orderBy("created_at","desc")->get();
        return view("pages.admin.result.admin-result", compact("results"));
    }

    // Enrollments
    public function enrollment() {
        $enrollments = Enrollment::orderBy("id","desc")->get();
        return view("pages.admin.enrollment.admin-enrollment", compact("enrollments"));
    }

    public function enrollmentConfirm(Enrollment $enrollment) {
        try {
            $enrollment->update([
                'status' => Enrollment::CONFIRMED
            ]);

            // Send mail
            event(new ConfirmRetakenExam($enrollment));

            return redirect()->back()->with("confirm-success", "Confirm enrollment successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function enrollmentCancel(Enrollment $enrollment) {
        try {
            $enrollment->update([
                'status' => Enrollment::CANCELED
            ]);
            return redirect()->back()->with("cancel-success", "Cancel enrollment successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    // User
    public function user() {
        $users = User::orderBy("id","desc")->get();
        return view("pages.admin.user.admin-user", compact("users"));
    }

    // Question
    public function question() {
        $questions = Question::orderBy("id","desc")->get();
        return view("pages.admin.question.admin-question", compact("questions"));
    }
    public function questionAdd() {
        $exam_questions = ExamQuestion::all();
        $questions = Question::all();
        return view("pages.admin.question.question-add",
            compact("exam_questions", "questions"));
    }

    public function questionStore(Request $request) {
        $request->validate([
//            "question_no"=> "required | numeric", // No. STT
            "question_text"=> "required",
            "exam_question_id"=> "required",
            "question_image"=> "nullable | mimes:png, jpg, jpeg, gif | mimeTypes:image/*",
            "question_audio"=> "nullable | mimes:png, jpg, jpeg, gif | mimeTypes:audio/*",
            "question_paragraph"=>"nullable",
            "type_of_question"=> "required",
            "difficulty"=> "required",
            "is_correct"=> "required | min:1 | max:9",
            "option_text"=> "required | min:1 | max:10"
        ],[
//            "required"=>"Vui lòng nhập thông tin"
        ]);
        try {
            $image = null;
            $audio = null;
            $paragraph = null;
            // Xử lí upload file
            if ($request->hasFile("question_image")) {
                $path = public_path("uploads");
                $file = $request->file("question_image");
                $file_name = Str::random(5).time().Str::random(5).".".$file->getClientOriginalExtension();
                $file->move($path, $file_name);
                $image = "/uploads/".$file_name;
            }

            // set point / question
            $point = 0;
            if ($request->get("difficulty") == 1) {
                $point = 1;
            } elseif ($request->get("difficulty") == 2) {
                $point = 1.5;
            } elseif ($request->get("difficulty") == 3) {
                $point = 2;
            }

            $questionId = Question::insertGetId([
                "question_no" => $request->get("question_no") || 0, // No. STT
                "question_text" => $request->get("question_text"),
                "exam_question_id" => $request->get("exam_question_id"),
                "question_mark" => $point,
                "difficulty" => $request->get("difficulty"),
                "type_of_question" => $request->get("type_of_question"),
                "question_image" => $image,
                "question_audio" => $audio,
                "question_paragraph" => $paragraph,
            ]);

            if ($request->get("type_of_question") == Question::MULTIPLE_CHOICE || $request->get("type_of_question") == Question::CHOICE) {
                $answers = $request->get("is_correct");
                $options = $request->get("option_text");
                foreach ($options as $index => $option) {
                    if ($option != null && $option != '') {
                        $is_correct = in_array($option, $answers); // Kiểm tra xem đáp án có nằm trong mảng $answers không
                        QuestionOption::insert([
                            "question_id" => $questionId,
                            "option_text" => chr($index + ord('A')).'. '.$option,
                            "is_correct" => $is_correct,
                        ]);
                    }
                }
            } else {
                if ($request->get("option_text") != null && $request->get("option_text") != []) {
                    $answer = implode(",", $request->get("option_text"));

                    QuestionOption::insert([
                        "question_id" => $questionId,
                        "option_text" => $answer,
                        "is_correct" => true,
                    ]);
                }
            }

            return response()->json(['success'=>true, 'msg'=>"Add new question successfully!!!"]);
        } catch (\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    public function questionEdit(Question $question) {
        $exam_questions = ExamQuestion::all();

        return view("pages.admin.question.question-edit",
            compact("question", "exam_questions"));
    }

    public function questionUpdate(Request $request, Question $question) {
//        return response()->json($request);
        $request->validate([
//            "question_no"=> "required | numeric", // No. STT
            "question_text"=> "required",
            "exam_question_id"=> "required",
            "question_image"=> "nullable | mimes:png, jpg, jpeg, gif | mimeTypes:image/*",
            "question_audio"=> "nullable | mimes:png, jpg, jpeg, gif | mimeTypes:audio/*",
            "question_paragraph"=>"nullable",
            "type_of_question"=> "required",
            "difficulty"=> "required",
            "is_correct"=> "required | min:1 | max:9",
            "option_text"=> "required | min:1 | max:10"
        ],[
//            "required"=>"Vui lòng nhập thông tin"
        ]);
        try {
            $image = null;
            $audio = null;
            $paragraph = null;
            // Xử lí upload file
            if ($request->hasFile("question_image")) {
                $path = public_path("uploads");
                $file = $request->file("question_image");
                $file_name = Str::random(5).time().Str::random(5).".".$file->getClientOriginalExtension();
                $file->move($path, $file_name);
                $image = "/uploads/".$file_name;
            }

            // set point / question
            $point = 0;
            if ($request->get("difficulty") == 1) {
                $point = 1;
            } elseif ($request->get("difficulty") == 2) {
                $point = 1.5;
            } elseif ($request->get("difficulty") == 3) {
                $point = 2;
            }

            // edit question
            $question->update([
                "question_no" => $request->get("question_no") || 0, // No. STT
                "question_text" => $request->get("question_text"),
                "exam_question_id" => $request->get("exam_question_id"),
                "question_mark" => $point,
                "difficulty" => $request->get("difficulty"),
                "type_of_question" => $request->get("type_of_question"),
                "question_image" => $image,
                "question_audio" => $audio,
                "question_paragraph" => $paragraph,
            ]);

            $old_options = $question->QuestionOptions;
            $new_options = $request->get("option_text");
            $new_answers = $request->get("is_correct");

            foreach ($old_options as $index => $old_option) {
                if ($old_option != null && $old_option != '') {
                    // Kiểm tra xem $index có tồn tại trong mảng $new_options không
                    if (array_key_exists($index, $new_options)) {
                        $new_option = $new_options[$index];
                        $is_correct = in_array($new_option, $new_answers);

                        // Cập nhật thông tin cho sự lựa chọn cũ
                        if ($request->get("type_of_question") == Question::FILL_IN_BLANK) {
                            $old_option->update([
                                "option_text" => $new_option,
                            ]);
                        } else {
                            $old_option->update([
                                "option_text" => chr($index + ord('A')).'. '.$new_option,
                                "is_correct" => $is_correct,
                            ]);
                        }
                    } else {
                        // Nếu admin xóa bớt câu trả lời
                        $old_option->delete();
                    }
                }
            }

            // Thêm mới sự lựa chọn nếu $new_options có nhiều phần tử hơn và chưa được sử dụng để update $old_options
            for ($index = count($old_options); $index < count($new_options) && $index < count($old_options) + count($new_options); $index++) {
                $new_option = $new_options[$index];
                $is_correct = in_array($new_option, $new_answers);

                // Thêm mới sự lựa chọn
                QuestionOption::create([
                    "question_id" => $question->id,
                    "option_text" => chr($index + ord('A')).'. '.$new_option,
                    "is_correct" => $is_correct,
                ]);
            }
            return response()->json(['success'=>true, 'msg'=>"Edit question successfully!!!"]);
        } catch (\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    public function questionDelete(Question $question) {
        try {
            // delete question
            $to_delete_question = Question::find($question->id);
            $to_delete_question->delete();
            return redirect()->to("admin/admin-question")->with("delete-success", "Delete question successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function questionTrash() {
        $questions = Question::onlyTrashed()->orderBy("id","desc")->get();
        return view("pages.admin.question.admin-question", compact("questions"))->with("questionTrash");
    }

    public function questionRecover(Question $question) {
        try {
            // recover question
            $question->update([
                "deleted_at"=> null,
            ]);
            return redirect()->to("admin/admin-question")->with("recover-success", "Recover question $question->question_name successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    // excel
    public function importQna(Request $request) {
        try {
            Excel::import(new QnaImport, $request->file('file'));

            return response()->json(['success'=>true, 'msg'=>'Import Q&A successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success'=>false, 'msg'=>$e->getMessage()]);
        }
    }

    // Answers
    public function answer() {
        $answers = EnrollmentAnswer::orderBy("id","desc")->get();
        return view("pages.admin.answer.admin-answer", compact("answers"));
    }

    // Subjects
    public function subject() {
        $subjects = Subject::orderBy("id","desc")->get();
        return view("pages.admin.subject.admin-subject", compact("subjects"));
    }

    public function subjectDetails() {
        return "<h1>subjectDetails</h1>";
    }

    public function subjectAdd() {
        $courses = Course::all();
        return view("pages.admin.subject.subject-add")->with("courses", $courses);
    }

    public function subjectStore(Request $request) {
        $request->validate([
            "name"=> "required | min:3",
            "lesson"=> "required | numeric | min: 0",
            "course"=> "required",
//            "status"=> "required",
            "description"=> "required",
            "thumbnail"=> "nullable | mimes:png, jpg, jpeg, gif | mimeTypes:image/*",
        ],[
//            "required"=>"Vui lòng nhập thông tin"
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
            }
            // create new subject
            $name = $request->get("name");
            Subject::create([
                "subject_name"=>$name,
//            "slug"=>Str::slug($name),
                "lesson"=>$request->get("lesson"),
                "course_id"=>$request->get("course"),
                "subject_description"=>$request->get("description"),
                "status"=>$request->get("status"),
                "thumbnail"=>$request->get("thumbnail"),
            ]);

            return redirect()->to("admin/admin-subject")->with("add-success", "Add new subject successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function subjectEdit(Subject $subject) {
        $courses = Course::all();
        return view("pages.admin.subject.subject-edit", compact('subject', 'courses'));
    }

    public function subjectUpdate(Request $request, Subject $subject) {
        $request->validate([
            "name"=> "required | min:3",
            "lesson"=> "required | numeric | min: 0",
            "course"=> "required",
//            "status"=> "required",
            "description"=> "required",
            "thumbnail"=> "nullable | mimes:png, jpg, jpeg, gif | mimeTypes:image/*",
        ],[
//            "required"=>"Vui lòng nhập thông tin"
        ]);
        // edit subject
        $name = $request->name;
        $new_subject = Subject::find($subject->id);
        $new_subject->subject_name = $name;
//        $new_subject->slug = Str::slug($name);
        $new_subject->course_id = $request->course;
        $new_subject->lesson = $request->lesson;
        $new_subject->subject_description = $request->description;
//        $new_subject->thumbnail = $request->thumbnail;
        $new_subject->save();
        return redirect()->to("admin/admin-subject")->with("edit-success", "Edit subject successfully!!!");
    }

    public function subjectDelete(Subject $subject) {
        // delete subject
        $to_delete_subject = Subject::find($subject->id);
        $to_delete_subject->delete();
        return redirect()->to("admin/admin-subject")->with("delete-success", "Delete subject successfully!!!");
    }

    // Attendances
    public function attendance() {
        $attendances = Attendance::all();
        return view("pages.admin.attendance.admin-attendance", compact("attendances"));
    }

    // Courses
    public function courses() {
        $courses = Course::orderBy("id","desc")->get();
        return view("pages.admin.course.admin-courses", compact("courses"));
    }

    // Classroom
    public function classroom() {
        $classes = Classes::orderBy("id","desc")->get();
        return view("pages.admin.classroom.admin-classroom", compact("classes"));
    }
}
