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

// Auth Routes
Auth::routes();

Route::get('/home', 'HomeController@index')
    ->name('home');

// Teacher access only
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
Route::delete('/modules/{module}/uploaded-files', 'ModuleController@delete_up_file')
    ->name('delete-module-up-file')
    ->middleware('check_teacher');
Route::get('/modules/{module}/homeworks/create', 'ModuleController@create_homework')
    ->name('create-module-homework')
    ->middleware('check_teacher');

Route::get('/chapters/{module}/create', 'ChapterController@create')
    ->name('create-chapter')
    ->middleware('check_teacher');
Route::get('/chapters/{chapter}/homeworks/create', 'ChapterController@create_homework')
    ->name('create-chapter-homework')
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
Route::delete('/chapters/{chapter}', 'ChapterController@destroy')
    ->name('delete-chapter')
    ->middleware('check_teacher');
Route::delete('/chapters/{chapter}/uploaded-files', 'ChapterController@delete_up_file')
    ->name('delete-chapter-up-file')
    ->middleware('check_teacher');

Route::get('/lessons/{lesson}/edit', 'LessonController@edit')
    ->name('edit-lesson')
    ->middleware('check_teacher');
Route::post('/lessons', 'LessonController@store')
    ->name('store-lesson')
    ->middleware('check_teacher');
Route::get('/lessons/{chapter}/create', 'LessonController@create')
    ->name('create-lesson')
    ->middleware('check_teacher');
Route::get('/lessons/{lesson}/homeworks/create', 'LessonController@create_homework')
    ->name('create-lesson-homework')
    ->middleware('check_teacher');
Route::delete('/lessons/{lesson}', 'LessonController@destroy')
    ->name('delete-lesson')
    ->middleware('check_teacher');
Route::put('/lessons/{lesson}', 'LessonController@update')
    ->name('update-lesson')
    ->middleware('check_teacher');
Route::delete('/lessons/{lesson}/uploaded-files', 'LessonController@delete_up_file')
    ->name('delete-lesson-up-file')
    ->middleware('check_teacher');

Route::get('/homeworks/{homework}/{parent}/edit', 'HomeworkController@edit')
    ->name('edit-mcl-homework')
    ->middleware('check_teacher');
Route::post('/homeworks', 'HomeworkController@store')
    ->name('store-homeowrk')
    ->middleware('check_teacher');
Route::delete('/homeworks/{homework}', 'HomeworkController@destroy')
    ->name('delete-homework')
    ->middleware('check_teacher');
Route::put('/homeworks/{homework}', 'HomeworkController@update')
    ->name('update-homework')
    ->middleware('check_teacher');
Route::delete('/homeworks/{homework}/uploaded-files', 'HomeworkController@delete_up_file')
    ->name('delete-homework-up-file')
    ->middleware('check_teacher');

Route::delete('/uploaded-files/{upfile}', 'UploadedFileController@destroy')
    ->name('delete-uploaded-file')
    ->middleware('check_teacher');

// Student access only
Route::get('/subjects/{subject}/show', 'SubjectController@show')
    ->name('show-subject');

Route::get('/modules/{module}/show', 'ModuleController@show')
    ->name('show-module');

Route::get('/chapters/{chapter}/show', 'ChapterController@show')
    ->name('show-chapter');

Route::get('/lessons/{lesson}/show', 'LessonController@show')
    ->name('show-lesson');

Route::get('/homeworks/{homework}/show', 'HomeworkController@show')
    ->name('show-homework');

Route::get('/homeworks/{homework}/{parent}/show', 'HomeworkController@show')
    ->name('show-mcl-homework');

// Admin access only
Route::get('/admin', 'AdminController@index')
    ->name('admin-home')
    ->middleware('check_admin');

Route::get('/admin/student/create', 'AdminController@create')
    ->name('admin-create-student')
    ->middleware('check_admin');

Route::get('/admin/professor/create', 'AdminController@create')
    ->name('admin-create-professor')
    ->middleware('check_admin');

Route::get('/admin/staff/create', 'AdminController@create')
    ->name('admin-create-staff')
    ->middleware('check_admin');

Route::get('/admin/accounts/search', 'AdminController@search')
    ->name('admin-search')
    ->middleware('check_admin');

Route::post('/admin/accounts/find', 'AdminController@find')
    ->name('admin-find-account')
    ->middleware('check_admin');

// Route::post('/users/{token}/show', 'UserController@show')
//     ->name('admin-show-account')
//     ->middleware('check_admin');

Route::post('/admin/register/accounts', 'AdminController@store')
    ->name('register')
    ->middleware('check_admin');