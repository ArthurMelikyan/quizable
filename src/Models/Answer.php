<?php

namespace Arthurmelikyan\Quizable\Models;


use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';

    protected $guarded = ['id'];

    protected $appends = [
        'file_url'
    ];

    protected $casts = [
        'is_right' => 'boolean'
    ];

    public function getFileUrlAttribute()
    {
        if ($this->file) {
            return config('quizable.asseturl').$this->file;
        }
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
