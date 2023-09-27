<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard() {
        return view("pages.admin.admin-dashboard");
    }

    public function table1() {
        return view("pages.admin.admin-table1");
    }

    public function table2() {
        return view("pages.admin.admin-table2");
    }

    public function table3() {
        return view("pages.admin.admin-table3");
    }
}
