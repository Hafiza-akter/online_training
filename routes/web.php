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

Route::get('/mailtest', function () {
	$details = [
		'title' => 'Mail from online training',
		'body' => 'please verify your signup'
	];
	\Mail::to('arnobsec21@gmail.com')->send(new \App\Mail\EmailController($details));
	echo "message sent !";
});

Route::group(['middleware' => 'checkLogout'], function () {
	// Route::get('/','TopPageController@index')->name('toppage'); 
});



Route::get('/', 'TopPageController@index')->name('toppage');
Route::get('/test/dashboard', 'LoginController@dashboard')->name('dashboard');
Route::get('/trainer/list', 'TopPageController@trainerList')->name('trainersList');
Route::get('/trainer/details', 'TopPageController@details')->name('trainerdetails');
Route::get('/customer/reivews', 'TopPageController@review')->name('review');
Route::get('/inquiry', 'InquiryController@inquiry')->name('inquiry');
Route::post('/inquiry/submit', 'InquiryController@inquirysubmit')->name('inquiry.submit');
Route::post('/inquery/submit', 'InquiryController@inquirysubmittoppage')->name('inquery.submit');

/*
|--------------------------------------------------------------------------
| Login Controller
|--------------------------------------------------------------------------
|
| For trainer and trainee
|
*/
Route::group(['middleware' => 'basicAuth','checkLogout'], function () {
	Route::get('/login/trainee', 'LoginController@loginTrainee')->name('traineeLogin');
	Route::post('/login/trainee', 'LoginController@loginTraineeSubmit')->name('traineeLogin.submit');
	Route::get('/login/trainer', 'LoginController@loginTrainer')->name('trainerLogin');
	Route::post('/login/trainer', 'LoginController@loginTrainerSubmit')->name('trainerLogin.submit');

	Route::get('/login/redirect/{provider}', 'LoginController@googleRedirect');
	Route::get('/login/callback/{provider}', 'LoginController@googleCallback');
});


/*
|--------------------------------------------------------------------------
| Sign up Controller { signup,verification}
|--------------------------------------------------------------------------
|
| For trainer and trainee
|
*/
Route::group(['middleware' =>   'basicAuth','checkLogout'], function () {

	Route::get('/signup/trainee', 'SignupController@signupTrainee')->name('traineeSignup');
	Route::post('/signup/trainee', 'SignupController@signupTraineeSubmit')->name('traineeSignup.submit');
	Route::post('/trainee/info', 'SignupController@signupTraineeUpdate')->name('traineeSignupUpdate.submit');
	Route::get('user/{param}', 'SignupController@googleuser')->name('googleuser');

	Route::get('/signup/trainer', 'SignupController@signupTrainer')->name('trainerSignup');
	Route::post('/signup/trainer', 'SignupController@signupTrainerSubmit')->name('trainerSignup.submit');
	Route::post('/trainer/info', 'SignupController@signupTrainerUpdate')->name('trainerSignupUpdate.submit');

	Route::get('/verification/{token}/{type}', 'SignupController@verification')->name('signup.verification');
	Route::get('/verification', 'SignupController@verificationview')->name('signup.verificationview');



	Route::get("/reset/token/trainee", "SignupController@tokenResetTrainee")->name(('tokenReset.trainee'));
	Route::post("/reset/token/trainee", "SignupController@tokenResetSubmitTrainee")->name(('token.reset.submit.trainee'));


	Route::get("token-verify/{token}/{type}", "SignupController@tokenVerify")->name('passwordVerifyToken');
	Route::post("token-verify", "SignupController@tokenVerifySubmit")->name('passwordVerifyTokenSubmit');

	Route::get("/forgetpassword/{type}", "SignupController@tokenReset")->name('forgetPassword');
	Route::post("/forgetpassword/submit", "SignupController@tokenResetSubmit")->name(('forgetPasswordEmail.submit'));

	Route::get("/user/inquery", "SignupController@inquery")->name(('userInquery'));
});

