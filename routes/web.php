<?php

declare(strict_types=1);

use App\Http\Controllers\User\UserDeleteController;
use App\Http\Controllers\User\UserGetController;
use App\Http\Controllers\User\UserIndexController;
use App\Http\Controllers\User\UserUpdateController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('users')->group(function () {
    Route::get('/', [UserIndexController::class, 'handle']);
    Route::get('{id}', [UserGetController::class, 'handle'])
        ->whereNumber('id');
    Route::match(['put', 'patch'], '{id}', [UserUpdateController::class, 'handle'])
        ->whereNumber('id');
    Route::delete('{id}', [UserDeleteController::class, 'handle'])
        ->whereNumber('id');
});
