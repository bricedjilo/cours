<?php

namespace App\Http\Controllers;

use App\Homework;
use App\Module;
use App\Chapter;
use App\Lesson;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\UploadedFile as UpFile;
use Illuminate\Http\UploadedFile;
use Storage;
use Exception;

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
        $folder = "module_hw_files";
        
        if(!empty($request->input()['module_id'])) {
            $mod_chap_lesson = Module::where('id', $request->input()['module_id']);
            $homework['module_id'] = $mod_chap_lesson->get()->first()->id;
        } 
        elseif (!empty($request->input()['chapter_id'])) {
            $mod_chap_lesson = Chapter::where('id', $request->input()['chapter_id']);
            $homework['chapter_id'] = $mod_chap_lesson->get()->first()->id;
            $folder = "chapter_hw_files";
        }
        elseif (!empty($request->input()['lesson_id'])) {
            $mod_chap_lesson = Lesson::where('id', $request->input()['lesson_id']);
            $homework['lesson_id'] = $mod_chap_lesson->get()->first()->id;
            $folder = "lesson_hw_files";
        }
        
        $files = empty($request->$folder) ? [] : $request->$folder;

        if($mod_chap_lesson->exists())
        {
            $uuids = [];
            $homework_id = (string) Str::uuid();

            try {
                
                if (!$this->inputDoesNotExist($request, ['title', 'content', 'deadline', 'number']))
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
                
                DB::table('homeworks')->insert(
                    array_merge(
                        [
                            'id'        => $homework_id,
                            'title'     => trim($request->input()['title']),
                            'number'    => $request->input()['number'],
                            'content'   => trim($request->input()['content']),
                            'deadline'  => $request->input()['deadline'],
                            'user_id'   => auth()->user()->id
                        ],
                        $homework
                    )
                );
               
                foreach ($files as $file) {
                    $file->storePubliclyAs(
                        $folder . "/",
                        $uuids[$i] . "." . $file->getClientOriginalExtension(),
                        's3'
                    );

                    DB::insert(
                        'insert into uploaded_files (id, name, extension, user_id, homework_id, url) values (?, ?, ?, ?, ?, ?)', [
                        $uuids[$i],
                        $file->getClientOriginalName(),
                        $file->getClientOriginalExtension(),
                        auth()->user()->id,
                        $homework_id,
                        "https://csmm-cours.s3.amazonaws.com/" . $folder . "/" 
                        . $uuids[$i++] . "." . $file->getClientOriginalExtension()
                    ]);
                }
                DB::commit();

                return redirect()
                    ->back()
                    ->withSuccess('Votre module a ete ajoute.');
            
            } catch(Exception $e) {
                dd($e);
                DB::rollback();
                Homework::where('id', $homework_id)->delete();
                $i = 0;
                if($request->hasFile($folder)) {
                    foreach ($files as $file) {
                        Storage::disk('s3')->delete(
                            $folder . $uuids[$i++] . '.' . $file->getClientOriginalExtension()
                        );
                    }
                }
                return redirect()->back()->withErrors(
                    "Le devoir n'a pas pu etre cree. Veillez re-essayer."
                );
            }
        } else {
            return redirect()->back()->withErrors(
                "Il n'y a pas de module, chapitre, lecon pour ce devoir. Veillez le selectionner ou creer"
            );
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
    public function edit(Homework $homework, $parent)
    {
        $view = "edit-module-homework";
        if($parent == "chapter") {
            $view = "edit-chapter-homework";
        } elseif($parent == 'lesson') {
            $view = "edit-lesson-homework";
        }
        $remaining_homeworks = Homework::pluck('number')->all();
        return view(
            $view, [
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
        $uuids = [];
        $parent = [];
        $mod_chap_lesson = '';
        $folder = "module_hw_files";
        
        if(!empty($request->input()['module_id'])) {
            $mod_chap_lesson = Module::where('id', $request->input()['module_id']);
            $parent['module_id'] = $mod_chap_lesson->get()->first()->id;
        } 
        elseif (!empty($request->input()['chapter_id'])) {
            $mod_chap_lesson = Chapter::where('id', $request->input()['chapter_id']);
            $parent['chapter_id'] = $mod_chap_lesson->get()->first()->id;
            $folder = "chapter_hw_files";
        }
        elseif (!empty($request->input()['lesson_id'])) {
            $mod_chap_lesson = Lesson::where('id', $request->input()['lesson_id']);
            $parent['lesson_id'] = $mod_chap_lesson->get()->first()->id;
            $folder = "lesson_hw_files";
        }
        
        $files = empty($request->$folder) ? [] : $request->$folder;

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

            Homework::where('id', $homework->id)
            ->update(
                array_merge([
                    'title' => trim($request->input()['title']),
                    'number' => $request->input()['number'],
                    'content' => trim($request->input()['content']),
                    'deadline' => $request->input()['deadline'],
                ], $parent)
            );

            foreach ($files as $file) {
                $file->storePubliclyAs(
                    $folder,
                    $uuids[$i] . "." . $file->getClientOriginalExtension(),
                    's3'
                );

                DB::insert(
                    'insert into uploaded_files (id, name, extension, user_id, homework_id, url) values (?, ?, ?, ?, ?, ?)', [
                    $uuids[$i],
                    $file->getClientOriginalName(),
                    $file->getClientOriginalExtension(),
                    auth()->user()->id,
                    $homework->id,
                    "https://csmm-cours.s3.amazonaws.com/" . $folder . "/" 
                    . $uuids[$i++] . "." . $file->getClientOriginalExtension()
                ]);
            }

            DB::commit();

            return redirect()
                ->back()
                ->withSuccess('Votre devoir a ete mis a jour.');

        } catch(Exception $e) {
            return redirect()->back()->withErrors("Ce devoir n'a pas ete enregistre.");
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
        $mod_chap_lesson = [];
        $view = "";
        $up_file_ids = $homework->uploadedFiles;

        $folder = "";
        if($homework->lesson_id) {
            $folder = "lesson_hw_files/";
            $mod_chap_lesson = ['lesson' => $homework->lesson];
            $view = "edit-lesson";
        } else if($homework->chapter_id) {
            $folder = "chapter_hw_files/";
            $mod_chap_lesson = ['chapter' => $homework->chapter];
            $view = "edit-chapter";
        } else {
            $folder = "module_hw_files/";
            $mod_chap_lesson = ['module' => $homework->module];
            $view = "edit-module";
        }

        try{
            foreach($up_file_ids as $file) {
                Storage::disk('s3')->delete(
                    $folder . $file->id . '.' . $file->extension
                );
            }
            
            DB::beginTransaction();
            Homework::destroy($homework->id);
            DB::commit();

            return redirect()->route($view, $mod_chap_lesson)
                ->withSuccess("Excellent!!! Le devoir a ete supprime.");
        } catch(Exception $e) {
            DB::rollback();
            foreach($up_file_ids as $file) {
                $path = $folder . $file->id . '.' . $file->extension;
                if(!Storage::disk('s3')->exists($path)) {
                    Storage::disk('s3')->put($folder, $file->id . '.' . $file->extension);
                }
            }
            
            return redirect()->back()->withErrors([
                'msg', "Le devoir n'a pas ete supprime. Veillez re-essayer."
            ]);
        }
    }

    public function delete_up_file(Request $request, Homework $homework) {
        try {
            DB::beginTransaction();
            UpFile::where([
                'homework_id' => $homework->id,
                'id'        => $request->up_file_id
            ])->delete();
            DB::commit();

            Storage::disk('s3')->delete(
                'module_hw_files/' . $request->up_file_id . '.' . $request->up_file_ext
            );

            return redirect()
                ->back()
                ->withSuccess('Le fichier a ete supprime.');
        } catch(Exception $e) {
            DB::rollback();
            $path = 'module_hw_files/' . $request->up_file_id . '.' . $request->up_file_ext;
            if(!Storage::disk('s3')->exists($path)) {
                Storage::disk('s3')->put($path);
            }
            
            return redirect()->back()->withErrors([
                'msg', "Le fichier n'a pas ete supprime. Veillez re-essayer."
            ]);
        }
    }
}
