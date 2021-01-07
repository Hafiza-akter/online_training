<!DOCTYPE html>
<html>
<head>
	<title>Online Training Verification</title>
</head>
<body>	

<div style="padding: 30px;background:#cce5ff;border-color: #b8daff">
	@if($details['type'] === 'trainer')
		<p>Dear  {{$details['name'] }},</p>
	@endif 
	@if($details['type'] === 'trainee')
		<p>Dear {{$details['name'] }},</p>
	@endif 
	<p> Please click the password reset link for update your password. <p>
	<p>{{ route('passwordVerifyToken',['token'=>$details['token'], 'type'=>$details['type']]) }}</p>
</div>
</body>
</html>