<!DOCTYPE html>
<html>
<head>
	<title>{{getenv('APP_NAME')}} 仮会員登録受付完了のお知らせ</title>
</head>
<body>	
 
***-------------------------------------------------------***<br>
*<br>
*    {{getenv('APP_NAME')}} 仮会員登録受付完了のお知らせ<br>
*<br>
***-------------------------------------------------------***<br>
<br>
サイトへのアカウント仮登録が完了しました。<br>
<br>
以下のURLをクリックして、本登録を完了させてください。<br>
{{ route('signup.verification',['token'=>$details->token, 'type'=>$type]) }}
<br>
<br>
※このURLは仮登録後、24時間のみ有効です。<br>
24時間経過後に本登録を行われる場合は、再度仮登録をやり直して頂くようお願致します。<br>


</body>
</html>