<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamQuestion;
use Illuminate\Http\Request;

class MyResultController extends Controller
{
    public function myResult(Exam $exam) {
        return view("pages.my-result");
    }
}
