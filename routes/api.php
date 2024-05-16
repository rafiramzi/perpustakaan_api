<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login/auth', [UserController::class, 'login']);

Route::post('/register/auth', [UserController::class, 'register']);

Route::get('/login/auth', [UserController::class, 'login']);

Route::get('/user/all', [UserController::class, 'user']);