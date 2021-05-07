<?php

use Illuminate\Support\Facades\Route;

use Arthurmelikyan\Quizable\Quizable;
use Arthurmelikyan\Quizable\QuizableServiceProvider;
Route::get('/', function () {
    // $quizable = new Quizable();
    // $quizable->sayHello('Arthur');
    return view('welcome');
});
