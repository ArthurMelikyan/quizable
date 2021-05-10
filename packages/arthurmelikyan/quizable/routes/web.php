<?php

use Illuminate\Support\Facades\Route;
use Arthurmelikyan\Quizable\Http\Controllers\QuizController;
use Illuminate\Routing\RouteGroup;

Route::middleware([])->prefix('quizable')->group(function () {
    Route::get('dashboard', [QuizController::class, 'dashboard'])->name('quizable.dashboard');
    Route::resource('quizes',QuizController::class, ['as' => 'quizable']);
});

