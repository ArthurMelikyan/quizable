<?php

namespace Arthurmelikyan\Quizable\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserQuiz extends Model
{
    use SoftDeletes;

    protected $table = 'user_quizes';

    protected $guarded = ['id'];

    protected $casts = [
        'is_completed' => 'boolean'
    ];

    public function scopeByUserIDAndQuizID(Builder $builder, int $user_id, int $quiz_id): Builder
    {
        return $builder
            ->where('user_id', $user_id)
            ->where('quiz_id', $quiz_id)
            ->orderBy('id', 'desc');
    }

    public function quiz_answers(): HasMany
    {
        return $this->hasMany(QuizAnswer::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(config('auth.providers.users.model'), 'id', 'user_id');
    }
}
