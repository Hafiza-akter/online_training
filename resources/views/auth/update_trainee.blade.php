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
                <div class=" col-sm-8 mb-4">
<<<<<<< HEAD
                <div class="alert alert-success">
                {{-- thank you for the confirmation --}}
                  <h5 style="text-align:center">ご登録いただき、ありがとうございます。</h5>
                </div> 
=======
              
>>>>>>> master
            </div>
                <div class="col-md-8 col-xl-6">
                    <div class="section_tittle">
                       <h2>ユーザー情報</h2>
                    </div>
                </div>
            </div>
           
        </div>
        <div class="overlay_icon">
            <img src="{{ asset('asset_v2/img/animate_icon/icon_1.png')}}" class="amitated_icon_1" alt="animate_icon">
            <img src="{{ asset('asset_v2/img/animate_icon/icon_2.png')}}" class="amitated_icon_2" alt="animate_icon">
            <img src="{{ asset('asset_v2/img/animate_icon/icon_3.png')}}" class="amitated_icon_3" alt="animate_icon">
            <img src="{{ asset('asset_v2/img/animate_icon/icon_4.png')}}" class="amitated_icon_4" alt="animate_icon">
            <img src="{{ asset('asset_v2/img/animate_icon/icon_5.png')}}" class="amitated_icon_5" alt="animate_icon">
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
            {{-- Add more information --}}
            <h4 class="card-title">情報を登録する</h4>
        </div>

 

    <form action="{{route('traineeSignupUpdate.submit')}}" method="post">
                   
        {{ csrf_field() }}
            <input type="hidden" name="email" class="form-control" value="{{ $user->email}}">
            <input type="hidden" name="user_id" class="form-control" value="{{ $user->id}}">   
            <div class="card-body">
            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label name">お名前</label>
                </div>
                <div class="col-8">
                  <input type="text" name="name" class="form-control" value="{{ old('name')}}">
                </div>
            </div>

            {{-- <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label sex">性別</label>
                </div>
                 <div class="col-8">
                    <select class="form-control" name="sex">
                        <option value=""> 性別をお選びください</option> 
                        <option value="1"> 男性</option> 
                        <option value="0"> 女性</option>


                    </select>
                </div>
            </div> --}}

           {{--  <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label birthday">誕生日</label>
                </div>
                  <div class="col-8">
                  <input type="text" name="birthday" class="form-control datepicker" value="{{ old('birthday')}}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label height">身長</label>
                </div>
                  <div class="col-8">
                  <input type="number" name="height" class="form-control" value="{{ old('height')}}">
                </div>
            </div> --}}


            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label phonetic">ふりがな</label>
                </div>
                <div class="col-8">
                  <input type="text" name="phonetic" class="form-control" value="{{ old('phonetic')}}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label _email_address_">メールアドレス</label>
                </div>
                <div class="col-8">
                    <input type="email" name="email1" class="form-control" disabled="disabled" value="{{ $user->email}}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label">パスワード <span style="color:red">*</span></label>
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

           {{--  <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label _address_">住所</label>
                </div>
                <div class="col-8">
                  <input type="text" name="address" class="form-control" value="{{ old('address')}}">
                </div>
            </div> --}}

            {{-- <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label _phone_number_">電話番号</label>
                </div>
                <div class="col-8">
                  <input type="text" name="phone" class="form-control" value="{{ old('phone')}}">
                </div>
            </div> --}}

           {{--  <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label _current_weight_">現在の体重(kg)</label>
                </div>
                <div class="col-8">
                  <input type="text" name="weight" class="form-control" value="{{ old('weight')}}">
                </div>
            </div> --}}

            {{-- <div class="row mb-3">
                <div class="col-4">
                    <label class="col-form-label _body_fat_percentage_">体脂肪率</label>
                </div>
                <div class="col-8">
                    <input type="text" name="fat" class="form-control" value="{{ old('fat')}}">
                </div>
            </div> --}}

        


            {{-- @if($equipment)
                @foreach($equipment as $key=>$val)
                <div class="row mb-3">
                    <div class="col-4">
                        <input type="hidden" name="equipment[{{$key}}][id]" value="{{$val->id }}">
                        <label class="col-form-label _barbell_">{{$val->name }}</label>
                    </div>
                    <div class="col-8">
                        <select class="form-control" name="equipment[{{$key}}][is_available]">
                            <option value="1"> はい</option>
                            <option value="0"> いいえ</option>


                        </select>
                    </div>
                </div>
                @endforeach
            @endif  --}}

        </div>
        <div class="card-footer">
            <div class="row pt-3 pb-3">
                <button type="submit" class="mx-auto btn btn-secondary text-white btn-lg gradient ">決定</button>
            </div>
        </div>
      
    </form>
  </div>
</div>
</section>




@endsection
@section('footer_css_js')
<script>
    $(document).ready(function() {

        $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
            $(".alert-success").slideUp(500);
        });

        $('.datepicker').datepicker();

    });

</script>
@endsection 