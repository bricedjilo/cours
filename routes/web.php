<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')
    ->name('home');

Route::get('/subjects/{subject}', 'SubjectController@show')
    ->name('show-subject');
Route::get('/subjects/{subject}/edit', 'SubjectController@edit')
    ->name('edit-subject')
    ->middleware('check_teacher');

Route::get('/modules/{subject}/create', 'ModuleController@create')
    ->name('create-module')
    ->middleware('check_teacher');
Route::get('/modules/{module}/edit', 'ModuleController@edit')
    ->name('edit-module')
    ->middleware('check_teacher');
Route::post('/modules', 'ModuleController@store')
    ->name('store-module')
    ->middleware('check_teacher');
Route::put('/modules/{module}', 'ModuleController@update')
    ->name('update-module')
    ->middleware('check_teacher');
Route::delete('/modules/{module}', 'ModuleController@destroy')
    ->name('delete-module')
    ->middleware('check_teacher');

Route::get('/chapters/{module}/create', 'ChapterController@create')
    ->name('create-chapter')
    ->middleware('check_teacher');
Route::get('/chapters/{chapter}/edit', 'ChapterController@edit')
    ->name('edit-chapter')
    ->middleware('check_teacher');
Route::post('/chapters', 'ChapterController@store')
    ->name('store-chapter')
    ->middleware('check_teacher');
Route::put('/chapters/{chapter}', 'ChapterController@update')
    ->name('update-chapter')
    ->middleware('check_teacher');
Route::delete('/chapters/{chapter}', 'ModuleController@destroy')
    ->name('delete-chapter')
    ->middleware('check_teacher');

Route::post('/lessons', 'LessonController@store')
    ->name('store-lesson')
    ->middleware('check_teacher');
Route::get('/lessons/{chapter}/create', 'LessonController@create')
    ->name('create-lesson')
    ->middleware('check_teacher');
Route::delete('/lessons', 'LessonController@destroy')
    ->name('delete-lesson')
    ->middleware('check_teacher');