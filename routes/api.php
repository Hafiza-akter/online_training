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

