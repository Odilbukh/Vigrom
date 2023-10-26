<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::apiResource('/users', \App\Http\Controllers\UserController::class);
Route::apiResource('/wallets', \App\Http\Controllers\WalletController::class)->except('update');
Route::get('/transactions', [\App\Http\Controllers\TransactionController::class, 'index']);
Route::get('/transactions/{id}', [\App\Http\Controllers\TransactionController::class, 'show']);
Route::post('/transactions', [\App\Http\Controllers\TransactionController::class, 'create']);


