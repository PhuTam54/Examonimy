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
// shop
Route::get('/shop-grid', [\App\Http\Controllers\ShopGridController::class, "shop"]);
// pages
Route::get('/shopping-cart', [\App\Http\Controllers\PagesController::class, "shoppingCart"]);
Route::get('/shop-details', [\App\Http\Controllers\PagesController::class, "shopDetails"]);
Route::get('/checkout', [\App\Http\Controllers\PagesController::class, "checkOut"]);
Route::get('/blog-details', [\App\Http\Controllers\PagesController::class, "blogDetails"]);
// blog
Route::get('/blog', [\App\Http\Controllers\BlogController::class, "blog"]);
//contact
Route::get('/contact', [\App\Http\Controllers\ContactController::class, "contact"]);
