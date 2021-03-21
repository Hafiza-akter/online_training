<!DOCTYPE html>
<html>
<head>
	<title> {{getenv('APP_NAME')}}決済完了のお知らせ</title>
</head>
<body>	
<div>

***-------------------------------------------------------***<br>
*<br>
*    {{getenv('APP_NAME')}}決済完了のお知らせ<br>
*<br>
***-------------------------------------------------------***<br>

{{ $details['user_name']}}様 <br>

 {{getenv('APP_NAME')}}をご利用いただきありがとうございます。<br>

下記の代金のお支払いを確認いたしました。<br>
<br>
■ 商品情報
オーダーID : {{ $details['transaction_id'] }}<br>
<!--コース名     : yyyyy<br>
支払金額   : zzzzz円<br>
レッスン受講可能期間 : xyz~zyx<br>-->

■レッスンスケジュールの予約について
レッスンのスケジュール予約については、以下をご確認ください。

<br>
<br>

	<br>
</div>
</body>
</html>