{{-- @extends('master_page') --}}
@extends('auth.master')
@section('title','trainer signup')
@section('content')
<div class="row pb-5">
      <h4 class="mx-auto">オンラー<br>(ニングマ)</h4>
    </div>
    
    <div class="offset-sm-2 col-sm-8 mb-4">
         <form action="{{route('trainerSignup.submit')}}" method="post">
    {{ csrf_field() }}

      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label _first_name_">ファーストネーム</label>
        </div>
        <div class="col-8">
          <input type="text" name="first_name" class="form-control" value="{{ old('first_name')}}">
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label _first_phonetic_">最初の音声</label>
        </div>
        <div class="col-8">
          <input type="text" name="first_phonetic" class="form-control" value="{{ old('first_phonetic') }}">
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label _family_name_">苗字</label>
        </div>
        <div class="col-8">
          <input type="text" name="family_name" class="form-control" value="{{ old('family_name') }}">
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label _family_phonetic_">家族のふりがな</label>
        </div>
        <div class="col-8">
          <input type="text" name="family_phonetic" class="form-control" value="{{ old('family_phonetic') }}">
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label _e-mail address_">電子メールアドレス</label>
        </div>
        <div class="col-8">
          <input type="text" name="email" class="form-control" value="{{ old('email') }}">
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

      <div class="row pt-3 pb-3">
        <h2 class="mx-auto _prefecture_">県下</h2>
      </div>
      <div class="row pt-3 pb-3">
        <textarea name="prefecture" class="form-control" id="" rows="3"></textarea>
      </div>


      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label _city_">市</label>
        </div>
        <div class="col-8">
          <input type="text" name="city" class="form-control" value="{{ old('city')}}">
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
          <label class="col-form-label _zip_code_ ">郵便番号</label>
        </div>
        <div class="col-8">
          <input type="text" name="zip_code" class="form-control" value="{{ old('zip_code')}}">
        </div>
      </div>


      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label _phone_">電話</label>
        </div>
        <div class="col-8">
          <input type="text" name="phone" class="form-control" value="{{ old('phone')}}">
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label _unit_price">単価</label>
        </div>
        <div class="col-8">
          <input type="text" name="unit_price" class="form-control">
        </div>
      </div>

      <div class="row pt-3 pb-3">
        <h4 class="mx-auto _introduction_">前書き</h4>
      </div>
      <div class="row pt-3 pb-3">
        <textarea name="intro" class="form-control" id="" rows="5">{{ old('intro')}}</textarea>
      </div>

      <div class="row pt-3 pb-3">
        <h4 class="mx-auto _photo_path_">写真のパス</h4>
      </div>
      <div class="row pt-3 pb-3">
        <textarea name="photo_path" class="form-control" id="" rows="5"></textarea>
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
       <!-- <div class="row pt-3 pb-3">
        <h2 class="mx-auto">ングマ</h2>
      </div>
      <div class="row pt-3 pb-3">
        <textarea name="" class="form-control text-center" id="" placeholder="オンラニングマオンラニングマ" rows="5"></textarea>
      </div> -->
      
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