Route::group(['middleware' => 'checkLogin'], function () {
	
	// when join user to training / jitsi entrance link
	Route::post("/trainer/trainingdetails/{id}", "TrainingController@trainingDetails")->name(('training'));
	Route::post("/trainee/trainingdetails/{id}", "TrainingController@trainingDetails")->name(('trainingtrainee'));
	
	Route::post("/trainer/training_performance", "TrainingController@training_performance")->name(('training_performance'));
	Route::post("/trainer/training_feedback", "TrainingController@training_feedback")->name(('training_feedback'));
	Route::post("/trainee/feedback", "TrainingController@training_feedback")->name(('trainee_training_feedback'));
	
	Route::get("/trainer/trainingfinished/{id}", "TrainingController@trainingfinished")->name(('trainingfinished'));
	Route::get("/trainee/traineefinished/{id}", "TrainingController@traineefinished")->name(('traineefinished'));
	Route::post("/trainer/success", "TrainingController@success")->name(('success'));
	Route::match(['GET', 'POST'],"/trainer/training/list", "TrainingController@list")->name(('traininglist'));
	Route::get("/trainee/training/list", "TrainingController@traineelist")->name(('traineelist'));
	Route::post("/trainee/training/ajax_training_performance/{id}", "TrainingController@ajax_training_performance")->name(('ajax_training_performance'));
	Route::post("/trainee/training/ajax_training_get_comment/{id}", "TrainingController@ajax_training_get_comment")->name(('ajax_training_get_comment'));
	Route::match(['GET'],"/trainer/userhistory/{id}", "TrainingController@userhistory")->name(('userhistory'));
	Route::match(['GET'],"/trainee/trainerhistory/{id}", "TrainingController@trainerhistory")->name(('trainerhistory'));
	Route::get("/trainer/schedule", "ScheduleController@scheduleView")->name(('trainerSchedule'));
	Route::get("/user/trainer/view", "TrainerController@trainerView")->name(('trainerView'));

	// trainer 
	Route::get("/trainer/calendar/{type}", "ScheduleController@calendar")->name(('calendar.view'));
	Route::post("/trainer/schedule/", "ScheduleController@schedule")->name(('schedule'));
	Route::post("/trainer/scheduleDelete/", "ScheduleController@scheduleDelete")->name(('scheduleDelete'));


	Route::post("/trainer/scheduled/calendar", "TrainerController@scheduleCalendarSubmit")->name(('trainerCalendar.submit'));

	Route::get("/trainer/scheduled/{selected_date}/time", "TrainerController@scheduleTime")->name(('trainerTime.view'));
	Route::post("/trainer/calendar/submit", "TrainerController@scheduleSubmit")->name(('scheduleSubmit.submit'));
	Route::get("/trainer/logout", "TrainerController@logout")->name(('trainerLogout'));
	Route::get("/trainer/scheduled/{id}", "TrainerController@trainerScheduleDelete")->name(('trainerScheduleDelete'));
	
	// trainer schedule new update

	// trainee personal settings
	Route::get('/trainer/p-settings', 'TrainerController@psettings')->name('trainer.p-settings');
	Route::post('/trainer/p-settings', 'TrainerController@psettingsSubmit')->name('trainer.p-settings.submit');
	// trainee

	Route::get("/trainee/physicaldata", "TraineeController@physicaldata")->name(('physicaldata'));
	Route::post("/trainee/physicaldata/submit", "TraineeController@physicaldatasubmit")->name(('physicaldata.submit'));

	Route::get("/trainee/traininginfo", "TraineeController@traininginfo")->name(('traininginfo'));
	Route::post("/trainee/traininginfo/submit", "TraineeController@traininginfosubmit")->name(('traininginfo.submit'));

	Route::match(['GET','POST'],"/trainee/scheduled/month", "TraineeController@scheduleCalendar")->name(('traineeCalendar.view'));
	Route::match(['GET','POST'],"/trainee/trainerSubmitBytime", "TraineeController@trainerSubmitBytime")->name(('trainerSubmitBytime'));
	Route::match(['GET','POST'],"/trainee/scheduled/calendar", "TraineeController@scheduleCalendarSubmit")->name(('traineeCalendar.submit'));


	Route::get("/trainee/scheduled/{selected_date}/time", "TraineeController@scheduleTime")->name(('traineeTime.view'));
	Route::post("/trainee/scheduled/submit", "TraineeController@scheduleSubmit")->name(('tscheduleSubmit.submit'));
	Route::get("/trainee/logout", "TraineeController@logout")->name(('traineeLogout'));
	Route::get("/trainee/purchaseplan", "TraineeController@purchaseplan")->name(('purchaseplan'));
	Route::get("/trainee/purchaseplan/{id}", "TraineeController@purchasedetails")->name(('purchasedetails'));
	Route::post("/trainee/purchaseplan/purchaseajaxcall", "TraineeController@purchaseajaxcall")->name(('purchaseajaxcall'));
	Route::get("/trainee/quickview", "TraineeController@quickview")->name('quickview');

	Route::get("/trainee/progress", "UserAchievement@progress")->name(('progress'));
	Route::get("/trainee/progress/dailydata/{date}", "UserAchievement@dailydata")->name(('dailydata'));
	Route::post("/trainee/progress/dailydata/submit", "UserAchievement@dailydataSubmit")->name(('dailydata.submit'));
	Route::get("/trainee/progress/dailydata/edit/{id}", "UserAchievement@dailydataEdit")->name(('dailydata.edit'));

	Route::post("/trainee/purchaseplan/purchaseajaxcall", "TraineeController@purchaseajaxcall")->name(('purchaseajaxcall'));

	// trainee personal settings
	Route::get('/trainee/p-settings', 'TraineeController@psettings')->name('trainee.p-settings');
	Route::post('/trainee/p-settings', 'TraineeController@psettingsSubmit')->name('trainee.p-settings.submit');
	
	// select trainer 
	Route::match(['GET','POST'],"/trainee/trainerlist", "TraineeController@trainerlist")->name(('trainerlist'));
	Route::match(['GET','POST'],"/trainee/trainerlistviatime", "TraineeController@trainerlistviatime")->name(('trainerlistviatime'));
	// trainer details
	Route::get("/trainerDetails/{id}", "TrainerController@trainerDetails")->name(('trainerDetails'));
	Route::get("/trainerselect/{id}/{date}/{time}", "TrainerController@trainerselect")->name(('trainerselect'));
	// user given ratings to trainer
	Route::get("/trainee/ratings/{schedule_id}", "TrainingController@ratings")->name(('userRatings'));
	Route::post("/trainee/ratings/submit", "TrainingController@ratingsSubmit")->name(('userRatingsSubmit'));

	Route::get("/trainee/reservation", "ReservationController@index")->name(('reservation'));
	Route::match(['GET','POST'],"/trainee/reservation/sorting", "ReservationController@sorting")->name(('sorting'));
	Route::get("/trainee/datereservation/{date?}", "ReservationController@reservationBydate")->name('datereservation');


});


