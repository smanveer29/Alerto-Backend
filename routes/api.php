<?php

use App\Http\Controllers\RecordsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix("records")->group(function()
{
    Route::get('list',[RecordsController::class,'show']);
    Route::post('insert',[RecordsController::class,'insert']);
});

Route::prefix('area')->group(function()
{
    Route::post('bar-chart',[RecordsController::class,'areaData']);
    Route::get('list',[RecordsController::class,'areaList']);
});
    