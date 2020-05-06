<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Module;
use App\Chapter;

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
        // $remaining_chapters = Module::pluck('number')->all();
        // return view(
        //     'create-chapter', [
        //         'module' => $module,
        //         'remaining_chapters' => array_diff(range(1, 5), $remaining_chapters)
        //     ],
        // );
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
        if($module->exists())
        {
            DB::table('chapters')->insert([
                [
                    'id'        => (string) Str::uuid(),
                    'title'     => $request->input()['title'],
                    'number'    => $request->input()['number'],
                    'description'   => $request->input()['description'],
                    'module_id'     => $request->input()['module_id'],
                ],
            ]);
            return redirect()->route('edit-subject', ['subject' => $module->get()->first()->subject]);
        } else {
            return redirect()->back()->withErrors([
                'msg', "Il n'y a pas de module pour ce chapitre. Veillez le selectionner ou creer"
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Chapter $chapter)
    {
        $remaining_chapters = Chapter::pluck('number')->all();
        return view(
            'edit-chapter', [
                'chapter' => $chapter,
                'remaining_chapters' => array_diff(range(1, 20), $remaining_chapters)
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
        Chapter::where('id', $chapter->id)
          ->update([
              'title' => $request->title,
              'number' => $request->number,
            ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
