<?php

namespace App\Http\Controllers;

use App\Chapter;
use App\Homework;
use App\Module;
use App\UploadedFile as UpFile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Storage;

class ChapterController extends Controller
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
    public function create(Module $module)
    {
        $remaining_chapters = Chapter::where('module_id', $module->id)->pluck('number')->all();
        return view(
            'create-chapter', [
                'module' => $module,
                'remaining_chapters' => array_diff(range(1, 20), $remaining_chapters),
            ],
        );
    }

    public function create_homework(Chapter $chapter)
    {
        $remaining_homeworks = Homework::where('chapter_id', $chapter->id)->pluck('number')->all();
        return view(
            'create-chapter-homework', [
                'chapter' => $chapter,
                'remaining_homeworks' => array_diff(range(1, 20), $remaining_homeworks),
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
        $module = Module::where('id', $request->input()['module_id']);
        if ($module->exists()) {
            try {
                $files = empty($request->chapter_files) ? [] : $request->chapter_files;

                if (!$this->inputDoesNotExist($request, ['title', 'number', 'description'])) {
                    throw new Exception('Veillez entrer toutes les donnees et re-essayez.');
                }
                $uuids = [];
                $i = 0;
                foreach ($files as $file) {
                    if (!$file->isValid()) {
                        return redirect()->back()->withErrors(
                            "L'un de vos fichier n'a pas pu etre ajoute."
                        );
                    }
                    $uuids[$i++] = (string) Str::uuid();
                }

                $i = 0;

                DB::beginTransaction();

                $chapter_id = (string) Str::uuid();

                $chapter = DB::table('chapters')->insert([
                    [
                        'id' => $chapter_id,
                        'title' => $request->input()['title'],
                        'number' => $request->input()['number'],
                        'description' => $request->input()['description'],
                        'module_id' => $request->input()['module_id'],
                    ],
                ]);

                foreach ($files as $file) {
                    $file->storePubliclyAs(
                        'chapter_files',
                        $uuids[$i] . "." . $file->getClientOriginalExtension(),
                        's3'
                    );

                    DB::insert(
                        'insert into uploaded_files (id, name, extension, user_id, chapter_id, url) values (?, ?, ?, ?, ?, ?)', [
                            $uuids[$i],
                            $file->getClientOriginalName(),
                            $file->getClientOriginalExtension(),
                            auth()->user()->id,
                            $chapter_id,
                            "https://csmm-cours.s3.amazonaws.com/chapter_files/"
                            . $uuids[$i++] . "." . $file->getClientOriginalExtension(),
                        ]);
                }
                DB::commit();

                return redirect()
                    ->back()
                    ->withSuccess('Votre chapitre a ete ajoute.');

                // return redirect()->route('edit-subject', ['subject' => $module->get()->first()->subject]);

            } catch (Exception $e) {
                return redirect()->back()->withErrors(
                    "Le chapitre n'a pas ete cree. " . $e->getMessage()
                );
            }
        } else {
            return redirect()->back()->withErrors(
                "Il n'y a pas de module pour ce chapitre. Veillez le selectionner ou creer"
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Chapter $chapter)
    {
        return view('show-chapter', [
            'chapter' => $chapter,
        ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Chapter $chapter)
    {
        $remaining_chapters = Chapter::where('module_id', $chapter->module->id)->pluck('number')->all();
        return view(
            'edit-chapter', [
                'chapter' => $chapter,
                'remaining_chapters' => array_diff(range(1, 20), $remaining_chapters),
            ],
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chapter $chapter)
    {
        $uuids = [];
        $files = empty($request->chapter_files) ? [] : $request->chapter_files;
        try {
            if (!$this->inputDoesNotExist($request, ['title', 'number'])) {
                throw new Exception('Veillez entrer toutes les donnees et re-essayez.');
            }

            $i = 0;

            foreach ($files as $file) {
                if (!$file->isValid()) {
                    return redirect()->back()->withErrors(
                        "L'un de vos fichier n'a pas pu etre ajoute."
                    );
                }
                $uuids[$i++] = (string) Str::uuid();
            }

            $i = 0;

            DB::beginTransaction();

            Chapter::where('id', $chapter->id)
                ->update([
                    'title' => $request->title,
                    'number' => $request->number,
                ]);

            foreach ($files as $file) {
                $file->storePubliclyAs(
                    'chapter_files',
                    $uuids[$i] . "." . $file->getClientOriginalExtension(),
                    's3'
                );

                DB::insert(
                    'insert into uploaded_files (id, name, extension, user_id, chapter_id, url) values (?, ?, ?, ?, ?, ?)', [
                        $uuids[$i],
                        $file->getClientOriginalName(),
                        $file->getClientOriginalExtension(),
                        auth()->user()->id,
                        $chapter->id,
                        "https://csmm-cours.s3.amazonaws.com/chapter_files/"
                        . $uuids[$i++] . "." . $file->getClientOriginalExtension(),
                    ]);
            }

            DB::commit();

            return redirect()
                ->back()
                ->withSuccess('Votre chapitre a ete mis a jour.');

        } catch (Exception $e) {
            DB::rollback();
            $i = 0;
            if ($request->hasFile('chapter_files')) {
                foreach ($files as $file) {
                    Storage::disk('s3')->delete(
                        'chapter_files/' . $uuids[$i++] . '.' . $file->getClientOriginalExtension()
                    );
                }
            }
            return redirect()->back()->withErrors("Ce chapitre n'a pas ete enregistre.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chapter $chapter)
    {
        $module = $chapter->module;
        $up_file_ids = $chapter->uploadedFiles;

        try {
            foreach ($up_file_ids as $file) {
                Storage::disk('s3')->delete(
                    'chapter_files/' . $file->id . '.' . $file->extension
                );
            }
            DB::beginTransaction();
            Chapter::destroy($chapter->id);
            DB::commit();

            return redirect()->route('edit-module', ['module' => $module])
                ->withSuccess("Excellent!!! Le chapitre a ete supprime.");
        } catch (Exception $e) {
            DB::rollback();
            foreach ($up_file_ids as $file) {
                $path = 'chapter_files/' . $file->id . '.' . $file->extension;
                if (!Storage::disk('s3')->exists($path)) {
                    Storage::disk('s3')->put($path);
                }
            }

            return redirect()->back()->withErrors(
                "Le fichier n'a pas ete supprime. Veillez re-essayer."
            );
        }
    }

    public function delete_up_file(Request $request, Chapter $chapter)
    {
        try {
            DB::beginTransaction();
            UpFile::where([
                'chapter_id' => $chapter->id,
                'id' => $request->up_file_id,
            ])->delete();
            DB::commit();

            Storage::disk('s3')->delete(
                'chapter_files/' . $request->up_file_id . '.' . $request->up_file_ext
            );

            return redirect()
                ->back()
                ->withSuccess('Le fichier a ete supprime.');
        } catch (Exception $e) {
            DB::rollback();
            $path = 'chapter_files/' . $request->up_file_id . '.' . $request->up_file_ext;
            if (!Storage::disk('s3')->exists($path)) {
                Storage::disk('s3')->put($path);
            }

            return redirect()->back()->withErrors(
                "Le fichier n'a pas ete supprime. Veillez re-essayer."
            );
        }
    }

}