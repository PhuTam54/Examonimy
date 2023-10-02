@extends("layouts.app")
@section("before_css")
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/album/"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3"/>
@endsection
@section("after_css")
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }
    </style>
@endsection
@section("main")
    @include("components.other-page.hero-section")
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-section set-bg" data-setbg="{{ asset('storage/img/breadcrumb.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="breadcrumb__text">
                        <h2>Thank you</h2>
                        <div class="breadcrumb__option">
                            <a href="/">Home</a>
                            <span>Thank you</span>
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
    <!-- Thank you Section Begin -->
{{--    <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3 bd-mode-toggle">--}}
{{--        <button class="btn btn-bd-primary py-2 dropdown-toggle d-flex align-items-center"--}}
{{--                id="bd-theme"--}}
{{--                type="button"--}}
{{--                aria-expanded="false"--}}
{{--                data-bs-toggle="dropdown"--}}
{{--                aria-label="Toggle theme (auto)">--}}
{{--            <svg class="bi my-1 theme-icon-active" width="1em" height="1em"><use href="#circle-half"></use></svg>--}}
{{--            <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>--}}
{{--        </button>--}}
{{--        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">--}}
{{--            <li>--}}
{{--                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light" aria-pressed="false">--}}
{{--                    <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#sun-fill"></use></svg>--}}
{{--                    Light--}}
{{--                    <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>--}}
{{--                </button>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">--}}
{{--                    <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#moon-stars-fill"></use></svg>--}}
{{--                    Dark--}}
{{--                    <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>--}}
{{--                </button>--}}
{{--            </li>--}}
{{--            <li>--}}
{{--                <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto" aria-pressed="true">--}}
{{--                    <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em"><use href="#circle-half"></use></svg>--}}
{{--                    Auto--}}
{{--                    <svg class="bi ms-auto d-none" width="1em" height="1em"><use href="#check2"></use></svg>--}}
{{--                </button>--}}
{{--            </li>--}}
{{--        </ul>--}}
{{--    </div>--}}
    <main>
        <section class=" text-center container">
            <div class="row pt-lg-5">
                <div class="col-md-8 mx-auto">
                    <h2 class="fw-light">Thank you!</h2>
                    <h4 class="my-3">Your order #{{ $order->id }} has been placed!</h4>
                    <p class="lead text-body-secondary">
                        We sent an email to <strong>{{ session("email") }}</strong> with your order confirmation and receipt.
                        If the email hasn't arrived within two minutes, please check your spam folder
                        to see if the email was routed there.
                    </p>
                    <p>
                        <a class="btn" style="color: #7fad39;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                                <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71V3.5z"/>
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0z"/>
                            </svg>
                            <a><strong>Time placed:</strong> {{ $order->created_at }}</a>
                        </a>
                        <a class="btn" style="color: #7fad39;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                                <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                                <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                            </svg>
                            <a>Print</a>
                        </a>
                    </p>
                </div>
            </div>
        </section>

        <div class="album pt-1 pb-5 bg-body-tertiary">
            <div class="container">

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    <div class="col">
                        <div class="card shadow-sm">
                            <div class="card-body" style="color: #7fad39;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                </svg>
                                <p class="text-left"><strong>Shipping</strong></p>
                                <p class="card-text w-75">
                                    {{ $order->full_name }} <br>
                                    {{ $order->address }} <br>
                                    +{{ $order->tel }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card shadow-sm">
                            <div class="card-body" style="color: #7fad39;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-card-heading" viewBox="0 0 16 16">
                                    <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                    <path d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-1z"/>
                                </svg>
                                <p class="text-left"><strong>Billing Details</strong></p>
{{--                                <p class="card-text"></p>--}}
                                <p class="card-text w-75">
                                    {{ $order->full_name }} <br>
                                    {{ $order->address }} <br>
                                    +{{ $order->tel }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card shadow-sm">
                            <div class="card-body" style="color: #7fad39;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
                                    <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7zm1.294 7.456A1.999 1.999 0 0 1 4.732 11h5.536a2.01 2.01 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456zM12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                </svg>
                                <p class="text-left"><strong>Shipping Method</strong></p>
                                <p class="card-text w-75">
                                    Preferred method: <br>
                                    {{ $order->shipping_method }} <br>
                                    ( {{ $order->payment_method }} )
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="album pt-1 pb-5 bg-body-tertiary">
            <div class="container">

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    <div class="col-md-8">
                        <div class="">
                            <div class="card-body">
                                <p class="text-left" style="font-size: 20px">
                                    <strong>Order List</strong>
                                </p><hr>
                                <div class="shoping__cart__table">
                                    <table>
                                        <thead>
                                        <tr>
                                            <th class="shoping__product" style="font-size: 16px">Products</th>
                                            <th style="font-size: 16px">Price</th>
                                            <th style="font-size: 16px">Quantity</th>
                                            <th style="font-size: 16px">Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($order->Products as $item)
                                            <tr>
                                                <td class="shoping__cart__item">
                                                    <img src=" {{ $item->thumbnail }}" width="100" alt="">
                                                    <h5 style="font-size: 16px">{{ $item->name }}</h5>
                                                </td>
                                                <td class="shoping__cart__price" style="font-size: 16px">
                                                    ${{ $item->price }}
                                                </td>
                                                <td class="shoping__cart__quantity">
                                                    <div class="quantity">
                                                        <div class="" style="font-size: 16px">
                                                            <span>{{ $item->pivot->qty }}</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="shoping__cart__total" style="font-size: 16px">
                                                    ${{ $item->pivot->price * $item->pivot->qty }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <p class="text-left" style="font-size: 20px">
                                    <strong>Order Summary</strong>
                                </p> <hr>
                                <p class="card-text d-flex justify-content-between">
                                    Subtotal: <span>{{ $subtotal }}</span>
                                </p>
{{--                                <p class="card-text d-flex justify-content-between">--}}
{{--                                    Shipping & Handling: <span>$1.99</span>--}}
{{--                                </p>--}}
                                <p class="card-text d-flex justify-content-between">
                                    Est Sales Tax: <span>10%</span>
                                </p> <hr>
                                <p class="card-text d-flex justify-content-between" style="font-size: 18px">
                                    Total: <span>{{ $total }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Thank you Section End -->
    @if($order->payment_method == "paypal" && !$order->is_paid)
        <a href="#" class="btn btn-warning">Thanh toán lại</a>
    @endif
@endsection
@section("before_js")
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/color-modes.js"></script>
@endsection
