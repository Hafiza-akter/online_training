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
Route::post('/login/trainer', 'LoginController@loginTrainerSubmit')->name('trainerLogin.submit');
Route::get('/signup/trainer', 'LoginController@signupTrainer')->name('trainerSignup');
Route::post('/signup/trainer', 'LoginController@signupTrainerSubmit')->name('trainerSignup.submit');
Route::get("token-verify/{id}", "LoginController@tokenVerify");
Route::get("/reset/token", "LoginController@tokenReset")->name(('tokenReset'));
Route::post("/reset/token", "LoginController@tokenResetSubmit")->name(('token.reset.submit'));

