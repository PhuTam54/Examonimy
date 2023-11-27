<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function contact() {
        $courses = Course::orderBy("id","desc")->get();
        $subjects = Subject::orderBy("id","desc")->get();
        return view("pages.contact", compact("courses", "subjects"));
    }
}
