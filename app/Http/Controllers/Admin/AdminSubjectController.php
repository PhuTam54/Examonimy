<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminSubjectController extends Controller
{

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
            "thumbnail" => "nullable|mimeTypes:image/*|mimes:jpeg,png,jpg,gif|max:2048", // max:2048 là dung lượng tối đa (đơn vị KB)
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
                "thumbnail"=> $thumbnail,
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
            "thumbnail" => "nullable|mimeTypes:image/*|mimes:jpeg,png,jpg,gif|max:2048", // max:2048 là dung lượng tối đa (đơn vị KB)
        ]);
        // edit subject
        $name = $request->name;
        $new_subject = Subject::find($subject->id);
        $new_subject->subject_name = $name;
//        $new_subject->slug = Str::slug($name);
        $new_subject->course_id = $request->course;
        $new_subject->lesson = $request->lesson;
        $new_subject->subject_description = $request->description;
        if ($request->thumbnail != null) {
            // Xử lí upload file
            if ($request->hasFile("thumbnail")) {
                $path = public_path("uploads");
                $file = $request->file("thumbnail");
                $file_name = Str::random(5).time().Str::random(5).".".$file->getClientOriginalExtension();
                $file->move($path, $file_name);
                $thumbnail = "/uploads/".$file_name;
            }
            $new_subject->subject_thumbnail = $thumbnail;
        }
        $new_subject->save();
        return redirect()->to("admin/admin-subject")->with("edit-success", "Edit subject successfully!!!");
    }

    public function subjectDelete(Subject $subject) {
        // delete subject
        $to_delete_subject = Subject::find($subject->id);
        $to_delete_subject->delete();
        return redirect()->to("admin/admin-subject")->with("delete-success", "Delete subject successfully!!!");
    }

    public function subjectTrash() {
        $subjects = Subject::onlyTrashed()->orderBy("id","desc")->get();
        return view("pages.admin.subject.admin-subject", compact("subjects"));
    }

    public function subjectRecover(Subject $subject) {
        try {
            // recover subject
            $subject->update([
                "deleted_at"=> null,
            ]);
            return redirect()->to("admin/admin-subject")->with("recover-success", "Recover subject $subject->subject_name successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

}