Route::prefix('admin')->group(function () {
	Route::group(['middleware' => 'checkAdmin'], function () {
		Route::get('/logout', 'Admin\LoginController@logout')->name('admin.logout');

		Route::get('/dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');

		Route::get('/setting', 'Admin\DashboardController@setting')->name('admin.setting');
		Route::get('/setting/edit', 'Admin\DashboardController@settingForm')->name('admin.setting.edit');
		Route::post('/setting/edit/submit', 'Admin\DashboardController@settingSubmit')->name('admin.setting.submit');

		Route::get('/equipment', 'Admin\DashboardController@equipmentList')->name('admin.equipment.list');
		Route::get('/equipment/add', 'Admin\DashboardController@equipAdd')->name('admin.equipment.add');
		Route::post('/equipment/add', 'Admin\DashboardController@equipAddSubmit')->name('admin.equipment.submit');
		Route::get('/equipment/edit/{id}', 'Admin\DashboardController@eqiptEdit')->name('admin.equipment.edit');
		Route::post('/equipment/edit', 'Admin\DashboardController@equipEditSubmit')->name('admin.equipment.edit.submit');
		// Route::get('/equipment/delete/{id}', 'Admin\DashboardController@equipmentDelete')->name('admin.equipment.delete');

		Route::get('/admin/list', 'Admin\UserController@adminList')->name('admin.list');
		Route::get('/admin/add', 'Admin\UserController@adminAdd')->name('admin.add');
		Route::post('/admin/add', 'Admin\UserController@adminAddSubmit')->name('admin.add.submit');
		Route::get('/admin/edit/{id}', 'Admin\UserController@adminEdit')->name('admin.edit');
		Route::post('/admin/edit', 'Admin\UserController@adminEditSubmit')->name('admin.edit.submit');
		// Route::get('/equipment/delete/{id}', 'Admin\DashboardController@equipmentDelete')->name('admin.equipment.delete');


		//couses route

		Route::get('/admin/course/list', 'Admin\CourseController@courseList')->name('course.list');
		Route::get('/admin/course/view/{id}', 'Admin\CourseController@courseView')->name('course.view');
		Route::get('/admin/course/add', 'Admin\CourseController@courseAdd')->name('course.add');
		Route::post('/admin/course/add', 'Admin\CourseController@courseAddSubmit')->name('course.add.submit');
		Route::get('/admin/course/edit/{id}', 'Admin\CourseController@courseEdit')->name('course.edit');
		Route::post('/admin/course/edit', 'Admin\CourseController@courseEditSubmit')->name('course.edit.submit');
		


		// Admin trainer manage
		Route::get('/trainer/list', 'Admin\TrainerController@trainerList')->name('trainer.list');
		Route::get('/trainer/edit/{id}', 'Admin\TrainerController@trainerEdit')->name('admin.trainer.edit');
		Route::get('/trainer/view/{id}', 'Admin\TrainerController@trainerView')->name('admin.trainer.view');
		Route::post('/trainer/edit', 'Admin\TrainerController@trainerEditSubmit')->name('trainer.edit.submit');

		// Admin user manage
		Route::get('/user/list', 'Admin\UserController@userList')->name('user.list');
		Route::get('/user/edit/{id}', 'Admin\UserController@userEdit')->name('user.edit');
		Route::post('/user/edit', 'Admin\UserController@userEditSubmit')->name('user.edit.submit');
		Route::get('/user/training/history/{id}', 'Admin\UserController@trainingHistory')->name('user.training.history');
		Route::get('/user/training/history/{id}/download', 'Admin\UserController@csvDownload')->name('user.training.history.download');

		// User plan purchase
		Route::get('/user/purchase/plan/list', 'Admin\PurchasePlanController@planList')->name('purchase.plan.list');
		Route::get('/user/purchase/plan/edit/{id}', 'Admin\PurchasePlanController@planEdit')->name('purchase.plan.edit');
		Route::post('/user/purchase/plan/edit', 'Admin\PurchasePlanController@planEditSubmit')->name('purchase.plan.edit.submit');


		Route::get('/user/management/view', 'Admin\UserController@userManagement')->name('admin.user.management.view');
		Route::get('/user/management/details', 'Admin\UserController@userManagementDeatil')->name('admin.user.management.detail');



		//Admin Schedule Management
		Route::get('/schedule/management/view', 'Admin\ScheduleController@index')->name('admin.schedule.management.view');
		Route::get('/schedule/management/edit/{id}', 'Admin\ScheduleController@edit')->name('admin.schedule.management.edit');
		Route::post('/schedule/management/edit/submit', 'Admin\ScheduleController@editSubmit')->name('admin.schedule.management.edit.submit');
		Route::post('/schedule/management/search', 'Admin\ScheduleController@searchSubmit')->name('admin.schedule.management.search.submit');

		// user inquery 
		Route::get('/user/inquery/list', 'Admin\InquiryController@list')->name('inquery.list');
		Route::get('/user/inquery/view/{id}', 'Admin\InquiryController@view')->name('inquery.view');


		Route::get('/ratings', 'Admin\RatingsController@index')->name('admin.ratings');
		Route::get('/ratings/add', 'Admin\RatingsController@ratingsAdd')->name('admin.ratings.add');
		Route::post('/ratings/add', 'Admin\RatingsController@ratingsAddSubmit')->name('admin.ratings.submit');
		Route::get('/ratings/edit/{id}', 'Admin\RatingsController@ratingsEdit')->name('admin.ratings.edit');
		Route::post('/ratings/edit', 'Admin\RatingsController@ratingsEditSubmit')->name('admin.ratings.edit.submit');

		Route::get('/trainersetupdata', 'Admin\TrainerSetupDataController@index')->name('admin.trainersetupdata');
		Route::get('/trainersetupdata/add', 'Admin\TrainerSetupDataController@trainersetupdataAdd')->name('admin.trainersetupdata.add');
		Route::post('/trainersetupdata/add', 'Admin\TrainerSetupDataController@trainersetupdataAddSubmit')->name('admin.trainersetupdata.submit');
		Route::get('/trainersetupdata/edit/{id}', 'Admin\TrainerSetupDataController@trainersetupdataEdit')->name('admin.trainersetupdata.edit');
		Route::post('/trainersetupdata/edit', 'Admin\TrainerSetupDataController@trainersetupdataEditSubmit')->name('admin.trainersetupdata.edit.submit');




	});

Route::group(['middleware' => 'checkLogout'], function () {
		Route::get('/login', 'Admin\LoginController@index')->name('admin.login');
		Route::post('/login', 'Admin\LoginController@adminLoginSubmit')->name('admin.Login.submit');
});


	});
