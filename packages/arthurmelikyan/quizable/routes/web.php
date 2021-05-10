<?php

use Illuminate\Support\Facades\Route;
use Arthurmelikyan\Quizable\Http\Controllers\QuizController;

Route::get('quizable/dashboard', [QuizController::class, 'index'])->name('quizable.index');
