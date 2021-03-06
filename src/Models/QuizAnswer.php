<?php

namespace Arthurmelikyan\Quizable\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAnswer extends Model
{

    protected $table = 'quiz_answers';

    protected $guarded = ['id'];

    public function user_quiz(): BelongsTo
    {
        return $this->belongsTo(UserQuiz::class);
    }

    public function quiz_report(): BelongsTo
    {
        return $this->belongsTo(QuizReport::class);
    }

    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function scopeByUserQuizQuestionAndAnswer(Builder $builder, int $user_quiz_id, int $question_id, ?int $answer_id): Builder
    {
        if ($answer_id) {
            $builder
                ->where('user_quiz_id', $user_quiz_id)
                ->where('question_id', $question_id)
                ->where('answer_id', $answer_id);
        }

        return $builder
            ->where('user_quiz_id', $user_quiz_id)
            ->where('question_id', $question_id);
    }
}
