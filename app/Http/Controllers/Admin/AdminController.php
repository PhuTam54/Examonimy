<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\QnaImport;
use App\Models\Classes;
use App\Models\Course;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\ExamResult;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
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

    // Courses
    public function courses() {
        $courses = Course::orderBy("id","desc")->get();
        return view("pages.admin.course.admin-courses", compact("courses"));
    }

    // Question
    public function question() {
        $questions = ExamQuestion::orderBy("id","desc")->get();
        return view("pages.admin.question.admin-question", compact("questions"));
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

    // Classroom
    public function classroom() {
        $classes = Classes::orderBy("id","desc")->get();
        return view("pages.admin.classroom.admin-classroom", compact("classes"));
    }

    // Exam Result
    public function result() {
        $results = ExamResult::orderBy("created_at","desc")->get();
        return view("pages.admin.result.admin-result", compact("results"));
    }

    // Classroom
    public function user() {
        $users = User::orderBy("id","desc")->get();
        return view("pages.admin.user.admin-user", compact("users"));
    }
}
