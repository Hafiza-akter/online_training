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
Route::get('/mailtest', function(){
	$details=[
		'title' => 'Mail from online training',
		'body'=> 'please verify your signup'
		];
	\Mail::to('arnobsec21@gmail.com')->send(new \App\Mail\EmailController($details));
	echo "message sent !";
});

Route::group(['middleware'=>'checkLogout'],function(){
    // Route::get('/','TopPageController@index')->name('toppage'); 
});



Route::get('/', 'TopPageController@index')->name('toppage');

/*
|--------------------------------------------------------------------------
| Login Controller
|--------------------------------------------------------------------------
|
| For trainer and trainee
|
*/
Route::group(['middleware'=>'checkLogout'],function(){
		Route::get('/login/trainee', 'LoginController@loginTrainee')->name('traineeLogin');
		Route::post('/login/trainee', 'LoginController@loginTraineeSubmit')->name('traineeLogin.submit');
		Route::get('/login/trainer', 'LoginController@loginTrainer')->name('trainerLogin');
		Route::post('/login/trainer', 'LoginController@loginTrainerSubmit')->name('trainerLogin.submit');
});


/*
|--------------------------------------------------------------------------
| Sign up Controller { signup,verification}
|--------------------------------------------------------------------------
|
| For trainer and trainee
|
*/

Route::get('/signup/trainee', 'SignupController@signupTrainee')->name('traineeSignup');
Route::post('/signup/trainee', 'SignupController@signupTraineeSubmit')->name('traineeSignup.submit');

Route::get('/signup/trainer', 'SignupController@signupTrainer')->name('trainerSignup');
Route::post('/signup/trainer', 'SignupController@signupTrainerSubmit')->name('trainerSignup.submit');

Route::get('/verification/{token}/{type}', 'SignupController@verification')->name('signup.verification');
Route::get('/verification', 'SignupController@verificationview')->name('signup.verificationview');



Route::get("/reset/token/trainee", "SignupController@tokenResetTrainee")->name(('tokenReset.trainee'));
Route::post("/reset/token/trainee", "SignupController@tokenResetSubmitTrainee")->name(('token.reset.submit.trainee'));


Route::get("token-verify/{id}", "SignupController@tokenVerify");
Route::get("/reset/token/trainer", "SignupController@tokenReset")->name(('tokenReset'));
Route::post("/reset/token/trainer", "SignupController@tokenResetSubmit")->name(('token.reset.submit'));
Route::get("/user/inquery", "SignupController@inquery")->name(('userInquery'));

Route::group(['middleware'=>'checkLogin'],function(){

	Route::get("/trainer/schedule", "ScheduleController@scheduleView")->name(('trainerSchedule'));
	Route::get("/user/trainer/view", "TrainerController@trainerView")->name(('trainerView'));
		
	// trainer 
	Route::get("/trainer/scheduled/calendar", "TrainerController@scheduleCalendar")->name(('trainerCalendar.view'));
	Route::post("/trainer/scheduled/calendar", "TrainerController@scheduleCalendarSubmit")->name(('trainerCalendar.submit'));

	Route::get("/trainer/scheduled/{selected_date}/time", "TrainerController@scheduleTime")->name(('trainerTime.view'));
	Route::post("/trainer/scheduled/submit", "TrainerController@scheduleSubmit")->name(('scheduleSubmit.submit'));
	Route::get("/trainer/logout", "TrainerController@logout")->name(('trainerLogout'));

	
	// trainee
	Route::get("/trainee/scheduled/calendar", "TraineeController@scheduleCalendar")->name(('traineeCalendar.view'));
	Route::post("/trainee/scheduled/calendar", "TraineeController@scheduleCalendarSubmit")->name(('traineeCalendar.submit'));

	Route::get("/trainee/scheduled/{selected_date}/time", "TraineeController@scheduleTime")->name(('traineeTime.view'));
	Route::post("/trainee/scheduled/submit", "TraineeController@scheduleSubmit")->name(('tscheduleSubmit.submit'));
	Route::get("/trainee/logout", "TraineeController@logout")->name(('traineeLogout'));

	// select trainer 
	Route::get("/trainee/trainerlist", "TraineeController@trainerlist")->name(('trainerlist'));
	// trainer details
	Route::get("/trainerDetails/{id}", "TrainerController@trainerDetails")->name(('trainerDetails'));


});



