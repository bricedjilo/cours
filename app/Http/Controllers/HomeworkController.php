<?php

namespace App\Http\Controllers;

use App\Homework;
use App\Module;
use App\Chapter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class HomeworkController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $homework = [];
        $mod_chap_lesson = '';
        if(!empty($request->input()['module_id'])) {
            $mod_chap_lesson = Module::where('id', $request->input()['module_id']);
            $homework['module_id'] = $mod_chap_lesson->get()->first()->id;
        } 
        elseif (!empty($request->input()['chapter_id'])) {
            $mod_chap_lesson = Chapter::where('id', $request->input()['chapter_id']);
            $homework['chapter_id'] = $mod_chap_lesson->get()->first()->id;
        }
        elseif (!empty($request->input()['lesson_id'])) {
            $mod_chap_lesson = Lesson::where('id', $request->input()['lesson_id']);
            $homework['lesson_id'] = $mod_chap_lesson->get()->first()->id;
        }
        
        if($mod_chap_lesson->exists())
        {
            Homework::create(
                array_merge(
                    [
                        'id'        => (string) Str::uuid(),
                        'title'     => trim($request->input()['title']),
                        'number'    => $request->input()['number'],
                        'content'   => trim($request->input()['content']),
                        'deadline'  => $request->input()['deadline'],
                        'user_id'   => auth()->user()->id
                    ],
                    $homework
                )
            )->save();
            return redirect()->back()
            ->withSuccess('Votre devoir a ete ajoute.');
        } else {
            return redirect()->back()->withErrors([
                'msg', "Il n'y a pas de module pour ce chapitre. Veillez le selectionner ou creer"
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function show(Homework $homework)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function edit(Homework $homework)
    {
        $remaining_homeworks = Homework::pluck('number')->all();
        return view(
            'edit-homework', [
                'homework' => $homework,
                'remaining_homeworks' => array_diff(range(1, 20), $remaining_homeworks)
            ],
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Homework $homework)
    {
        try {
            Homework::where('id', $homework->id)
            ->update([
                'title' => trim($request->input()['title']),
                'number' => $request->input()['number'],
                'content' => trim($request->input()['content']),
                'deadline' => $request->input()['deadline'],
            ]);
            $remaining_homeworks = Homework::pluck('number')->all();

            return redirect()->route('edit-homework', [
                'homework' => $homework,
                'remaining_homeworks' => array_diff(range(1, 5), $remaining_homeworks)
            ])->withSuccess("Excellent!!! Le devoir a ete enregistre.");

        } catch(Exception $e) {

            $remaining_homeworks = Homework::pluck('number')->all();
            return redirect()->route('edit-homework', [
                'homework' => $module,
                'remaining_homeworks' => array_diff(range(1, 5), $remaining_homeworks)
            ])->withErrors("Ce devoir n'a pas ete enregistre.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function destroy(Homework $homework)
    {
        $module = $homework->module;
        Homework::destroy($homework->id);
        return redirect()->route('edit-module', ['module' => $module]);
    }
}
