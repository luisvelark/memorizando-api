<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/



Route::group(["middleware"=>['auth:sanctum']], function(){
  Route::get("user-profile", [AuthController::class,"userProfile"]);

});
// Route::middleware('auth:sanctum')->group(function (){
//   Route::get("user-profile", [AuthController::class,"userProfile"]);
// });


Route::post("register", [AuthController::class,"register"]);
Route::post("login", [AuthController::class,"login"]);

// Route::get("user-profile", [AuthController::class,"userProfile"]);


