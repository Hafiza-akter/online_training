{{-- @extends('master_page') --}}
@extends('auth.master')
@section('title','trainer signup')
@section('content')
<div class="row pb-5">
    <h4 class="mx-auto">新規登録
    <br>(オンラー)</h4>
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
                <input type="email" name="email" class="form-control" value="{{ old('email')}}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-4">
              <label class="col-form-label">パスワード</label>
            </div>
            <div class="col-8">
              <input type="password" name="password" class="form-control" value="{{ old('password')}}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-4">
              <label class="col-form-label _confirm_password_">パスワードを認証する</label>
            </div>
            <div class="col-8">
              <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation')}}">
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

        {{-- <div class="row mb-3">
            <div class="col-4">
                <label class="col-form-label _dumbell_">ダンベル</label>
            </div>
            <div class="col-8">
            <select class="form-control">
                <option> 持ってる</option>
            </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-4">
                <label class="col-form-label _bench_">ベンチ</label>
            </div>
            <div class="col-8">
                <select class="form-control">
                    <option> 持ってる</option>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-4">
                <label class="col-form-label _barbell_">バーベル</label>
            </div>
            <div class="col-8">
                <select class="form-control">
                    <option> 持ってる</option>
                </select>
            </div>
        </div> --}}

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



      {{--  <div class="row pt-3 pb-3">
        <h2 class="mx-auto">ングマ</h2>
      </div>
      <div class="row pt-3 pb-3">
        <textarea name="" class="form-control text-center" id="" placeholder="オンラニングマオンラニングマ" rows="5"></textarea>
      </div> --}}
      
     <!-- <div class="row pt-3 pb-3">
        <h2 class="mx-auto">オオマ</h2>
      </div>

      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label">ニングマ</label>
        </div>
        <div class="col-8">
          <input type="text" name="" class="form-control">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label">ニングマ</label>
        </div>
        <div class="col-8">
          <input type="text" name="" class="form-control">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label">ニングマ</label>
        </div>
        <div class="col-8">
          <input type="text" name="" class="form-control">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label">ニングマ</label>
        </div>
        <div class="col-8">
          <input type="text" name="" class="form-control">
        </div>
      </div> -->

        <div class="row pt-3 pb-3">
            <button type="submit" class="mx-auto btn btn-secondary text-white btn-lg ">次へ</button>
        </div>
      
    </form>

</div>


    <div class="row"></div>
  </div>

@endsection