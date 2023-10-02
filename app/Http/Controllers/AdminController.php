<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard() {
        $orders = Order::all();
        $products = Product::all();
        $users = User::all();
        $income = 0;
        foreach ($orders as $order) {
            $income += $order->grand_total;
        }
        return view("pages.admin.admin-dashboard", compact("orders", "products", "users", "income"));
    }

    public function table1() {
        $orders = Order::all();
        return view("pages.admin.admin-table1", compact("orders"));
    }

    public function table2() {
        $products = Product::all();
        return view("pages.admin.admin-table2", compact("products"));
    }

    public function table3() {
        $categories = Category::all();
        return view("pages.admin.admin-table3", compact("categories"));
    }
}
