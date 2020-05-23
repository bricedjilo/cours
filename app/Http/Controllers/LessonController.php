<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Chapter;
use App\Homework;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LessonController extends Controller
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
    public function create(Chapter $chapter)
    {
        $remaining_lessons = Lesson::pluck('number')->all();
        return view(
            'create-lesson', [
                'chapter' => $chapter,
                'remaining_lessons' => array_diff(range(1, 5), $remaining_lessons)
            ],
        );
    }

    public function create_homework(Lesson $lesson)
    {
        $remaining_homeworks = Homework::pluck('number')->all();
        return view(
            'create-lesson-homework', [
                'lesson' => $lesson,
                'remaining_homeworks' => array_diff(range(1, 20), $remaining_homeworks)
            ],
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $chapter = Chapter::where('id', $request->input()['chapter_id']);
        // dd($chapter->get());
        if($chapter->exists())
        {
            Lesson::create([
                'id'        => (string) Str::uuid(),
                'title'     => $request->input()['title'],
                'number'    => $request->input()['number'],
                'chapter_id'   => $request->input()['chapter_id'],
            ])->save();
            return redirect()->route('create-lesson', ['chapter' => $chapter->get()->first()]);
        } else {
            return redirect()->back()->withErrors([
                'msg', "Il n'y a pas de chapitre pour cette lesson. Veillez le selectionner ou creer"
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        $remaining_lessons = Chapter::pluck('number')->all();
        return view(
            'edit-lesson', [
                'lesson' => $lesson,
                'remaining_lessons' => array_diff(range(1, 5), $remaining_lessons)
            ],
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lesson $lesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        //
    }
}
