<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/trainer/calender', 'ScheduleController@calenderView')->name('trainerCalender');
Route::post('create-paypal-transaction', 'PaymentController@createPayment')->name('cp');
Route::post('confirm-paypal-transaction', 'PaymentController@confirmPayment')->name('conp');
Route::post('api/getcourse', 'TrainingController@getcourse')->name('getcourse');
Route::post('api/getcoursedetails', 'TrainingController@getcoursedetails')->name('getcoursedetails');

Route::post('api/iconcreation/{user_id}', 'TrainerController@iconCreation')->name('icon_creation');
Route::post('api/favouritetrainer/', 'TrainingController@favouritetrainer')->name('favouritetrainer');
Route::post('api/removefavouritetrainer/', 'TrainingController@removeFavourite')->name('removeFavourite');
Route::post('api/favouritesorting/', 'TraineeController@favouritesorting')->name('favouritesorting');
Route::post('api/previoustraininglist/', 'TrainingController@previoustraininglist')->name('previoustraininglist');
Route::post('api/trainerreservation/', 'TrainingController@trainerreservation')->name('trainerreservation');
Route::post('api/getTime/', 'ReservationController@getTime')->name('getTime');
Route::post('api/jitsiUserSubmitTime/', 'ReservationController@jitsiUserSubmitTime')->name('jitsiUserSubmitTime');
Route::post('api/previousMenuList/', 'TrainingController@previousMenuList')->name('previousMenuList');

// merge code from api project
// merge code from api project
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function() {
    // トークン認証が必要なルーティングを記述
    Route::get('bbs','BbsEntryApiController@startOfSet');
    Route::post('bbs','BbsEntryApiController@store');
});

Route::post('login','LoginApiController@login');
//<---->
//<---->
