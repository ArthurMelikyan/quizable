<?php

use Arthurmelikyan\Quizable\Http\Controllers\AnswerController;
use Arthurmelikyan\Quizable\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;
use Arthurmelikyan\Quizable\Http\Controllers\QuizController;

Route::middleware(explode(',' , config('quizable.middlewares')))->prefix(config('quizable.urlprefix'))->group(function () {
    Route::get('/', [QuizController::class, 'dashboard'])->name('quizable.dashboard');

    Route::prefix('quizable')->group(function () {
        Route::resource('quiz', QuizController::class, ['as' => 'quizable']);
        //    QUIZ API
        Route::get('/api-quiz', [QuizController::class, 'retrieveAllQuizes']);
        Route::get('/api-quiz/{quiz}', [QuizController::class,'retrieveOneByID']);
        Route::post('/api-quiz', [QuizController::class,'createQuiz']);
        Route::patch('/api-quiz-is_active/{quiz}', [QuizController::class,'quizIsActive']);
        Route::patch('/api-quiz/{quiz}/update', [QuizController::class,'updateQuiz']);
        Route::delete('/api-quiz/{quiz}', [QuizController::class,'deleteQuiz']);

        //    QUESTIONS API
        Route::post('/quiz/{quiz_id}/questions/{question_id}', [QuestionController::class,'cloneQuestionWithAnswers']);
        Route::get('/quiz/{quiz_id}/questions', [QuestionController::class,'retrieveAllQuestionByQuizID']);
        Route::post('/quiz/{quiz_id}/questions',  [QuestionController::class, 'createQuestion']);
        Route::patch('/quiz/{quiz_id}/questions/{question_id}', [QuestionController::class, 'updateQuestion']);
        Route::delete('/quiz/{quiz_id}/questions/{question_id}',  [QuestionController::class, 'deleteQuestion']);
        Route::patch('/quiz/{quiz_id}/questions', [QuestionController::class, 'changeQuestionOrderByQuizID']);
        Route::get('/quiz/{quiz_id}/questions/{question_id}',  [QuestionController::class, 'retrieveOneByID']);


        // //    ANSWERS API
        Route::post('/questions/{question_id}/answers', [AnswerController::class, 'createAnswer']);
        Route::get('/questions/{question_id}/answers/{answer_id}', [AnswerController::class,'retrieveOneByID']);
        Route::patch('/questions/{question_id}/update-answers', [AnswerController::class,'updateAnswer']);
        Route::delete('/questions/{question_id}/answers/{answer_id}', [AnswerController::class,'deleteAnswer']);
        Route::delete('/questions/{question_id}/answers', [AnswerController::class, 'deleteAnswerByQuestionID']);
        Route::get('/questions/{question_id}/answers', [AnswerController::class,'retrieveAllByQuestionID']);
        Route::patch('/questions/{question_id}/answers', [AnswerController::class,'changeAnswerOrderByQuestionID']);
    });
});

