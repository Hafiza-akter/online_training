{{-- @extends('master_page') --}}
@extends('auth.master')
@section('title','trainee login')
@section('content')
    <div class="row pb-5 pt-5">
      <h2 class="mx-auto">オンラー<br>(ニングマ)</h2>
    </div>
    <form action="{{route('traineeLogin.submit')}}" method="post">
    {{ csrf_field() }}
    <div class="offset-sm-3 col-sm-6 mb-4">
      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label">
電子メールアドレス</label>
        </div>
        <div class="col-8">
          <input type="text" class="form-control" name="username">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label">パスワード</label>
        </div>
        <div class="col-8">
          <input type="password" class="form-control" name="password">
        </div>
      </div>
      <div class="row pt-3 pb-3">
      <button type="submit" class="mx-auto btn btn-secondary text-white btn-lg">次へ</button>
      </div>
      <div class="row pt-3 pb-3">
      {{-- <a href="{{route('tokenReset.trainee')}}" class="mx-auto">Reset Password</a> --}}
      </div>
    </div>
    </form>
    <div class="offset-sm-3 col-sm-6 mb-4">
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


    <div class="row"></div>
  </div>
  @endsection