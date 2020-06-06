<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Chapter;
use App\Homework;
use App\UploadedFile as UpFile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Storage;
use Exception;

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
        $remaining_lessons = Lesson::where('chapter_id', $chapter->id)->pluck('number')->all();
        return view(
            'create-lesson', [
                'chapter' => $chapter,
                'remaining_lessons' => array_diff(range(1, 5), $remaining_lessons)
            ],
        );
    }

    public function create_homework(Lesson $lesson)
    {
        // $remaining_homeworks = Homework::where('lesson_id', $lesson->id)->pluck('number')->all();
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
        if($chapter->exists())
        {
            $uuids = [];
            $files = empty($request->lesson_files) ? [] : $request->lesson_files;

            try {
                if (!$this->inputDoesNotExist($request, ['title', 'number']))
                {
                    throw new Exception('Veillez entrer toutes les donnees et re-essayez.');
                }
                
                $i = 0;
                foreach ($files as $file) {
                    if(!$file->isValid()) {
                        return redirect()->back()->withErrors(
                            "L'un de vos fichier n'a pas pu etre ajoute."
                        ); 
                    }
                    $uuids[$i++] = (string) Str::uuid();
                }

                $i = 0;

                DB::beginTransaction();

                $lesson_id = (string) Str::uuid();
                $lesson = DB::insert(
                    'insert into lessons (id, title, number, chapter_id) values (?, ?, ?, ?)', [
                    $lesson_id,
                    $request->input()['title'],
                    $request->input()['number'],
                    $request->input()['chapter_id'],
                ]);

                foreach ($files as $file) {
                    $file->storePubliclyAs(
                        'lesson_files',
                        $uuids[$i] . "." . $file->getClientOriginalExtension(),
                        's3'
                    );

                    DB::insert(
                        'insert into uploaded_files (id, name, extension, user_id, lesson_id, url) values (?, ?, ?, ?, ?, ?)', [
                        $uuids[$i],
                        $file->getClientOriginalName(),
                        $file->getClientOriginalExtension(),
                        auth()->user()->id,
                        $lesson_id,
                        "https://csmm-cours.s3.amazonaws.com/lesson_files/" 
                        . $uuids[$i++] . "." . $file->getClientOriginalExtension()
                    ]);
                }
                DB::commit();

                return redirect()
                    ->back()
                    ->withSuccess('Votre module a ete ajoute.');
            } catch(Exception $e) {
                DB::rollback();

                $i = 0;
                if($request->hasFile('lesson_files')) {
                    foreach ($files as $file) {
                        Storage::disk('s3')->delete(
                            'lesson_files/' . $uuids[$i++] . '.' . $file->getClientOriginalExtension()
                        );
                    }
                }
                
                return redirect()->back()->withErrors(
                    "La lecon n'a pas pu etre creee. Veillez re-essayer."
                );
            }

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
        $remaining_lessons = Lesson::where('chapter_id', $lesson->chapter->id)->pluck('number')->all();
        
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
        $uuids = [];
        $files = empty($request->lesson_files) ? [] : $request->lesson_files;
        try {
            if (!$this->inputDoesNotExist($request, ['title', 'number']))
            {
                return redirect()->back()->withErrors(
                    'Veillez entrer toutes les donnees et re-essayez.'
                );
            }
            
            $i = 0;
            foreach ($files as $file) {
                if(!$file->isValid()) {
                    return redirect()->back()->withErrors(
                        "L'un de vos fichier n'a pas pu etre ajoute."
                    ); 
                }
                $uuids[$i++] = (string) Str::uuid();
            }
            
            $i = 0;

            DB::beginTransaction();

            Lesson::where('id', $lesson->id)
            ->update([
                'title' => $request->input()['title'],
                'number' => $request->input()['number'],
            ]);

            foreach ($files as $file) {
                $file->storePubliclyAs(
                    'lesson_files',
                    $uuids[$i] . "." . $file->getClientOriginalExtension(),
                    's3'
                );

                DB::insert(
                    'insert into uploaded_files (id, name, extension, user_id, lesson_id, url) values (?, ?, ?, ?, ?, ?)', [
                    $uuids[$i],
                    $file->getClientOriginalName(),
                    $file->getClientOriginalExtension(),
                    auth()->user()->id,
                    $lesson->id,
                    "https://csmm-cours.s3.amazonaws.com/lesson_files/" 
                    . $uuids[$i++] . "." . $file->getClientOriginalExtension()
                ]);
            }

            DB::commit();

            return redirect()
                ->back()
                ->withSuccess('Votre lecon a ete mise a jour.');

        } catch(Exception $e) {
            DB::rollback();
            $i = 0;
            if($request->hasFile('lesson_files')) {
                foreach ($files as $file) {
                    Storage::disk('s3')->delete(
                        'lesson_files/' . $uuids[$i++] . '.' . $file->getClientOriginalExtension()
                    );
                }
            }
            return redirect()->back()->withErrors("Cette lecon n'a pas ete mise a jour.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        $chapter = $lesson->chapter;
        $up_file_ids = $lesson->uploadedFiles;

        try{
            foreach($up_file_ids as $file) {
                Storage::disk('s3')->delete(
                    'lesson_files/' . $file->id . '.' . $file->extension
                );
            }
            DB::beginTransaction();
            Lesson::destroy($lesson->id);
            DB::commit();

            return redirect()->route('edit-chapter', ['chapter' => $chapter])
                ->withSuccess("Excellent!!! La leçon a ete supprimee.");
        } catch(Exception $e) {
            DB::rollback();
            foreach($up_file_ids as $file) {
                $path = 'lesson_files/' . $file->id . '.' . $file->extension;
                if(!Storage::disk('s3')->exists($path)) {
                    Storage::disk('s3')->put($path);
                }
            }
            
            return redirect()->back()->withErrors(
                "Le fichier n'a pas ete supprime. Veillez re-essayer."
            );
        }
    }

    public function delete_up_file(Request $request, Lesson $lesson) {
        try {
            DB::beginTransaction();
            UpFile::where([
                'lesson_id' => $lesson->id,
                'id'        => $request->up_file_id
            ])->delete();
            DB::commit();

            Storage::disk('s3')->delete(
                'lesson_files/' . $request->up_file_id . '.' . $request->up_file_ext
            );

            return redirect()
                ->back()
                ->withSuccess('Le fichier a ete supprime.');
        } catch(Exception $e) {
            DB::rollback();
            $path = 'lesson_files/' . $request->up_file_id . '.' . $request->up_file_ext;
            if(!Storage::disk('s3')->exists($path)) {
                Storage::disk('s3')->put($path);
            }
            
            return redirect()->back()->withErrors(
                "Le fichier n'a pas ete supprime. Veillez re-essayer."
            );
        }
    }
}
