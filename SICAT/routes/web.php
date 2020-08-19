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
    Route::put('funcionarios/{user}/desabilitar', 'UserController@disable')->name('user.disable');
    Route::resource('funcionarios', 'UserController')->names('user')
        ->parameters(['funcionarios' => 'user'])
        ->except(['edit']);

    Route::put('ordens/{order}/desabilitar', 'OrderServiceController@disable')->name('order.disable');
    Route::resource('ordens', 'OrderServiceController')->names('order')
        ->parameters(['ordens' => 'order'])
        ->except(['edit']);

    Route::put('locais/{locale}/desabilitar', 'LocaleController@disable')->name('locale.disable');
    Route::resource('locais', 'LocaleController')->names('locale')
        ->parameters(['locais' => 'locale'])
        ->except(['edit']);

    Route::put('postos/{workstation}/desabilitar', 'WorkstationController@disable')->name('workstation.disable');
    Route::resource('postos', 'WorkstationController')->names('workstation')
        ->parameters(['postos' => 'workstation'])
        ->except(['index', 'create', 'show', 'edit']);

    Route::put('itens/{item}/desabilitar', 'ItemController@disable')->name('item.disable');
    Route::resource('itens', 'ItemController')->names('item')
        ->parameters(['itens' => 'item'])
        ->except(['edit']);

    Route::put('emprestimos/{borrowing}/desabilitar', 'BorrowingController@disable')->name('borrowing.disable');
    Route::get('emprestimos/select', 'BorrowingController@select')->name('borrowing.select');
    Route::resource('emprestimos', 'BorrowingController')->names('borrowing')
        ->parameters(['emprestimos' => 'borrowing'])
        ->except(['edit']);
});
