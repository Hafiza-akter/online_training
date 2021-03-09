<!DOCTYPE html>
<html>
<head>
	<title>{{getenv('APP_NAME')}}予約のスケジュール</title>
</head>
<body>	
<div>

	***-------------------------------------------------------***<br>
	*<br>
	*    {{getenv('APP_NAME')}}予約のスケジュール<br>
	*<br>
	***-------------------------------------------------------***<br>
	<br>
		スケジュールが予約されました
	<br>
	***-----------------スケジュール情報----------------------***<br>
		User Name : {{ $details['user_name']}}; <br>
		User Email : {{ $details['user_email']}}; <br>
        Booking Date: {{ $details['date'] }}<br>
        Booking Time: {{ $details['time'] }}<br>
        Trainer Name: {{ $details['trainer_name'] }}<br>
        Trainer Email: {{ $details['trainer_email'] }} <br>
	***-------------------------------------------------------***<br>
	<br>
	<br>
	
	<br>
</div>
</body>
</html>