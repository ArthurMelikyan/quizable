<?php

namespace Arthurmelikyan\Quizable\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class QuizController extends BaseController {
    public function index(){
        return view('arthurmelikyan::layouts');
    }
}
