<?php
// ADMIN
Route::controller(\App\Http\Controllers\AdminController::class)->group(function () {
    Route::get('/admin-dashboard', "dashboard");

    // Orders
    Route::get('/admin-table1', "table1");
    Route::get('/order-details/{order}', "orderDetails");

    // Products
    Route::get('/admin-table2', "table2");
    Route::get('/product-details/{product}', "productDetails");

    Route::get('/product-add', "productAdd");
    Route::post('/product-add', "productStore");

    Route::get('/product-edit/{product}', "productEdit");
    Route::put('/product-edit/{product}', "productUpdate");

    Route::delete('/product-delete/{product}', "productDelete");

    // Categories
    Route::get('/admin-table3', "table3");
});
