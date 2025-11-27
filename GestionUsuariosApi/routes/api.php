<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);
Route::post('/logout',   [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::get('/user', fn (Request $request) => $request->user());
});

Route::get('/test', function () {
    return response()->json(['message' => 'Test OK']);
});

/*Route::get('/user', function (Request $request) {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/users', [UserController::class]);
    return $request->user();
})->middleware('auth:sanctum');*/

