<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\CaseController;
Route::get('/cases', [CaseController::class, 'index']);

