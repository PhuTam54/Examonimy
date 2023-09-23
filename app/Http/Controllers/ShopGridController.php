<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopGridController extends Controller
{
    public function shop() {
//        $products = Product::limit(12)->get();
//        $products = Product::where("qty", ">", 30)
//            ->where("price", ">", 500)
//            ->orderBy("price", "desc")
//            ->get();

        $products = Product::orderBy("created_at","desc")->paginate(12);

        return view("pages.shop-grid", [
            'products' => $products
        ]);
    }

    public function category(Category $category) {
        // dựa vào id tìm category
        // nếu không tồn tại -> 404
//        $category = Category::find($id);
//        if ($category == null){
//            return abort(404);
//        }

//        $category = Category::findOrFaild($category->id);

        $products = Product::where("category_id", $category->id)->orderBy("created_at", "desc")
            ->paginate(12);
        return view("pages.shop-grid",compact("products"));
    }

}
