<?php

use Illuminate\Support\Facades\Route;
use Arthurmelikyan\Quizable\Http\Controllers\QuizController;
use Illuminate\Routing\RouteGroup;

Route::middleware(['web'])->prefix('quizable')->group(function () {
    Route::get('dashboard', [QuizController::class, 'dashboard'])->name('quizable.dashboard');
    Route::resource('quiz',QuizController::class, ['as' => 'quizable']);
});

