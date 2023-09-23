<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class HomeController extends Controller
{
    public function home() {
        return view("pages.home");
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

