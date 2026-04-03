<?php

use App\Http\Controllers\AttemptController;
use App\Http\Controllers\UpdateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UpdateController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/check', [AttemptController::class, 'checkCode']);

<<<<<<< HEAD
=======

>>>>>>> 99afcfe8763c34502acf89ac3c0cb1ccac6a219a
Route::get('/sensordata', [UpdateController::class, 'sensordata']);
Route::get('/led/{code}/{led_no}/{change}/{status}', [UpdateController::class, 'led_on']);
Route::get('/led/{code}/{led_no}', [UpdateController::class, 'led_on']);
Route::get('/get_status', [UpdateController::class, 'get_status']);
