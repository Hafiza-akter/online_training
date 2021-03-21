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

様 {{ $details['user_name']}}<br>

 {{getenv('APP_NAME')}}をご利用いただきありがとうございます。<br>

下記の代金のお支払いを確認いたしました。<br>
<br>
■ 商品情報
オーダーID : {{ $details['transaction_id'] }}<br>
コース名     : {{ $details['plan'] }}<br>
支払金額   : {{ $details['price'] }}円<br>
レッスン受講可能期間 : {{ $details['period_month'] }} 月<br>

■レッスンスケジュールの予約について
レッスンのスケジュール予約については、以下をご確認ください。

<br>
<br>

	<br>
</div>
</body>
</html>