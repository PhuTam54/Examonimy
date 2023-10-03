<?php
// ADMIN
Route::get('/admin-dashboard', [\App\Http\Controllers\AdminController::class, "dashboard"]);
Route::get('/admin-table1', [\App\Http\Controllers\AdminController::class, "table1"]);
Route::get('/admin-table2', [\App\Http\Controllers\AdminController::class, "table2"]);
Route::get('/admin-table3', [\App\Http\Controllers\AdminController::class, "table3"]);
Route::get('/order-details/{order}', [\App\Http\Controllers\AdminController::class, "orderDetails"]);
