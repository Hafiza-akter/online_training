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

Route::get('/', 'LoginController@index');
Route::get('/login/trainee', 'LoginController@loginTrainee')->name('traineeLogin');
Route::get('/login/trainer', 'LoginController@loginTrainer')->name('trainerLogin');
