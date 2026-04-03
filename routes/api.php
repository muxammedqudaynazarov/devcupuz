<?php

use App\Http\Controllers\AttemptController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UpdateController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/check', [AttemptController::class, 'checkCode']);

Route::get('/sensordata', [UpdateController::class, 'sensordata']);
Route::get('/led/{code}/{led_no}/{change}/{status}', [UpdateController::class, 'led_on']);
Route::get('/led/{code}/{led_no}', [UpdateController::class, 'led_on']);
Route::get('/get_status', [UpdateController::class, 'get_status']);
