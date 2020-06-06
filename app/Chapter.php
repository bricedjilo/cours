<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $casts = [
        'id' => 'string'
    ];

    protected $keyType = 'string';

    public function module() 
    {
        return $this->belongsTo('App\Module');
    }

    public function lessons() 
    {
        return $this->hasMany('App\Lesson');
    }

    public function homeworks() 
    {
        return $this->hasMany('App\Homework');
    }

    public function uploadedFiles() 
    {
        return $this->hasMany('App\UploadedFile');
    }

}