<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $guarded = [];

    protected $casts = [
        'id' => 'string'
    ];

    protected $keyType = 'string';

    public function chapters() 
    {
        return $this->hasMany('App\Chapter');
    }

    public function subject() 
    {
        return $this->belongsTo('App\Subject');
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
