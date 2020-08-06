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
})->name('welcome');

/* Rotas de funcionários */

Route::prefix('funcionarios')->group(function () {
    Route::get('/registros', 'UserController@index')->name('user.index');
    Route::get('/cadastrar', 'UserController@create')->name('user.create');
    Route::get('/list', 'UserController@list')->name('user.list');
    Route::get('/show/{id}', 'UserController@show');
    //POST
    Route::post('/add', 'UserController@add')->name('user.add');
    //PUT
    Route::put('/update/{id}', 'UserController@update')->name('user.update');
    Route::delete('/disable/{id}', 'UserController@disable')->name('user.disable');
});

/* Rotas de Postos de trabalho */
Route::put('/local/disable/{id}', 'LocaleController@disable')->name('local.disable');
Route::put('/local/able/{id}', 'LocaleController@able')->name('local.able');
Route::get('/local/list', 'LocaleController@list')->name('local.list');
Route::resource('local', 'LocaleController')->names('local');

Route::put('/workstation/disable/{id}', 'WorkstationController@disable')->name('workstation.disable');
Route::put('/workstation/able/{id}', 'WorkstationController@able')->name('workstation.able');
Route::resource('workstation', 'WorkstationController')->names('workstation');
