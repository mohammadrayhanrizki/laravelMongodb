<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\Api\CaseController;
Route::get('/cases', [CaseController::class, 'dashboard']);

