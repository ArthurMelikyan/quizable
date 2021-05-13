<?php

use Illuminate\Support\Facades\Route;
use Arthurmelikyan\Quizable\Http\Controllers\QuizController;
use Illuminate\Routing\RouteGroup;

Route::middleware(['web'])->prefix('quizable')->group(function () {
    Route::get('dashboard', [QuizController::class, 'dashboard'])->name('quizable.dashboard');
    Route::resource('quiz',QuizController::class, ['as' => 'quizable']);


    //    QUIZ API
    Route::get('/api-quiz', 'QuizController@retrieveAllQuizes');
    Route::get('/api-quiz/{quiz}', 'QuizController@retrieveOneByID');
    Route::post('/api-quiz', 'QuizController@createQuiz');
    Route::patch('/api-quiz-is_active/{quiz}', 'QuizController@quizIsActive');
    Route::patch('/api-quiz/{quiz}/update', 'QuizController@updateQuiz');
    Route::delete('/api-quiz/{quiz}', 'QuizController@deleteQuiz');

    //    QUESTIONS API
    // Route::post('/quiz/{quiz_id}/questions/{question_id}', 'QuestionController@cloneQuestionWithAnswers');
    // Route::get('/quiz/{quiz_id}/questions', 'QuestionController@retrieveAllQuestionByQuizID');
    // Route::post('/quiz/{quiz_id}/questions', 'QuestionController@createQuestion');
    // Route::patch('/quiz/{quiz_id}/questions/{question_id}', 'QuestionController@updateQuestion');
    // Route::delete('/quiz/{quiz_id}/questions/{question_id}', 'QuestionController@deleteQuestion');
    // Route::patch('/quiz/{quiz_id}/questions', 'QuestionController@changeQuestionOrderByQuizID');
    // Route::get('/quiz/{quiz_id}/questions/{question_id}', 'QuestionController@retrieveOneByID');


    // //    ANSWERS API
    // Route::post('/questions/{question_id}/answers', 'AnswerController@createAnswer');
    // Route::get('/questions/{question_id}/answers/{answer_id}', 'AnswerController@retrieveOneByID');
    // Route::patch('/questions/{question_id}/update-answers', 'AnswerController@updateAnswer');
    // Route::delete('/questions/{question_id}/answers/{answer_id}', 'AnswerController@deleteAnswer');
    // Route::delete('/questions/{question_id}/answers', 'AnswerController@deleteAnswerByQuestionID');
    // Route::get('/questions/{question_id}/answers', 'AnswerController@retrieveAllByQuestionID');
    // Route::patch('/questions/{question_id}/answers', 'AnswerController@changeAnswerOrderByQuestionID');
});

