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


Auth::routes();

Route::get('/dashboard', 'HomeController@index')->name('home');
Route::middleware('auth')->get('/users', 'Users\IndexController@index')->name('users');
Route::middleware('auth')->get('/tasks', 'Tasks\IndexController@index')->name('tasks');
