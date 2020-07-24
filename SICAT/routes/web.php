<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    /* Rota dashboard */
    Route::name('dashboard.')->prefix('dashboard')->group(function () {
        Route::get('/', 'DashboardController@index')->name('index');
    });

    /* Rotas de funcionários */
    Route::put('funcionarios/{user}/disabilitar', 'UserController@disable')->name('user.disable');
    Route::resource('funcionarios', 'UserController')->names('user')
        ->parameters(['funcionarios' => 'user'])
        ->except(['edit']);

    /* Rotas de Ordem de Serviço */
    Route::name('order.')->prefix('ordem')->group(function () {
        /* GET */
        Route::get('/registros', 'OrderServiceController@index')->name('index');
        Route::get('/cadastrar', 'OrderServiceController@create')->name('create');
        Route::get('/list', 'OrderServiceController@list')->name('list');
        Route::get('/show/{id}', 'OrderServiceController@show');

        /* POST */
        Route::post('/add', 'OrderServiceController@add')->name('add');

        /* PUT */
        Route::put('/update/{id}', 'OrderServiceController@update')->name('update');

        /* DELETE */
        Route::delete('/disable/{id}', 'OrderServiceController@disable')->name('disable');
    });

    /* Rotas de Postos de trabalho */
    Route::name('workstation.')->prefix('posto-de-trabalho')->group(function () {
        /* GET */
        Route::get('/registros', 'WorkstationController@index')->name('index');
        Route::get('/cadastrar', 'WorkstationController@create')->name('create');
        Route::get('/list', 'WorkstationController@list')->name('list');
        Route::get('/show/{id}', 'WorkstationController@show');

        /* POST */
        Route::post('/add', 'WorkstationController@add')->name('add');

        /* PUT */
        Route::put('/update/{id}', 'WorkstationController@update')->name('update');

        /* DELETE */
        Route::delete('/disable/{id}', 'WorkstationController@disable')->name('disable');
    });

    /* Rotas Itens de empréstimo */
    Route::name('item.')->prefix('item')->group(function () {
        /* GET */
        Route::get('/registros', 'ItemController@index')->name('index');
        Route::get('/cadastrar', 'ItemController@create')->name('create');
        Route::get('/list', 'ItemController@list')->name('list');
        Route::get('/show/{id}', 'ItemController@show');

        /* POST */
        Route::post('/add', 'ItemController@add')->name('add');

        /* PUT */
        Route::put('/update/{id}', 'ItemController@update')->name('update');

        /* DELETE */
        Route::delete('/disable/{id}', 'ItemController@disable')->name('disable');
    });

    /* Rotas de Empréstimo */
    Route::name('borrowing.')->prefix('emprestimo')->group(function () {
        /* GET */
        Route::get('/registros', 'BorrowingController@index')->name('index');
        Route::get('/cadastrar', 'BorrowingController@create')->name('create');
        Route::get('/list', 'BorrowingController@list')->name('list');
        Route::get('/show/{id}', 'BorrowingController@show');

        /* POST */
        Route::post('/add', 'BorrowingController@add')->name('add');

        /* PUT */
        Route::put('/update/{id}', 'BorrowingController@update')->name('update');

        /* DELETE */
        Route::delete('/disable/{id}', 'BorrowingController@disable')->name('disable');
    });
});
