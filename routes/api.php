<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TransactionController;

Route::group(['prefix' => 'api'], function () {
    // Rota para obter os dados do usuário autenticado
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    })->name('user');

    // Recurso API para transações
    Route::apiResource('transactions', TransactionController::class)->names([
        'index' => 'transactions.index',
        'store' => 'transactions.store',
        'show' => 'transactions.show',
        'update' => 'transactions.update',
        'destroy' => 'transactions.destroy',
    ]);
});

