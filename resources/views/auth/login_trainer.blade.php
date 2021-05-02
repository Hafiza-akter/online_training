{{-- @extends('master_page') --}}
@extends('../master')
@section('title','trainee login')
@section('content')
<style>
 
</style>

{{-- <section class="breadcrumb breadcrumb_bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb_iner text-center">
                    <div class="breadcrumb_iner_item">
                        <!-- <p></p> -->
                        <h2>Trainer Login</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}
{{-- <div class="row pt-5"> --}}
    {{-- Trainee login --}}
 {{--    <h4 class="mx-auto">トレーナーログイン
    </h4>
</div> --}}
    
<section class="about_us section_padding pt-10">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-xl-6">
                    <div class="section_tittle">
                       <h2>トレーナーログイン</h2>
                    </div>
                </div>


            </div>

            <div class="row">
            <div class="col-lg-12">
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
                    <div class="card-header gradient">
                        {{-- email registration --}}
                        <h4 class="card-title text-center" style="color: #fff;">ログイン</h4>
                    </div>

                     <form class="form-horizontal" action="{{route('trainerLogin.submit')}}" method="post">
                    {{ csrf_field() }}
                    <div class="card-body">

                        <div class="form-group row required">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">メールアドレス</label>
                        <div class="col-sm-9">
                            {{-- Please enter your e-mail address--}}
                            <input type="email" required class="form-control"  name="username" placeholder="メールアドレスを入力してください">
                        </div>
                        </div>

                        <div class="form-group row required">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">
            パスワード</label>
                        <div class="col-sm-9">
                            {{-- Please enter your e-mail address--}}
                            <input type="password" required class="form-control"  name="password" placeholder="パスワードを入力してください">
                        </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                     <div class="card-footer">
                        <div class="col text-center">
                            <button type="submit" class="btn btn-lg login_button btn-block"> 次へ</button>
                            <a  class="btn btn-lg login_button " href="{{route('trainerSignup')}}" style="border:none !important;font-size:13px;"> アカウントの作成はこちら</a>
                         </div>
                    </div>
                    <!-- /.card-footer -->
                    </form>

                </div>
            </div>

        </div>
    </div>
           
        </div>
        <div class="overlay_icon">
            <img src="{{asset('asset_v2/img/animate_icon/icon_1.png')}}" class="amitated_icon_1" alt="animate_icon">
            <img src="{{asset('asset_v2/img/animate_icon/icon_2.png')}}" class="amitated_icon_2" alt="animate_icon">
            <img src="{{asset('asset_v2/img/animate_icon/icon_4.png')}}" class="amitated_icon_4" alt="animate_icon">
            <img src="{{asset('asset_v2/img/animate_icon/icon_5.png')}}" class="amitated_icon_5" alt="animate_icon">
        </div>

     

    
    <div class="offset-sm-2 col-sm-8 mb-4 row">

        <a class="mx-auto" href="{{ route('forgetPassword','trainer')}}" style="font-size: 14px;color: #007bff;"> パスワードを忘れた方はこちら
        </a>
    </div>

    </section>





  @endsection