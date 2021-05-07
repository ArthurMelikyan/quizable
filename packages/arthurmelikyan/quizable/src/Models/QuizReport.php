<?php

namespace App;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

class QuizReport extends Model
{
    use UsesTenantConnection;

    protected $table = 'quiz_reports';

    protected $fillable = [
        'quiz_id',
        'user_id',
        'first_name',
        'last_name',
        'questions_count',
        'answers_count',
        'quiz_duration',
        'questions_answers',
    ];

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
