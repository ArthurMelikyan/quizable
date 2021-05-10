<?php

use Illuminate\Support\Facades\Route;

use Arthurmelikyan\Quizable\Quizable;
use Arthurmelikyan\Quizable\QuizableServiceProvider;
Route::get('/', function () {
    $quizable = new Quizable();
    dd($quizable->sayHello('Arthur'));
    return view('welcome');
});


// "url": "/home/arth/Sites/quizable/packages/arthurmelikyan/quizable",
// "url": "/Users/gevorgsargsyan/Sites/quiz-package/packages/arthurmelikyan/quizable",
