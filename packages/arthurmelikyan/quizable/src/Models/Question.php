<?php

namespace Arthurmelikyan\Quizable\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes;

    protected $table = 'questions';

    protected $guarded = ['id'];


    protected $appends = [
        'file_url'
    ];

    public function getFileUrlAttribute()
    {
        return asset('storage/'.$this->file);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class)->orderBy('order', 'asc');
    }
}
