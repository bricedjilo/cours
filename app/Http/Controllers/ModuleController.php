<?php

namespace App\Http\Controllers;

use App\Module;
use App\Subject;
use App\Homework;
use App\UploadedFile as UpFile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Storage;
use Exception;

class ModuleController extends Controller
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
    public function create(Subject $subject)
    {
        $remaining_modules = Module::pluck('number')->all();
        return view(
            'create-module', [
                'subject' => $subject,
                'remaining_modules' => array_diff(range(1, 5), $remaining_modules)
            ],
        );
    }

    public function create_homework(Module $module)
    {
        $remaining_homeworks = Homework::where('module_id', $module->id)->pluck('number')->all();
        return view(
            'create-module-homework', [
                'module' => $module,
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
        $subject = Subject::where('id', $request->input()['subject_id']);
        $files = empty($request->module_files) ? [] : $request->module_files;
        if($subject->exists()) # && $request->hasFile('module_files')
        {
            $uuids = [];
            try {
                if (!$this->inputDoesNotExist($request, ['title', 'number']))
                {
                    return redirect()->back()->withErrors(
                        "Veillez entrer toutes les donnees et re-essayez."
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

                // dd($request->input());

                DB::beginTransaction();

                $module_id = (string) Str::uuid();
                $module = DB::insert(
                    'insert into modules (id, title, number, subject_id) values (?, ?, ?, ?)', [
                    $module_id,
                    $request->input()['title'],
                    $request->input()['number'],
                    $request->input()['subject_id'],
                ]);

                foreach ($files as $file) {
                    $file->storePubliclyAs(
                        'module_files',
                        $uuids[$i] . "." . $file->getClientOriginalExtension(),
                        's3'
                    );

                    DB::insert(
                        'insert into uploaded_files (id, name, extension, user_id, module_id, url) values (?, ?, ?, ?, ?, ?)', [
                        $uuids[$i],
                        $file->getClientOriginalName(),
                        $file->getClientOriginalExtension(),
                        auth()->user()->id,
                        $module_id,
                        "https://csmm-cours.s3.amazonaws.com/module_files/" 
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
                if($request->hasFile('module_files')) {
                    foreach ($files as $file) {
                        Storage::disk('s3')->delete(
                            'module_files/' . $uuids[$i++] . '.' . $file->getClientOriginalExtension()
                        );
                    }
                }
                
                return redirect()->back()->withErrors(
                    "Le module n'a pas pu etre cree. Veillez re-essayer."
                );
            }
        } else {
            return redirect()->back()->withErrors(
                "Il n'y a pas de matiere pour ce module. Veillez le selectionner ou creer"
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function edit(Module $module)
    {
        $remaining_modules = Module::where("subject_id", $module->subject->id)->pluck('number')->all();
        return view(
            'edit-module', [
                'module' => $module,
                'remaining_modules' => array_diff(range(1, 20), $remaining_modules)
            ],
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Module $module)
    {
        $uuids = [];
        $files = empty($request->module_files) ? [] : $request->module_files;
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

            Module::where('id', $module->id)
            ->update([
                'title' => $request->input()['title'],
                'number' => $request->input()['number'],
            ]);

            foreach ($files as $file) {
                $file->storePubliclyAs(
                    'module_files',
                    $uuids[$i] . "." . $file->getClientOriginalExtension(),
                    's3'
                );

                DB::insert(
                    'insert into uploaded_files (id, name, extension, user_id, module_id, url) values (?, ?, ?, ?, ?, ?)', [
                    $uuids[$i],
                    $file->getClientOriginalName(),
                    $file->getClientOriginalExtension(),
                    auth()->user()->id,
                    $module->id,
                    "https://csmm-cours.s3.amazonaws.com/module_files/" 
                    . $uuids[$i++] . "." . $file->getClientOriginalExtension()
                ]);
            }

            DB::commit();

            return redirect()
                ->back()
                ->withSuccess('Votre module a ete mis a jour.');

        } catch(Exception $e) {
            DB::rollback();
            $i = 0;
            if($request->hasFile('module_files')) {
                foreach ($files as $file) {
                    Storage::disk('s3')->delete(
                        'module_files/' . $uuids[$i++] . '.' . $file->getClientOriginalExtension()
                    );
                }
            }
            return redirect()->back()->withErrors("Ce module n'a pas ete enregistrer.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module)
    {
        $subject = $module->subject;
        $up_file_ids = $module->uploadedFiles;

        try{
            foreach($up_file_ids as $file) {
                Storage::disk('s3')->delete(
                    'module_files/' . $file->id . '.' . $file->extension
                );
            }
            DB::beginTransaction();
            Module::destroy($module->id);
            DB::commit();

            return redirect()->route('edit-subject', ['subject' => $subject])
                ->withSuccess("Excellent!!! Le module a ete supprime.");
        } catch(Exception $e) {
            DB::rollback();
            foreach($up_file_ids as $file) {
                $path = 'module_files/' . $file->id . '.' . $file->extension;
                if(!Storage::disk('s3')->exists($path)) {
                    Storage::disk('s3')->put('module_files/', $file->id . '.' . $file->extension);
                }
            }
            
            return redirect()->back()->withErrors([
                'msg', "Le fichier n'a pas ete supprime. Veillez re-essayer."
            ]);
        }
    }

    public function delete_up_file(Request $request, Module $module) {
        try {
            DB::beginTransaction();
            UpFile::where([
                'module_id' => $module->id,
                'id'        => $request->up_file_id
            ])->delete();
            DB::commit();

            Storage::disk('s3')->delete(
                'module_files/' . $request->up_file_id . '.' . $request->up_file_ext
            );

            return redirect()
                ->back()
                ->withSuccess('Le fichier a ete supprime.');
        } catch(Exception $e) {
            DB::rollback();
            $path = 'module_files/' . $request->up_file_id . '.' . $request->up_file_ext;
            if(!Storage::disk('s3')->exists($path)) {
                Storage::disk('s3')->put($path);
            }
            
            return redirect()->back()->withErrors([
                'msg', "Le fichier n'a pas ete supprime. Veillez re-essayer."
            ]);
        }
    }

}
