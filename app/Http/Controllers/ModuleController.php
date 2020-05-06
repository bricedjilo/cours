<?php

namespace App\Http\Controllers;

use App\Module;
use App\Subject;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subject = Subject::where('id', $request->input()['subject_id']);
        if($subject->exists())
        {
            Module::create([
                'id'        => (string) Str::uuid(),
                'title'     => $request->input()['title'],
                'number'    => $request->input()['number'],
                'subject_id'   => $request->input()['subject_id'],
            ])->save();
            return redirect()->route('create-module', ['subject' => $subject->get()->first()]);
        } else {
            return redirect()->back()->withErrors([
                'msg', "Il n'y a pas de module pour ce chapitre. Veillez le selectionner ou creer"
            ]);
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
        $remaining_modules = Module::pluck('number')->all();
        return view(
            'edit-module', [
                'module' => $module,
                'remaining_modules' => array_diff(range(1, 5), $remaining_modules)
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
        try {
            Module::where('id', $module->id)
            ->update([
                'title' => $request->input()['title'],
                'number' => $request->input()['number'],
            ]);
            $remaining_modules = Module::pluck('number')->all();

            return redirect()->route('edit-module', [
                'module' => $module,
                'remaining_modules' => array_diff(range(1, 5), $remaining_modules)
            ])->withSuccess("Excellent!!! Le module a ete enregistre.");

        } catch(Exception $e) {

            $remaining_modules = Module::pluck('number')->all();
            return redirect()->route('edit-module', [
                'module' => $module,
                'remaining_modules' => array_diff(range(1, 5), $remaining_modules)
            ])->withErrors("Ce module n'a pas ete enregistrer.");
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
        Module::destroy($module->id);
        return redirect()->route('edit-subject', ['subject' => $subject]);
    }
}
