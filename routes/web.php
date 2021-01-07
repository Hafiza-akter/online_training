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

Route::get('/', 'LoginController@index')->name('home');
Route::get('/login/trainee', 'LoginController@loginTrainee')->name('traineeLogin');
Route::post('/login/trainee', 'LoginController@loginTraineeSubmit')->name('traineeLogin.submit');
Route::get('/signup/trainee', 'LoginController@signupTrainee')->name('traineeSignup');
Route::post('/signup/trainee', 'LoginController@signupTraineeSubmit')->name('traineeSignup.submit');
Route::get("/reset/token/trainee", "LoginController@tokenResetTrainee")->name(('tokenReset.trainee'));
Route::post("/reset/token/trainee", "LoginController@tokenResetSubmitTrainee")->name(('token.reset.submit.trainee'));


Route::get('/login/trainer', 'LoginController@loginTrainer')->name('trainerLogin');
Route::post('/login/trainer', 'LoginController@loginTrainerSubmit')->name('trainerLogin.submit');
Route::get('/signup/trainer', 'LoginController@signupTrainer')->name('trainerSignup');
Route::post('/signup/trainer', 'LoginController@signupTrainerSubmit')->name('trainerSignup.submit');
Route::get("token-verify/{id}", "LoginController@tokenVerify");
Route::get("/reset/token/trainer", "LoginController@tokenReset")->name(('tokenReset'));
Route::post("/reset/token/trainer", "LoginController@tokenResetSubmit")->name(('token.reset.submit'));

Route::get("/trainer/schedule", "ScheduleController@scheduleView")->name(('trainerSchedule'));
Route::get("/user/trainer/view", "TrainerController@trainerView")->name(('trainerView'));
Route::get("/user/trainer/view", "TrainerController@trainerView")->name(('trainerView'));
Route::get("/user/inquery", "LoginController@inquery")->name(('userInquery'));
Route::get("/user/plan/purchase", "TraineeController@planPurchase")->name(('user.plan.purchase'));


Route::prefix('admin')->group(function(){
    Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');
    Route::get('/user/management/view', 'Admin\UserController@userManagement')->name('admin.user.management.view');
    Route::get('/user/management/details', 'Admin\UserController@userManagementDeatil')->name('admin.user.management.detail');
    Route::get('/schedule/management/view', 'Admin\DashboardController@scheduleManagement')->name('admin.schedule.management.view');
    
});