<?php

use App\Http\Controllers\AttemptController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/check', [AttemptController::class, 'checkCode']);
