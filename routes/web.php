<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/cases');
});

use App\Http\Controllers\CaseController;
Route::get('/cases', [CaseController::class, 'index']);