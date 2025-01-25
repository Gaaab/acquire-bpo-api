<?php

use Acquire\Modules\Customer\CustomersController;
use Illuminate\Support\Facades\Route;

Route::prefix('customers')->group(function () {
    Route::get('/', [CustomersController::class, 'getAll']);
    Route::post('/', [CustomersController::class, 'createCustomer']);
    Route::get('list', [CustomersController::class, 'getAllWithPagination']);
    Route::put('update/{customer}', [CustomersController::class, 'updateCustomer']);
    Route::delete('{customer}', [CustomersController::class, 'removeCustomer']);
});
