<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware(Authenticate::using('sanctum'));

//posts
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::apiResource('/posts/', App\Http\Controllers\Api\PostController::class);



Route::get('leaderboard', [GameController::class, 'getLeaderboard']);
Route::post('leaderboard', [GameController::class, 'saveScore']);


Route::middleware('auth:sanctum')->put('profile', [UserController::class, 'updateProfile']);
