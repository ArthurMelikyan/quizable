<?php

namespace Arthurmelikyan\Quizable\Models;

use Illuminate\Database\Eloquent\Model;

class QuizReport extends Model
{

    protected $table = 'quiz_reports';

    protected $guarded = ['id'];

    protected $appends = [
        'question_answers'
    ];

    public function getQuestionAnswersAttribute()
    {
        return "{$this->questions_count} / {$this->answers_count}";
    }

    public static function laratablesCustomActions($quiz_report)
    {
        return view('dashboard.quiz.custom._actions', [
            'quiz_report' => $quiz_report
        ])->render();
    }

    public function quizAnswers(){
        return $this->hasMany(QuizAnswer::class, 'quiz_report_id', 'id');
    }

    public function quiz(){
        return $this->hasOne(Quiz::class, 'id', 'quiz_id');
    }
}
