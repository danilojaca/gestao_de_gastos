<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::resource('/', 'App\Http\Controllers\HomeController');

Auth::routes();

Route::resource('/gestao', 'App\Http\Controllers\GestaoGastoController');
//Route::put('/edit/{?}', 'App\Http\Controllers\GestaoGastoController@update')->name('update');
//Route::delete('/delete/{?}', 'App\Http\Controllers\GestaoGastoController@destroy')->name('destroy');