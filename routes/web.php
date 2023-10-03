<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// home
Route::get('/', [\App\Http\Controllers\HomeController::class, "home"]);
//Route::resource('/', \App\Http\Controllers\HomeController::class);

// shop
Route::get('/shop-grid', [\App\Http\Controllers\ShopGridController::class, "shop"]);
Route::get('/shop-grid/{category:slug}', [\App\Http\Controllers\ShopGridController::class, "category"]);

// pages
Route::get('/shopping-cart', [\App\Http\Controllers\PagesController::class, "shoppingCart"]);
Route::get('/delete-from-cart/{product}', [\App\Http\Controllers\PagesController::class, "deleteFromCart"]);
Route::get('/clear-cart', [\App\Http\Controllers\PagesController::class, "clearCart"]);
Route::get('/shop-details/{product:slug}', [\App\Http\Controllers\PagesController::class, "shopDetails"]);

// blog
Route::get('/blog-details', [\App\Http\Controllers\PagesController::class, "blogDetails"]);
Route::get('/blog', [\App\Http\Controllers\BlogController::class, "blog"]);

//contact
Route::get('/contact', [\App\Http\Controllers\ContactController::class, "contact"]);

    // Middleware
Route::middleware("auth")->group(function () {
    // add to cart
    Route::get('/add-to-cart/{product}', [\App\Http\Controllers\PagesController::class, "addToCart"]);

    // checkout
    Route::get('/checkout', [\App\Http\Controllers\PagesController::class, "checkOut"]);

    // post
    Route::post('/checkout', [\App\Http\Controllers\PagesController::class, "placeOrder"]);
    Route::get('/thank-you/{order}', [\App\Http\Controllers\PagesController::class, "thankYou"]);

    // Paypal
    Route::get('/paypal-process/{order}', [\App\Http\Controllers\PayPalController::class, "paypalProcess"]);
    Route::get('/paypal-success/{order}', [\App\Http\Controllers\PayPalController::class, "paypalSuccess"]);
    Route::get('/paypal-cancel', [\App\Http\Controllers\PayPalController::class, "paypalCancel"]);

});

// ADMIN
Route::middleware(["auth", "is_admin"])->group(function () { //->prefix("admin")
    include_once "admin.php";
});

    // Authenticate
    Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
