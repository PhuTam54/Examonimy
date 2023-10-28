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

// Middleware - auth
Route::middleware("auth")->group(function () {
    // my exam
    Route::controller(\App\Http\Controllers\MyExamController::class)->group(function () {
        Route::get('my-exam',  "myExam");

        Route::get('exam-info/{exam}',  "examInfo");
        Route::put('exam-info/{exam}',  "examCancel");

        Route::get('exam-taking/{exam}',  "examTaking");
        Route::post('exam-taking/{exam}',  "examSubmit");
    });

    // my result
    Route::controller(\App\Http\Controllers\MyResultController::class)->group(function () {
        Route::get('my-result',  "myResult");
        Route::get('exam-retaken/{exam}',  "examRetaken");
        Route::get('thank-you',  "thankYou");
    });

    // Paypal
    Route::controller(\App\Http\Controllers\PayPalController::class)->group(function () {
//        Route::get('paypal-process/{enrollment}', "paypalProcess");
        Route::get('paypal-success/{enrollment}', "paypalSuccess");
        Route::get('paypal-cancel', "paypalCancel");
    });
});

//contact
Route::get('/contact', [\App\Http\Controllers\ContactController::class, "contact"]);

// ADMIN
Route::middleware(["auth", "is_admin"])->prefix("admin")->group(function () { //
    include_once "admin.php";
});

// Authenticate
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
