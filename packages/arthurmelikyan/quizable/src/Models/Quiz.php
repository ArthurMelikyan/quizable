<?php

namespace App;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Quiz extends Model
{
    use SoftDeletes, UsesTenantConnection;
    use Sluggable ,  SluggableScopeHelpers;
    /**
     * @var string
     */
    protected $table = 'quizes';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'time_limit',
        'answer_by_one',
        'slug',
        'is_active',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'answer_by_one'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * @param $quiz
     * @return array|string
     * @throws \Throwable
     */

    public function quiz_user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function laratablesCustomActions($quiz)
    {
        return view('dashboard.quiz.custom._actions', compact('quiz'))->render();
    }

    public function courses(): MorphToMany
    {
        return $this->morphedByMany('App\Course', 'quizable', 'quizables');
    }

    public function reports (){
        return $this->hasMany(QuizReport::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }


}
