<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController as RegisterController;
use App\Http\Controllers\UserController as UserController;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('check_admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create-account');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $register = new RegisterController();
            $data = $request->request->all();
            if ($register->validator($data)->fails()) {
                return redirect()->back()->withErrors($register->validator($data));
            }
            $register->store($data);

            return redirect()
                ->back()
                ->withSuccess("Le compte ( {$data['first_name']} {$data['last_name']} ) a ete ajoute.");
        } catch (Exception $e) {
            return redirect()->back()->withErrors(
                "Ce compte n'a pas ete ajoute."
            );
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function search()
    {
        return view('admin.search-account');
    }

    public function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
        ]);
    }

    public function find(Request $request)
    {
        $params = $request->request->all();
        try {
            if ($this->validator($params)->fails()) {
                return redirect()->back()->withErrors($this->validator($params));
            }
            $user = (new UserController())->find($params['first_name'], $params['last_name']);
            return view('admin.result-account-search');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(
                "Ce compte n'existe pas."
            );
        }
    }
}