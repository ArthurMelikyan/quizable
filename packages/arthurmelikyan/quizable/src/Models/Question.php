<?php

namespace App;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use SoftDeletes, UsesTenantConnection;

    protected $table = 'questions';

    protected $fillable = [
        'quiz_id',
        'title',
        'type',
        'file',
        'file_type',
        'url',
        'order'
    ];


    protected $appends = [
        'file_url'
    ];

    public function getFileUrlAttribute()
    {
        return config('aws.aws_url') . '/' . getUuid() . '/' . $this->file;
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
