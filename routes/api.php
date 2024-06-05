<?php

use App\Http\Controllers\BukuControrller;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Auth
Route::post('/login/auth', [UserController::class, 'login']);

Route::post('/register/auth', [UserController::class, 'register']);

Route::get('/login/auth', [UserController::class, 'login']);

Route::get('/user/all', [UserController::class, 'user']);

Route::get('/user/{id}/info', [UserController::class, 'user_info']);



// Buku
Route::get('/buku/all', [BukuControrller::class, 'buku_all']);

Route::get('/buku/popular', [BukuControrller::class, 'buku_popular']);

Route::get('/buku/{id}/info', [BukuControrller::class, 'buku_info']);

Route::get('/penulis/buku/{buku_id}', [BukuControrller::class, 'penulis_info']);



// Ratings
Route::get('/ratings/all', [BukuControrller::class, 'ratings_all']);

Route::get('/ratings/{id}/info', [BukuControrller::class, 'ratings_all']);

Route::get('/ratings/{id}/avg', [BukuControrller::class, 'ratings_avg']);


//Rental
Route::get('/rental/all', [BukuControrller::class, 'rental_all']);

Route::post('/rental/request', [BukuControrller::class, 'rental_req']);


// Fav
Route::post('/fav/user/{id}/{buku}', [BukuControrller::class, 'fav_user']);

Route::get('/fav/user/{id}/{buku}', [BukuControrller::class, 'fav_user']);


//Admin
Route::post('media/upload/auth', [BukuControrller::class, 'upload_file']);


