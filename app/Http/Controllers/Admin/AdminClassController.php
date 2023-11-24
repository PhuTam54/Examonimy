<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminClassController extends Controller
{

    // Classroom
    public function classroom() {
        $students = User::where("role", "=", User::STUDENT)->where("class_id", null)->get();
        $classes = Classes::orderBy("created_at","desc")->get();
        return view("pages.admin.classroom.admin-classroom", compact("classes", "students"));
    }

    public function classroomAdd() {
        $students = User::where("role", "=", User::STUDENT)->where("class_id", null)->get();
        $instructors = User::where("role", "=", User::INSTRUCTOR)->get();
        return view("pages.admin.classroom.classroom-add", compact("instructors", "students"));
    }

    public function classroomStore(Request $request) {
        $request->validate([
            "name"=> "required | min:3",
            "instructor"=> "required",
//            "students"=> "required",
        ]);
        try {
            $students = $request->get("students");
            if ($students != null) {
                $number_of_student = count($students);
            } else {
                $number_of_student = 0;
            }

            // create new classroom
            $name = $request->get("name");
            $classId = Classes::insertGetId([
                "class_name"=>$name,
//            "slug"=>Str::slug($name),
                "number_of_students"=> $number_of_student,
                "instructor_id"=>$request->get("instructor"),
                "created_at" => Carbon::now()
            ]);

            if ($students != null) {
                foreach ($students as $id) {
                    $student = User::find($id);
                    $student->update([
                        "class_id" => $classId
                    ]);
                }
            }

            return redirect()->to("admin/admin-classroom")->with("add-success", "Add new classroom successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function classroomEdit(Classes $classroom) {
        $students = User::where("role", "=", User::STUDENT)->where("class_id", null)->get();
        $instructors = User::where("role", "=", User::INSTRUCTOR)->get();
        return view("pages.admin.classroom.classroom-edit", compact('classroom', 'students', 'instructors'));
    }

    public function classroomUpdate(Request $request, Classes $classroom) {
        $request->validate([
            "name"=> "required | min:3",
            "instructor"=> "required",
        ]);
        try {
            $students = $request->get("students");
            if ($students != null) {
                $number_of_student = count($students);
            } else {
                $number_of_student = 0;
            }

            // create new classroom
            $name = $request->get("name");
            $classroom->update([
                "class_name"=>$name,
//            "slug"=>Str::slug($name),
                "number_of_students"=> $classroom->number_of_students + $number_of_student,
                "instructor_id"=>$request->get("instructor"),
            ]);

            if ($students != null) {
                foreach ($students as $id) {
                    $student = User::find($id);
                    $student->update([
                        "class_id" => $classroom->id
                    ]);
                }
            }
            return redirect()->to("admin/admin-classroom")->with("edit-success", "Edit classroom successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function classroomDelete(Classes $classroom) {
        // delete classroom
        $to_delete_classroom = Classes::find($classroom->id);
        $to_delete_classroom->delete();
        return redirect()->to("admin/admin-classroom")->with("delete-success", "Delete classroom successfully!!!");
    }

    public function classroomTrash() {
        $students = [];
        $classes = Classes::onlyTrashed()->orderBy("id","desc")->get();
        return view("pages.admin.classroom.admin-classroom", compact("classes", "students"));
    }

    public function classroomRecover(Classes $classroom) {
        try {
            // recover classroom
            $classroom->update([
                "deleted_at"=> null,
            ]);
            return redirect()->to("admin/admin-classroom")->with("recover-success", "Recover classroom $classroom->class_name successfully!!!");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function classAddStudent(Request $request) {
        $studentIds = $request->get("students");
        $classId = $request->get("class_id");
        foreach ($studentIds as $studentId) {
            $student = User::find($studentId);
            $student->update([
                "class_id" => $classId
            ]);
        }

        $classroom = Classes::find($classId);
        $classroom->update([
            "number_of_students"=> $classroom->number_of_students + count($studentIds),
        ]);
        return redirect()->to("admin/admin-classroom")->with("addStudent-success", "Add student successfully!!!");
    }

    public function classDeleteStudent(User $student) {
        $student->update([
            "class_id" => null
        ]);
        return redirect()->to("admin/admin-classroom")->with("deleteStudent-success", "Delete student successfully!!!");
    }

}
