<!DOCTYPE html>
<html>
<head>
	<title>{{getenv('APP_NAME')}}パスワード再設定のお知らせ</title>
</head>
<body>	
<div>

	***-------------------------------------------------------***<br>
	*<br>
	*    {{getenv('APP_NAME')}}パスワード再設定のお知らせ<br>
	*<br>
	***-------------------------------------------------------***<br>
	<br>
	このたびは、ご利用いただきありがとうございます。
	<br>
	以下のURLをクリックして、必要事項入力ページにお進みください。<br>
	{{ route('passwordVerifyToken',['token'=>$details['token'], 'type'=>$details['type']]) }}
	<br>
	<br>
	※このURLはメール到着から、60分間のみ有効です。<br>
	有効期限が過ぎてしまった場合、<br>
	あらためてパスワード再設定の手続きを行ってください。
	<br>
</div>
</body>
</html>