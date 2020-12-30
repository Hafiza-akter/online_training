<!DOCTYPE html>
<html>
<head>
	<title>Online Training Verification</title>
</head>
<body>	

<div style="padding: 30px;background:#cce5ff;border-color: #b8daff">
	@if($type === 'trainer')
		<p>Dear {{$details->first_name }},</p>
	@endif 
	@if($type === 'trainee')
		<p>Dear {{$details->name }},</p>
	@endif 
	<p> Thank you for the registraion. Please click the link for the verification <p>
	<p>{{ route('signup.verification',['token'=>$details->token, 'type'=>$type]) }}</p>
</div>
</body>
</html>