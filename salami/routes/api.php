<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductsController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post("/register",[AuthController::class,"signup"]);
Route::post("/login",[AuthController::class,"signin"]);
Route::get("/products",[ProductsController::class,"index"]);
Route::get("/products/show/{id}",[ProductsController::class,"show"]);
Route::post("/logout",[AuthController::class,"logout"]);
Route::get( "/products/search/{name}", [ ProductsController::class, "search" ]);
Route::get( "/products/materials/{material}", [ ProductsController::class, "materialsearch" ]);


Route::group( ["middleware" => ["auth:sanctum"]], function(){
    Route::post("/products",[ProductsController::class,"store"]);
    Route::put("/products/{products}",[ProductsController::class,"update"]);
    Route::delete("/products/{id}",[ProductsController::class,"destroy"]);
});


