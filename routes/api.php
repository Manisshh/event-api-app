<?php

use App\Http\Controllers\Api\v1\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\v1\EventController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function(){ //Version1 apis
    Route::prefix('user')->group(function(){ //Common Prefix For User Authentication
        Route::post('login',[UserController::class,'login']);
        Route::post('register',[UserController::class,'register']);
    });

    //Category apis
    Route::prefix('category')->group(function(){
        Route::get("/",[CategoryController::class,"index"])->middleware('auth:sanctum');
        Route::get("/{category}",[CategoryController::class,'show'])->middleware("auth:sanctum");
        Route::post("/",[CategoryController::class,'store'])->middleware("auth:sanctum");
        Route::put("/{category}",[CategoryController::class,"update"])->middleware('auth:sanctum');
        Route::delete("/{category}",[CategoryController::class,'destroy'])->middleware("auth:sanctum");
    });

    //Events apis
    Route::apiResource('events',EventController::class)->middleware('auth:sanctum');
    Route::get('/events/category/{category}',[EventController::class,'getByCategory'])->middleware('auth:sanctum');
});
