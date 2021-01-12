{{-- @extends('master_page') --}}
@extends('../master')
@section('title','trainee login')
@section('content')
<style>
     .login_button{
        border-radius: 1px !important;
        font-size: 18px;
        width:400px;
        color: #a506a4;
        border: 2px solid #bb07bb;
        }
.gradient{
    background-image:linear-gradient(to left, purple 0%, #c300c3 50%, #7e007e 100%);color: #fff !important;
}
</style>

<section class="about_us section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-xl-6">
                    <div class="section_tittle">
                       <h2>研修生ログイン</h2>
                    </div>
                </div>
            </div>
           
        </div>
        <div class="overlay_icon">
            <img src="{{asset('asset_v2/img/animate_icon/icon_1.png')}}" class="amitated_icon_1" alt="animate_icon">
            <img src="{{asset('asset_v2/img/animate_icon/icon_2.png')}}" class="amitated_icon_2" alt="animate_icon">
            <img src="{{asset('asset_v2/img/animate_icon/icon_3.png')}}" class="amitated_icon_3" alt="animate_icon">
            <img src="{{asset('asset_v2/img/animate_icon/icon_4.png')}}" class="amitated_icon_4" alt="animate_icon">
            <img src="{{asset('asset_v2/img/animate_icon/icon_5.png')}}" class="amitated_icon_5" alt="animate_icon">
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
        <div class="card-header  gradient">
            {{-- login in  --}}
            <h4 class="card-title text-center " style="color:#fff" >ログインする</h4>
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
                <div class="col text-center">
                    <button type="submit" class="btn btn-lg login_button"> 次へ</button>
                </div>
            </div>
            <!-- /.card-footer -->
        </form>

    </div>
</div>

<div class="offset-sm-2 col-sm-8 mb-4 row">

    <a class="mx-auto" href="{{ route('forgetPassword','trainee')}}" style="font-size: 14px;color: #007bff;"> パスワードを忘れた場合は、ここをクリックしてください
    </a>
</div>
    </section>





@endsection