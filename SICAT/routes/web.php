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

/* Rotas de Ordem de Serviço */
Route::get('/ordem/listar', 'OrdemServicoController@index')->name("ordem.index");
Route::get('/ordem/cadastrar', 'OrdemServicoController@create')->name("ordem.create");

/* Rotas de Postos de trabalho */
Route::get('/local/listar', 'LocaleController@index')->name("local.index");
Route::get('/local/cadastrar', 'LocaleController@create')->name("local.create");
Route::post('/local/add', 'LocaleController@add')->name("local.add");
Route::get('/local/show/{id}', 'LocaleController@show')->name('local.show');
Route::delete('/local/disable/{id}', 'LocaleController@disable')->name('local.disable');
Route::put('/local/update/{id}', 'LocaleController@update')->name('local.update');
Route::get('/local/list', 'LocaleController@list')->name('local.list');

//criar controller proprio para isso
Route::delete('/workstation/disable/{id}', 'WorkstationController@disable')->name('workstation.disable');
Route::delete('/workstation/able/{id}', 'WorkstationController@able')->name('workstation.able');
Route::put('/workstation/{id}', 'WorkstationController@update')->name('workstation.update');
Route::post('/workstation/add', 'WorkstationController@add')->name('workstation.add');
