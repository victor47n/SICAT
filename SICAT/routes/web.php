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
Route::put('/locais/{id}/desabilitar', 'LocaleController@disable')->name('locale.disable');
Route::put('/locais/{id}/habilitar', 'LocaleController@able')->name('locale.able');
Route::get('/locais/list', 'LocaleController@list')->name('locale.list');
Route::resource('locais', 'LocaleController')->names('locale');

Route::put('/postos/{id}/desabilitar', 'WorkstationController@disable')->name('workstation.disable');
Route::put('/postos/{id}/habilitar', 'WorkstationController@able')->name('workstation.able');
Route::resource('postos', 'WorkstationController')->names('workstation');
