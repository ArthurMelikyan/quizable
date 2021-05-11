<?php

use Illuminate\Support\Facades\Route;

// use Arthurmelikyan\Quizable\Quizable;
// use Arthurmelikyan\Quizable\QuizableServiceProvider;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
