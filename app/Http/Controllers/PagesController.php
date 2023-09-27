<?php

namespace App\Http\Controllers;

use App\Mail\OrderMail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PagesController extends Controller
{
    public function shoppingCart() {
        $cart = session()->has("cart")?session("cart"):[];
        $subtotal = 0;
        $can_checkout = true;
        foreach ($cart as $item) {
            $subtotal +=  $item->price * $item->buy_qty;
            if ($item->buy_qty > $item->qty) {
                $can_checkout = false;
            }
        }
        $total = $subtotal * 1.1;
        return view("pages.pages.shopping-cart",
            compact("cart", "subtotal", "total", "can_checkout")
        );
    }

    public function addToCart(Product $product, Request $request) {
        $buy_qty = $request->get("buy_qty");
//        dd($buy_qty);
        $cart = session()->has("cart")?session("cart"):[];
        foreach($cart as $item) {
            if($item->id == $product->id) {
                $item->buy_qty = $item->buy_qty + $buy_qty;
                session(["cart"=>$cart]);
                return redirect()->back()->with("success", "Đã thêm sản phẩm vào giỏ hàng");
            }
        }
        $product->buy_qty = $buy_qty;
        $cart[] = $product;
        session(["cart"=>$cart]);
        return redirect()->back()->with("success", "Đã thêm sản phẩm vào giỏ hàng");
    }

    public function deleteFromCart(Product $product)
    {
        $cart = session()->has("cart") ? session("cart") : [];
        $cart = array_filter($cart, function ($item) use ($product) {
            return $item->id != $product->id;
        });
        session()->put("cart", $cart);
        return redirect()->back()->with("success", "Đã xóa sản phẩm khỏi giỏ hàng");
    }

    public function clearCart()
    {
        session()->forget("cart");
        return redirect()->back()->with("success", "Đã xóa tất cả sản phẩm khỏi giỏ hàng");
    }

    public function shopDetails(Product $product) {
        $relateds = Product::where("category_id",$product->category_id)
            ->where("id","!=",$product->id)
            ->where("qty",">",0)
            ->orderBy("created_at","desc")
            ->limit(4)
            ->get();
        return view("pages.pages.shop-details", compact("product", "relateds"));
    }

    public function checkOut() {
        $cart = session()->has("cart")?session("cart"):[];
        $subtotal = 0;
        $can_checkout = true;
        foreach ($cart as $item) {
            $subtotal +=  $item->price * $item->buy_qty;
            if ($item->buy_qty > $item->qty) {
                $can_checkout = false;
            }
        }
        $total = $subtotal * 1.1;
        if(count($cart) == 0 || !$can_checkout) {
            return redirect()->back();
        }
        return view("pages.pages.checkout",
            compact("cart", "subtotal", "total")
        );
    }

    public function placeOrder(Request $request) {
        $request->validate([
            "full_name"=> "required | min:6",
            "address"=> "required | min:6",
            "tel"=> "required | min:9 | max:10",
            "email"=> "required",
            "shipping_method"=> "required",
            "payment_method"=> "required",
        ],[
            "required"=>"Vui lòng nhập thông tin"
        ]);

        // Tính grand_total
        $cart = session()->has("cart")?session("cart"):[];
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal +=  $item->price * $item->buy_qty;
        }
        $total = $subtotal * 1.1;

        $email = $request->get("email");
        // create new order
        $order = Order::create([
            "user_id"=>random_int(1, 10),
            "grand_total"=>$total,
            "full_name"=>$request->get("full_name"),
            "tel"=>$request->get("tel"),
            "address"=>$request->get("address"),
            "payment_method"=>$request->get("payment_method"),
            "shipping_method"=>$request->get("shipping_method"),
            "status"=>1
        ]);

        // insert into order_details
        foreach ($cart as $item) {
            DB::table("order_details")->insert([
                "order_id"=>$order->id,
                "product_id"=>$item->id,
                "qty"=>$item->buy_qty,
                "price"=>$item->price,
            ]);
            // update qty
            $product = Product::find($item->id);
            $product->update(["qty"=>$product->qty - $item->buy_qty]);
        }
        // clear cart
//        session()->forget("cart");

        // send email
        Mail::to($email)
//            ->cc("mail nhan vien")
//            ->bcc("mail quan ly")
            ->send(new OrderMail($order));

        return redirect()->to("thank-you/$order->id")->with("email", $email);
    }

    public function thankYou(Order $order) {
//        $order = session()->get("order");
//        if ($order == null) {
//            abort("404 Not Found!");
//        }
//        $item = DB::table("order_details")->where("order_id", $order->id)
//                                                ->join("products", "order_details.product_id", "=", "products.id")
//                                                ->select("products.id", "products.name", "products.thumbnail", "order_details.price", "order_details.qty")
//                                                ->get();
        // Tính grand_total
        $subtotal = 0;
        foreach ($order->Products as $item) {
            $subtotal +=  $item->pivot->price * $item->pivot->qty;
        }
        $total = $subtotal * 1.1;
        return view("pages.pages.thank-you", compact("order", "subtotal", "total"));
    }

    public function blogDetails() {
        return view("pages.pages.blog-details");
    }
}
