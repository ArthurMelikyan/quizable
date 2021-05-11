<?php

namespace Arthurmelikyan\Quizable\Http\Controllers;

use Arthurmelikyan\Quizable\Http\Requests\QuizRequest;
use Arthurmelikyan\Quizable\Models\Quiz;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class QuizController extends BaseController {
    public function dashboard(){
        return view('arthurmelikyan::quiz.dashboard.index');
    }


     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){
        $quizes = Quiz::orderByDesc('id')->paginate(20);
        return view('arthurmelikyan::quiz.crud.index',compact('quizes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('arthurmelikyan::quiz.crud.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuizRequest $request)
    {
        Quiz::create($request->validated());
        return redirect()->route('quizable.quiz.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404); // TODO make this
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Quiz $quiz)
    {
        return view('arthurmelikyan::quiz.crud.edit', compact('quiz'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuizRequest $request,Quiz $quiz)
    {
        $quiz->update($request->validated());
        return redirect()->route('quizable.quiz.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return back();
    }
}
