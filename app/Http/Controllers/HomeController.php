<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home() {
        $names = array("Nguyen Phu Tam", "Tran Thi Thuy");
        return view("pages.home", [
            'names' => $names
        ]);
    }
}
