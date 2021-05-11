<?php

namespace Arthurmelikyan\Quizable\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    protected $table = 'quizes';

    protected $guarded = ['id'];

    protected $casts = [
        'answer_by_one'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }


    public function quiz_user()
    {
        return $this->hasOne(config('auth.providers.users.model'), 'id', 'user_id');
    }

    public static function laratablesCustomActions($quiz)
    {
        return view('dashboard.quiz.custom._actions', compact('quiz'))->render();
    }


    public function reports (){
        return $this->hasMany(QuizReport::class);
    }
}
