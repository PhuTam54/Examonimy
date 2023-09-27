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
Route::get('/add-to-cart/{product}', [\App\Http\Controllers\PagesController::class, "addToCart"]);
Route::get('/delete-from-cart/{product}', [\App\Http\Controllers\PagesController::class, "deleteFromCart"]);
Route::get('/clear-cart', [\App\Http\Controllers\PagesController::class, "clearCart"]);

Route::get('/shop-details/{product:slug}', [\App\Http\Controllers\PagesController::class, "shopDetails"]);

Route::get('/checkout', [\App\Http\Controllers\PagesController::class, "checkOut"]);
    // post
Route::post('/checkout', [\App\Http\Controllers\PagesController::class, "placeOrder"]);
Route::get('/thank-you/{order}', [\App\Http\Controllers\PagesController::class, "thankYou"]);

Route::get('/blog-details', [\App\Http\Controllers\PagesController::class, "blogDetails"]);

// blog
Route::get('/blog', [\App\Http\Controllers\BlogController::class, "blog"]);

//contact
Route::get('/contact', [\App\Http\Controllers\ContactController::class, "contact"]);

// ADMIN
Route::get('/admin-dashboard', [\App\Http\Controllers\AdminController::class, "dashboard"]);
Route::get('/admin-table1', [\App\Http\Controllers\AdminController::class, "table1"]);
Route::get('/admin-table2', [\App\Http\Controllers\AdminController::class, "table2"]);
Route::get('/admin-table3', [\App\Http\Controllers\AdminController::class, "table3"]);
