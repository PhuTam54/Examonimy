<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function shoppingCart() {
        return view("pages.pages.shopping-cart");
    }

    public function shopDetails() {
        return view("pages.pages.shop-details");
    }

    public function checkOut() {
        return view("pages.pages.checkout");
    }

    public function blogDetails() {
        return view("pages.pages.blog-details");
    }
}
