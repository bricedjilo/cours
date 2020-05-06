<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $guarded = [];

    protected $casts = [
        'id' => 'string'
    ];

    protected $keyType = 'string';

    public function chapter() 
    {
        return $this->belongsTo('App\Chapter');
    }
}
