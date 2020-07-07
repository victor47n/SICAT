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
Route::get('/funcionarios/listar', 'UserController@index')->name('user.index');
//Route::resource('/funcionarios/listar', 'UserController');
Route::get('/funcionarios/cadastrar', 'UserController@create')->name('user.create');
Route::get('funcionario/show', 'UserController@show')->name('user.show');
//POST
Route::post('/funcionarios/add', 'UserController@add')->name('user.add');


/* Rotas de Ordem de Serviço */
Route::get('/ordem/listar', 'OrdemServicoController@index')->name("ordem.index");
Route::get('/ordem/cadastrar', 'OrdemServicoController@create')->name("ordem.create");
