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
			{{ $details['month'] }} 月 {{ $details['day'] }} 日 {{ $details['time']}} 時より {{ $details['trainer_name'] }} トレーナーとのトレーニングをキャンセルしました。
トレーニング開始{penalty time}時間前以降のキャンセルのため、今週は別日程を設定できません。



	***-------------------------------------------------------***<br>
	<br>
	<br>
	
	<br>
</div>
</body>
</html>