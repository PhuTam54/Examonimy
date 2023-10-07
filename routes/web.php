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
Route::controller(\App\Http\Controllers\HomeController::class)->group(function () {
    Route::get('/',  "home");
    Route::get('404',  "notFound");
});

//contact
Route::get('/contact', [\App\Http\Controllers\ContactController::class, "contact"]);

    // Middleware
Route::middleware("auth")->group(function () {
//    // add to cart
//    Route::get('/add-to-cart/{product}', [\App\Http\Controllers\PagesController::class, "addToCart"]);
//
//    // checkout
//    Route::get('/checkout', [\App\Http\Controllers\PagesController::class, "checkOut"]);
//
//    // post
//    Route::post('/checkout', [\App\Http\Controllers\PagesController::class, "placeOrder"]);
//    Route::get('/thank-you/{order}', [\App\Http\Controllers\PagesController::class, "thankYou"]);

    // Paypal
//Route::controller(\App\Http\Controllers\PayPalController::class)->group(function () {
//    Route::get('/paypal-process/{order}', "paypalProcess");
//    Route::get('/paypal-success/{order}', "paypalSuccess");
//    Route::get('/paypal-cancel', "paypalCancel");
//});

});

// ADMIN
Route::middleware(["auth", "is_admin"])->prefix("admin")->group(function () { //
    include_once "admin.php";
});

// Authenticate
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
