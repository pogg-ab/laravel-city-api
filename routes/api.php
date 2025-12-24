<?php

use App\Http\Controllers\CityController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
	Route::apiResource('cities', CityController::class);
});
