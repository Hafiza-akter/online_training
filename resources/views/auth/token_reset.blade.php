{{-- @extends('master_page') --}}
@extends('auth.master')
@section('title','token reset')
@section('content')

<div class="row pt-5">
    <h4 class="mx-auto">パスワードのリセット
    </h4>
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
   
      @if(Session::has('message'))
      <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
      @endif
</div>
  

  <div class="offset-sm-2 col-sm-8 mb-4">
    <div class="card card-info">
        <div class="card-header">
            {{-- email registration --}}
            <p class="card-title">パスワードリセットリンクをあなたのメールアドレスに送信します</p>
        </div>

         <form class="form-horizontal" action="{{route('forgetPasswordEmail.submit')}}" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="{{ $type}}">
        <div class="card-body">

            <div class="form-group row required">
            <label for="inputEmail3" class="col-sm-3 col-form-label">電子メールアドレス</label>
            <div class="col-sm-9">
                {{-- Please enter your e-mail address--}}
                <input type="email" required class="form-control"  name="email" placeholder="
メールアドレスを入力してください">
            </div>
            </div>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            {{-- Registration --}}
            <button type="submit" class="btn  btn-block btn-secondary"> 
送信</button>

        </div>
        <!-- /.card-footer -->
        </form>

    </div>
</div>

  </div>
  @endsection