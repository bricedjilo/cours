<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class UploadedFile extends Model
{
    protected $guarded = [];

    protected $casts = [
        'id' => 'string'
    ];

    protected $keyType = 'string';

    public function module() 
    {
        return $this->belongsTo('App\Module');
    }

    public function chapter() 
    {
        return $this->belongsTo('App\Chapter');
    }

    public function lesson() 
    {
        return $this->belongsTo('App\Lesson');
    }

    public function homework() 
    {
        return $this->belongsTo('App\Homework');
    }
}
