<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $casts = [
        'id' => 'string'
    ];

    protected $keyType = 'string';

    public function subject() 
    {
        return $this->belongsTo('App\Subject');
    }

    public function classe() 
    {
        return $this->belongsTo('App\Classe');
    }
}
