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
		@if($details['type'] == 'trainee')
			{{ $details['month'] }} 月 {{ $details['day'] }} 日 {{ $details['time']}} 時より {{ $details['trainer_name'] }} トレーナーとのトレーニングの予約をお取りしました。
			当日のお時間になりましたらスケジュールページ下のトレーニング開始ボタンよりご参加ください。
			{{ $details['address'] }}
		@endif
		@if($details['type'] == 'trainer')
			{{ $details['month'] }} 月 {{ $details['day'] }} 日 {{ $details['time']}} 時より {{ $details['user_name'] }} トレーナーとのトレーニングの予約をお取りしました。
			当日のお時間になりましたらスケジュールページ下のトレーニング開始ボタンよりご参加ください。
			{{ $details['address'] }}
		@endif
	***-------------------------------------------------------***<br>
	<br>
	<br>
	
	<br>
</div>
</body>
</html>