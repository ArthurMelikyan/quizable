<?php

namespace Arthurmelikyan\Quizable\Http\Controllers;

use Arthurmelikyan\Quizable\Models\Quiz;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class QuizController extends BaseController {
    public function dashboard(){
        return view('arthurmelikyan::quiz.dashboard.index');
    }

    public function index(){
        $quizes = Quiz::orderByDesc('id')->paginate(20);
        return view('arthurmelikyan::quiz.index',compact('quizes'));
    }
}
