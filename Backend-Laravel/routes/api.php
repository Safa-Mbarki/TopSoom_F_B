<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PriceController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AdminController;


Route::resource('price',PriceController::class);
Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::get('users',[AuthController::class,'index']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout',[AuthController::class,'logout']);
});

Route::post('admin',[AdminController::class,'insertCSV']);