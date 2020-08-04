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

//Store
Route::post('/projects', 'ProjectController@store');
//Index
Route::get('/projects', 'ProjectController@index');
//Show
Route::get('projects/{project}', 'ProjectController@show');
