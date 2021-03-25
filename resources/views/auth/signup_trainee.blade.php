{{-- @extends('master_page') --}}
@extends('../master')
@section('title','trainee signup')
@section('content')


<style>
     .login_button{
        border-radius: 1px !important;
        font-size: 18px;
        /*width:auto;*/
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
                    <h2>ユーザー新規登録</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="">

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

                    <div class="row"></div>

                    <div class="offset-sm-2 col-sm-8 mb-4">
                        <div class="card card-info">
                            <div class="card-header">
                                {{-- email registration --}}
                                <h4 class="card-title">メールアドレスで登録</h4>
                            </div>

                             <form class="form-horizontal" action="{{route('traineeSignup.submit')}}" method="post">
                            {{ csrf_field() }}
                            <div class="card-body">

                                <div class="form-group row required">
                                {{-- <label for="inputEmail3" class="col-sm-3 col-form-label">メールアドレス</label> --}}
                                <div class="col-sm-12">
                                    {{-- Please enter your e-mail address--}}
                                    <input type="email" required class="form-control"  name="email" placeholder="メールアドレスを入力してください" onfocus="this.placeholder = ''" onblur="this.placeholder = 'メールアドレスを入力してください'" >
                                </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                {{-- Registration --}}
                                <div class="col text-center">
                                <button type="submit" class="btn  btn_lg btn-block login_button"><i class="fas fa-user-check"></i>  登録</button>
                                </div>

                            </div>
                            <!-- /.card-footer -->
                            </form>

                        </div>
                    </div>
                    <div class="offset-sm-2 col-sm-8 mb-4">
                        {{-- Verification with google --}}
                        <a href="{{ url('/login/redirect/google') }}" class="btn  btn-block btn-danger"><i class="fab fa-google"></i> Googleで登録 </a>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>

    <div class="overlay_icon">
        <img src="{{asset('asset_v2/img/animate_icon/icon_6.png')}}" class="amitated_icon_6" alt="animate_icon">
    </div>

<div class="overlay_icon">
            <img src="{{asset('asset_v2/img/animate_icon/icon_1.png')}}" class="amitated_icon_1" alt="animate_icon">
            <img src="{{asset('asset_v2/img/animate_icon/icon_2.png')}}" class="amitated_icon_2" alt="animate_icon">
            <img src="{{asset('asset_v2/img/animate_icon/icon_4.png')}}" class="amitated_icon_4" alt="animate_icon">
            <img src="{{asset('asset_v2/img/animate_icon/icon_5.png')}}" class="amitated_icon_5" alt="animate_icon">
        </div>
</section>


@endsection
@section('footer_css_js')

@endsection
