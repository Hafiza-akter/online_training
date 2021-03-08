{{-- @extends('master_page') --}}
@extends('master')
@section('title','trainee login')
@section('content')


<section class="about_us section_padding">

    <div class="container">



        <div class="row justify-content-center">
            <div class="col-md-8 col-xl-6">
                <div class="section_tittle">
                    <h3>パスワードの更新</h3>
                </div>
            </div>
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
                <div class="card-header">
                    <h4 class="card-title">パスワードリセット</h4>
                </div>

                 <form class="form-horizontal" action="{{route('passwordVerifyTokenSubmit')}}" method="post">
                {{ csrf_field() }}
                <div class="card-body">
                    <input type="hidden" name="token" value="{{ $token}}">
                    <input type="hidden" name="type" value="{{ $type}}">
                    <div class="row mb-3">
                        <div class="col-4">
                          <label class="col-form-label">新しいパスワード <span style="color:red">*</span></label>
                        </div>
                        <div class="col-8">
                          <input type="password" name="password" class="form-control" value="{{ old('password')}}" required="required">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                          <label class="col-form-label _confirm_password_">パスワード(確認) <span style="color:red">*</span></label>
                        </div>
                        <div class="col-8">
                          <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation')}}" required="required">
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    {{-- Registration --}}
                    <button type="submit" class="btn  btn-block btn-secondary"> 送信する</button>

                </div>
                <!-- /.card-footer -->
                </form>

            </div>
        </div>
        </div>
</section>
  @endsection