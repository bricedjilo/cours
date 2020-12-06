<?php

namespace App\Http\Controllers;

use App\Classe;
use App\Subject;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->is_teacher) {
            $classes = $user->classes;
            return view('home-teacher', [
                'classe' => $classes ? $classes : [],
                'user' => $user,
            ]);
        } else {
            $class = $user->classes->first();
            $class_name = $class->name;
            $class_group = Classe::where('name', $class_name)->pluck('id')->all();
            $subjects = Subject::whereIn('classe_id', $class_group)->get();
            // dd($subjects);
            return view('home-student', [
                'class' => $class,
                'subjects' => $subjects ? $subjects : [],
                'user' => $user,
            ]);
        }

    }
}