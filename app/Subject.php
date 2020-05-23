<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $casts = [
        'id' => 'string'
    ];

    protected $keyType = 'string';

    public function classe() 
    {
        return $this->belongsTo('App\Classe');
    }

    public function user() 
    {
        return $this->belongsTo('App\User');
    }

    public function modules() 
    {
        return $this->hasMany('App\Module');
    }

}