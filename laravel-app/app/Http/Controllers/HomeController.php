<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home() {
        return view("pages.home");
    }

    public function aboutUs() {
        return view("pages.aboutus");
    }
}
