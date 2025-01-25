<?php

use Acquire\Modules\User\UsersController;
use Illuminate\Support\Facades\Route;

Route::prefix('user')->group(function () {
    Route::get('self', [UsersController::class, 'selfRequest']);
});
