{{-- @extends('master_page') --}}
@extends('auth.master')

@section('title','trainer signup')
@section('content')
<div class="row pb-5">
  
</div>
    
<div class="offset-sm-2 col-sm-8 mb-4">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{route('traineeSignup.submit')}}" method="post">
        {{ csrf_field() }}
      
    </form>

</div>
    @if($token == '')
    <div class="alert alert-primary">

    {{-- thank you for the registraion. --}}
        <h4>登録ありがとうございます。</h4>
        {{--   <p>A verification link has been sent to your email address, please confirm the verification.</p>   --}}
         <p>確認リンクをメールアドレスに送信されました。</p>
    </div>     
    @else 
    <div class="alert alert-success">
        {{-- thank you for the confirmation --}}
        <h4 style="text-align:center">ご登録いただき、ありがとうございます。</h4>
     

        @if($type === 'trainer')
        <p style="text-align:center;color:green"> <a href="{{ route('trainerLogin') }}">ログイン</a> </p>
        @endif
        @if($type === 'trainee')
        <p style="text-align:center;color:green"> <a href="{{ route('traineeLogin') }}">ログイン</a> </p>
        @endif
     </div>   
    @endif

  <div class="row"></div>
  </div>

@endsection