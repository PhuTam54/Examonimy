<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function dashboard() {
        $orders = Exam::all();
        $products = Subject::all();
        $users = User::all();
        $income = 0;
        foreach ($orders as $order) {
            $income += $order->grand_total;
        }
        return view("pages.admin.admin-dashboard", compact("orders", "products", "users", "income"));
    }

    // Orders
    public function table1() {
        $orders = Exam::orderBy("created_at","desc")->get();
        return view("pages.admin.admin-table1", compact("orders"));
    }

    public function orderDetails(Exam $order) {
        return view("pages.admin.order-details")->with('order', $order);
    }

    // Products
    public function table2() {
        $products = Subject::orderBy("created_at","desc")->get();
        return view("pages.admin.admin-table2", compact("products"));
    }

    public function productDetails() {
        return "<h1>productDetails</h1>";
    }

    public function productAdd() {
        $categories = Course::all();
        return view("pages.admin.product-add")->with("categories", $categories);
    }

    public function productStore(Request $request) {
        $request->validate([
            "name"=> "required | min:6",
            "price"=> "required",
            "qty"=> "required",
            "category"=> "required",
            "status"=> "required",
            "description"=> "required",
            "thumbnail"=> "required",
        ],[
            "required"=>"Vui lòng nhập thông tin"
        ]);
        // create new product
        $name = $request->get("name");
        Subject::create([
            "name"=>$name,
            "slug"=>Str::slug($name),
            "price"=>$request->get("price"),
            "qty"=>$request->get("qty"),
            "category_id"=>$request->get("category"),
            "description"=>$request->get("description"),
//            "status"=>$request->get("status"),
            "thumbnail"=>$request->get("thumbnail"),
        ]);

        return redirect()->to("admin/admin-table2")->with("add-success", "Add new product successfully!!!");
    }

    public function productEdit(Subject $product) {
        $categories = Course::all();
        return view("pages.admin.product-edit", compact('product', 'categories'));
    }

    public function productUpdate(Request $request, Subject $product) {
        $request->validate([
            "name"=> "required | min:6",
            "price"=> "required",
            "qty"=> "required",
            "category"=> "required",
            "status"=> "required",
            "description"=> "required",
//            "thumbnail"=> "required",
        ],[
            "required"=>"Vui lòng nhập thông tin"
        ]);
        // edit product
        $name = $request->name;
        $new_product = Subject::find($product->id);
        $new_product->name = $name;
        $new_product->slug = Str::slug($name);
        $new_product->price = $request->price;
        $new_product->category_id = $request->category;
        $new_product->qty = $request->qty;
        $new_product->description = $request->description;
//        $new_product->thumbnail = $request->thumbnail;
        $new_product->save();
        return redirect()->to("admin/admin-table2")->with("edit-success", "Edit product successfully!!!");
    }

    public function productDelete(Subject $product) {
        // delete product
        $to_delete_product = Subject::find($product->id);
        $to_delete_product->delete();
        return redirect()->to("admin/admin-table2")->with("delete-success", "Delete product successfully!!!");
    }

    // Categories
    public function table3() {
        $categories = Course::orderBy("created_at","desc")->get();
        return view("pages.admin.admin-table3", compact("categories"));
    }
}
