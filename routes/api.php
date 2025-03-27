<?php

use App\Http\Controllers\LicenseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(LicenseController::class)
    ->prefix('license')
    ->name('license.')
    ->group(function(){
        Route::post('/check', 'check')
            ->name('check');
    });