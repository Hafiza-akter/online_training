{{-- @extends('master_page') --}}
@extends('../master')
@section('title','trainee login')
@section('content')

<section class="breadcrumb breadcrumb_bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner text-center">
                    <div class="breadcrumb_iner_item">
                        <!-- <p></p> -->
                        <h2>Trainee Login</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="row pt-5">
    {{-- Trainee login --}}
    <h4 class="mx-auto">研修生ログイン
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


    <!-- /.card-header -->
    <!-- form start -->
    @if(Session::has('message'))
    <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
    @endif



</div>


<div class="offset-sm-2 col-sm-8 mb-4">
    <div class="card card-info">
        <div class="card-header purple-back">
            {{-- email registration --}}
            <h4 class="card-title text-center">ログインする</h4>
        </div>

        <form class="form-contact contact_form" action="{{route('traineeLogin.submit')}}" method="post">
            {{ csrf_field() }}
            <div class="card-body">

                <div class="form-group row required">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">電子メールアドレス</label>
                    <div class="col-sm-9">
                        {{-- Please enter your e-mail address--}}
                        <input type="email" required class="form-control" name="username" placeholder="
メールアドレスを入力してください">
                    </div>
                </div>

                <div class="form-group row required">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">
                        パスワード</label>
                    <div class="col-sm-9">
                        {{-- Please enter your e-mail address--}}
                        <input type="password" required class="form-control" name="password" placeholder="パスワードを入力してください">
                    </div>
                </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                {{-- Registration --}}
                <button type="submit" class="btn  btn-block btn-secondary btn_2 d-none d-sm-block"> 次へ</button>

            </div>
            <!-- /.card-footer -->
        </form>

    </div>
</div>

<div class="offset-sm-2 col-sm-8 mb-4 row">

    <a class="mx-auto" href="{{ route('forgetPassword','trainee')}}" style="font-size: 14px;color: #007bff;"> パスワードを忘れた場合は、ここをクリックしてください
    </a>
</div>
@endsection