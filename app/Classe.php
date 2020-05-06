<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $casts = [
        'id' => 'string'
    ];

    protected $keyType = 'string';

    public function user() 
    {
        return $this->belongsTo('App\User');
    }

    public function subjects()
    {
        return $this->hasMany('App\Subject');
    }

}