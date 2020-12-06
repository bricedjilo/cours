<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Classe;

class EleveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_subjects(Classe $lass, User $user) {
        return $user->classe->subjects();
    }
}