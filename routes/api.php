<?php

use App\Http\Controllers\PlayerController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['api']], function () {
    Route::get('/players', PlayerController::class);
    Route::post('/players', [PlayerController::class, 'store']);
    Route::get('/players/{playerId}', [PlayerController::class, 'show']);
    Route::put('/players/{playerId}', [PlayerController::class, 'update']);
    Route::delete('/players/{playerId}', [PlayerController::class, 'destroy'])->middleware('verify.static.token');
    Route::post('/teams/process', [PlayerController::class, 'processTeam']);
});
