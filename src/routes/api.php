<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WalletHistoryController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::get('/', function (Request $request) {
        return $request->user();
    });

    Route::prefix('wallet')->group(function () {
        Route::post('/create', [WalletController::class, 'create']);
        Route::get('/{id?}', [WalletController::class, 'get']);
        Route::put('/update/{id?}', [WalletController::class, 'update']);

        Route::get('/history/{reason?}', [WalletHistoryController::class, 'getHistory']);
    });
});

Route::fallback(function(){
    return response()->json('Роут не определён!', 404);
});
