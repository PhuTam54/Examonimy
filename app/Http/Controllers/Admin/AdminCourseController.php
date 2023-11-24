<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCourseController extends Controller
{

    // Courses
    public function courses() {
        $courses = Course::orderBy("id","desc")->get();
        return view("pages.admin.course.admin-courses", compact("courses"));
    }

    public function courseAdd() {
        return view("pages.admin.course.course-add");
    }

    public function courseStore(Request $request) {
        $request->validate([
            "name"=> "required | min:3",
            "description"=> "required",
            "thumbnail" => "nullable|mimeTypes:image/*|mimes:jpeg,png,jpg,gif|max:2048", // max:2048 là dung lượng tối đa (đơn vị KB)
            "year"=> "required",
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

            // create new course
            $name = $request->get("name");
            Course::create([
                "course_name"=>$name,
                "course_description"=>$request->get("description"),
                "course_year"=>$request->get("year"),
                "course_thumbnail"=>$thumbnail,
//            "slug"=>Str::slug($name),
            ]);

            return redirect()->to("admin/admin-courses")->with("add-success", "Add new course successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function courseEdit(Course $course) {
        return view("pages.admin.course.course-edit", compact('course'));
    }

    public function courseUpdate(Request $request, Course $course) {
        $request->validate([
            "name"=> "required | min:3",
            "description"=> "required",
            "thumbnail" => "nullable|mimeTypes:image/*|mimes:jpeg,png,jpg,gif|max:2048", // max:2048 là dung lượng tối đa (đơn vị KB)
            "year"=> "required",
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

                $course->course_thumbnail = $thumbnail;
            }

            // create new course
            $name = $request->get("name");
            $course->update([
                "course_name"=>$name,
                "course_description"=>$request->get("description"),
                "course_year"=>$request->get("year"),
//            "slug"=>Str::slug($name),
            ]);
            return redirect()->to("admin/admin-courses")->with("add-success", "Add new course successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function courseDelete(Course $course) {
        $course->delete();
        return redirect()->to("admin/admin-courses")->with("delete-success", "Delete course successfully!!!");
    }

    public function courseTrash() {
        $courses = Course::onlyTrashed()->orderBy("id","desc")->get();
        return view("pages.admin.course.admin-courses", compact("courses"));
    }

    public function courseRecover(Course $course) {
        try {
            // recover course
            $course->update([
                "deleted_at"=> null,
            ]);
            return redirect()->to("admin/admin-course")->with("recover-success", "Recover course $course->class_name successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

}
