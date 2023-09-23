@extends("layouts.app")
@section("main")
    @include("components.other-page.hero-section")
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('storage/img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Shopping Cart</h2>
                        <div class="breadcrumb__option">
                            <a href="/">Home</a>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
    @if(session()->has("success"))
        <div class="alert alert-success" role="alert">
            {{ session("success") }}
        </div>
    @endif

    @if($cart == [])
    <p class="text-warning">Không có sản phẩm nào trong giỏ hàng</p>
    @else
    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__table">
                        <table>
                            <thead>
                            <tr>
                                <th class="shoping__product">Products</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cart as $item)
                                <tr>
                                    <td class="shoping__cart__item">
                                        <img src=" {{ $item->thumbnail }}" width="100" alt="">
                                        <h5>{{ $item->name }}</h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                        ${{ $item->price }}
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        <div class="quantity">
                                            <div class="pro-qty">
                                                <input name="buy_qty" type="text" value="{{ $item->buy_qty }}">
                                            </div>
                                            @if($item->buy_qty > $item->qty)
                                                <p class="text-danger">Sản phẩm đã hết hàng</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="shoping__cart__total">
                                        ${{ $item->price * $item->buy_qty }}
                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <a href="/delete-from-cart/{{ $item->id }}"><span class="icon_close"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping__cart__btns">
                        <a href="#" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                        <a href="/clear-cart" class="primary-btn cart-btn cart-btn-right"><span class="icon_loading"></span>
                            Clear Cart</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__continue">
                        <div class="shoping__discount">
                            <h5>Discount Codes</h5>
                            <form action="#">
                                @csrf
                                <input type="text" placeholder="Enter your coupon code">
                                <button type="submit" class="site-btn">APPLY COUPON</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping__checkout">
                        <h5>Cart Total</h5>
                        <ul>
                            <li>Subtotal<span>${{ $subtotal }}</span></li>
                            <li>VAT<span>10%</span></li>
                            <li>Total <span>${{ $total }}</span></li>
                        </ul>
                        <a href="/checkout" class="primary-btn {{ $can_checkout ? "" : "btn disabled" }}">PROCEED TO CHECKOUT</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->
    @endif
@endsection
