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
		キャンセルのスケジュール
	<br>
	***-----------------キャンセル情報----------------------***<br>


		@if($details['mail_type'] == 'cancel_by_user_to_trainer')

			{{ $details['month'] }} 月 {{ $details['day'] }} 日 {{ $details['time']}}
			時の {{ $details['user_name'] }} 様とのトレーニングがキャンセルされました。
			{{ $details['address'] }}


		@endif

		@if($details['mail_type'] == 'cancel_by_user_to_user')
			{{ $details['month'] }} 月 {{ $details['day'] }} 日 {{ $details['time']}} 
			時の {{ $details['trainer_name'] }} トレーナーとのトレーニングをキャンセルしました。
			スケジュールより別日程の指定をお願いいたします。
			{{ $details['address'] }}

		@endif
		


	***-------------------------------------------------------***<br>
	<br>
	<br>
	
	<br>
</div>
</body>
</html>