<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Course;

class HomeController extends Controller
{
    public function home() {
        $instructors = User::where("role", User::INSTRUCTOR)->limit(4)->get();
        $students = User::where("role", User::STUDENT)->orderBy("created_at", "desc")->limit(10)->get();
        $data_wow_delay = -0.1;
        return view("pages.home", compact("instructors", "students", "data_wow_delay"));
    }

    public function notFound() {
        return view("pages.404");
    }
}

                    // Query builders
//        $products = DB::select("SELECT * FROM products WHERE id = :id;",
//        [
//            'id' => 3
//        ]);

//        $users = DB::table("products")

                    // Insert
//                        ->insert([
//                            'name' => 'Nguyen Phu Tam',
//                            'slug' => 'NPT',
//                            'price' => 12345,
//                            'category_id' => 1
//                        ])

                    // Update
//                        ->where("price", "=", 12345)
//                        ->update([
//                            'slug' => 'TTT',
//                        ])

                    // Find
//                    ->find(1) // find by id
//                    ->count()
//                    ->max("id") // min()
//                    ->sum("id")
//                    ->avg("id")

                    // Where
//                    ->where("price", "=", 12345)
//                    ->whereNotNull("name")
//                    ->whereBetween("id", [3, 6])
//                    ->orWhere("id", 1)

                    // OrderBy
//                    ->orderBy("id", "DESC")
//                    ->latest()
//                    ->oldest()

                    // Select
//                    ->select("*")
//                    ->get()
//                    ->first() // limit 1
//        dd($users);

//        $names = array("Nguyen Phu Tam", "Tran Thi Thuy");

