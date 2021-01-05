{{-- @extends('master_page') --}}
@extends('auth.master')
@section('title','trainer signup')
@section('content')
<div class="row pt-5">
    {{-- Trainee information --}}
    <h4 class="mx-auto">研修生情報
    </h4>
</div>
<div class="offset-sm-2 col-sm-8 mb-4">
    <div class="alert alert-success">
    {{-- thank you for the confirmation --}}
      <h5 style="text-align:center">確認ありがとう</h5>
    </div> 
</div>
<div class="offset-sm-2 col-sm-8 mb-4">
    <div class="card card-info">
       <div class="card-header">
            {{-- Add more information --}}
            <h4 class="card-title">さらに情報を追加する</h4>
        </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{route('traineeSignupUpdate.submit')}}" method="post">
                   
        {{ csrf_field() }}
            <input type="hidden" name="email" class="form-control" value="{{ $user->email}}">
            <input type="hidden" name="user_id" class="form-control" value="{{ $user->id}}">   
            <div class="card-body">
            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label name">名前</label>
                </div>
                <div class="col-8">
                  <input type="text" name="name" class="form-control" value="{{ old('name')}}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label sex">セックス</label>
                </div>
                 <div class="col-8">
                    <select class="form-control" name="sex">
                        {{-- 1 male, 0 女性  --}}
                        <option value=""> 性別をお選びください</option> 
                        <option value="1"> 男性</option> 
                        <option value="0"> 女性</option>


                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label birthday">お誕生日</label>
                </div>
                  <div class="col-8">
                  <input type="text" name="birthday" class="form-control datepicker" value="{{ old('birthday')}}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label height">高さ</label>
                </div>
                  <div class="col-8">
                  <input type="number" name="height" class="form-control" value="{{ old('height')}}">
                </div>
            </div>


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
                  <label class="col-form-label _email_address_">電子メールアドレス</label>
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
                  <label class="col-form-label _confirm_password_">パスワードを認証する <span style="color:red">*</span></label>
                </div>
                <div class="col-8">
                  <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation')}}" required="required">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label _address_">住所</label>
                </div>
                <div class="col-8">
                  <input type="text" name="address" class="form-control" value="{{ old('address')}}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label _phone_number_">電話番号</label>
                </div>
                <div class="col-8">
                  <input type="text" name="phone" class="form-control" value="{{ old('phone')}}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label _current_weight_">現在の体重</label>
                </div>
                <div class="col-8">
                  <input type="text" name="weight" class="form-control" value="{{ old('weight')}}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-4">
                    <label class="col-form-label _body_fat_percentage_">体脂肪率</label>
                </div>
                <div class="col-8">
                    <input type="text" name="fat" class="form-control" value="{{ old('fat')}}">
                </div>
            </div>

            <div class="row pt-3 pb-3">
                <h4 class="mx-auto">トレーニング機器</h4>
            </div>


            @if($equipment)
                @foreach($equipment as $key=>$val)
                <div class="row mb-3">
                    <div class="col-4">
                        <input type="hidden" name="equipment[{{$key}}][id]" value="{{$val->id }}">
                        <label class="col-form-label _barbell_">{{$val->name }}</label>
                    </div>
                    <div class="col-8">
                        <select class="form-control" name="equipment[{{$key}}][is_available]">
                            {{-- <option> 持ってる</option> --}}
                            <option value="1"> はい</option>
                            <option value="0"> 番号</option>


                        </select>
                    </div>
                </div>
                @endforeach
            @endif 

        </div>
        <div class="card-footer">
            <div class="row pt-3 pb-3">
                <button type="submit" class="mx-auto btn btn-secondary text-white btn-lg ">次へ</button>
            </div>
        </div>
      
    </form>
  </div>
</div>


    <div class="row"></div>
  </div>

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