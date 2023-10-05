@extends("layouts.app")
@section("main")
    @include("components.other-page.hero-section")
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('storage/img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Checkout</h2>
                        <div class="breadcrumb__option">
                            <a href="/">Home</a>
                            <span>Checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
    @if(session()->has('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h6><span class="icon_tag_alt"></span> Have a coupon? <a href="#">Click here</a> to enter your code
                    </h6>
                </div>
            </div>
            <div class="checkout__form">
                <h4>Billing Details</h4>
                <form action="/checkout" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Full Name<span>*</span></p>
                                        <input
                                            name="full_name"
                                            value="{{ auth()?auth()->user()->name:old("full_name") }}"
                                            type="text"
                                        >
                                        @error("full_name")
                                            <p class="text-danger"><i>{{ $message }}</i></p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Address<span>*</span></p>
                                <input
                                    name="address"
                                    value="{{ old("address") }}"
                                    type="text"
                                    placeholder="Street Address"
                                    class="checkout__input__add"
                                >
                                @error("address")
                                <p class="text-danger"><i>{{ $message }}</i></p>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>TelePhone<span>*</span></p>
                                        <input name="tel" value="{{ old("tel") }}" type="text">
                                        @error("tel")
                                        <p class="text-danger"><i>{{ $message }}</i></p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input
                                            name="email"
                                            value="{{ auth()?auth()->user()->email:old("email") }}"
                                            type="email"
                                        >
                                        @error("email")
                                        <p class="text-danger"><i>{{ $message }}</i></p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="checkout__input__checkbox">
                                    <p>Shipping method<span>*</span></p>
                                    <label for="acc">
                                        Express
                                        <input name="shipping_method" @if(old("shipping_method") == "Express") checked @endif value="Express" type="radio" id="acc">
                                        <span class="checkmark"></span>
                                    </label>
                                    <br/>
                                    <label for="free">
                                        Free Shipping
                                        <input name="shipping_method" @if(old("shipping_method") == "Free_Shipping") checked @endif value="Free_Shipping" type="radio" id="free">
                                        <span class="checkmark"></span>
                                    </label>
                                    @error("shipping_method")
                                    <p class="text-danger"><i>{{ $message }}</i></p>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4>Your Order</h4>
                                <div class="checkout__order__products">Products <span>Total</span></div>
                                <ul>
                                    @foreach($cart as $product)
                                        <li>{{ $product->name }} x{{ $product->buy_qty }} <span>${{ $product->price * $product->buy_qty }}</span></li>
                                    @endforeach
                                </ul>
                                <div class="checkout__order__subtotal">Subtotal <span>${{ $subtotal }}</span></div>
                                <div class="checkout__order__total">VAT <span>10%</span></div>
                                <div class="checkout__order__total">Total <span>${{ $total }}</span></div>
{{--                                <div class="checkout__input__checkbox">--}}
{{--                                    <label for="acc-or">--}}
{{--                                        Create an account?--}}
{{--                                        <input type="checkbox" id="acc-or">--}}
{{--                                        <span class="checkmark"></span>--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                                <p>Lorem ipsum dolor sit amet, consectetur adip elit, sed do eiusmod tempor incididunt--}}
{{--                                    ut labore et dolore magna aliqua.</p>--}}
                                <div class="checkout__input__checkbox">
                                    <label for="payment">
                                        COD
                                        <input type="radio" @if(old("payment_method") == "COD") checked @endif name="payment_method" value="COD" id="payment">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="checkout__input__checkbox">
                                    <label for="paypal">
                                        Paypal
                                        <input type="radio" @if(old("payment_method") == "paypal") checked @endif name="payment_method" value="paypal" id="paypal">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                @error("payment_method")
                                <p class="text-danger"><i>{{ $message }}</i></p>
                                @enderror
                                <button type="submit" class="site-btn">PLACE ORDER</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->
@endsection
