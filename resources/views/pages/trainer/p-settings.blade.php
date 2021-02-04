{{-- @extends('master_page') --}}
@extends('master_dashboard')
@section('title','trainee personal settings')
@section('header_css_js')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection
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
         @if(Session::has('success'))
        <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}</p>
        @endif



    </div>



<div class="offset-sm-2 col-sm-8 mb-4">

    


    <div class="card card-info">
      

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
      <li class="nav-item ">
        <a class="nav-link active" id="updateprofile-tab" data-toggle="pill" href="#updateprofile" role="tab" aria-controls="updateprofile" aria-selected="true">Update Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="changepassword-tab" data-toggle="pill" href="#changepassword" role="tab" aria-controls="changepassword" aria-selected="false">Change Password</a>
      </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="updateprofile" role="tabpanel" aria-labelledby="updateprofile-tab">
              <form action="{{route('trainer.p-settings.submit')}}" method="post">
                   
                {{ csrf_field() }}
              <input type="hidden" name="email" class="form-control" value="{{ $user->email}}">
                  <input type="hidden" name="user_id" class="form-control" value="{{ $user->id}}">   
                  <input type="hidden" name="action_type"  value="info_update">   
                  <div class="card-body">

                    <div class="row mb-3">
                      <div class="col-4">
                        <label class="col-form-label _first_name_">ファーストネーム</label>
                      </div>
                      <div class="col-8">
                        <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-4">
                        <label class="col-form-label _first_phonetic_">最初の音声</label>
                      </div>
                      <div class="col-8">
                        <input type="text" name="first_phonetic" class="form-control" value="{{ $user->first_phonetic }}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-4">
                        <label class="col-form-label _family_name_">苗字</label>
                      </div>
                      <div class="col-8">
                        <input type="text" name="family_name" class="form-control" value="{{ $user->family_name }}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-4">
                        <label class="col-form-label _family_phonetic_">家族のふりがな</label>
                      </div>
                      <div class="col-8">
                        <input type="text" name="family_phonetic" class="form-control" value="{{ $user->family_phonetic }}">
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
                        <label class="col-form-label _city_">市</label>
                      </div>
                      <div class="col-8">
                        <input type="text" name="city" class="form-control" value="{{ $user->city}}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-4">
                        <label class="col-form-label _address_">住所</label>
                      </div>
                      <div class="col-8">
                        <input type="text" name="address" class="form-control" value="{{ $user->address_line}}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-4">
                        <label class="col-form-label _zip_code_ ">郵便番号</label>
                      </div>
                      <div class="col-8">
                        <input type="text" name="zip_code" class="form-control" value="{{ $user->zip_code}}">
                      </div>
                    </div>


                    <div class="row mb-3">
                      <div class="col-4">
                        <label class="col-form-label _phone_">電話</label>
                      </div>
                      <div class="col-8">
                        <input type="text" name="phone" class="form-control" value="{{ $user->phone}}">
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

                    <div class="row mb-3">
                        <div class="col-4">
                            <label class="col-form-label interface">インターフェース</label>
                        </div>
                        <div class="col-8">
                            <select class="form-control" name="interface">
                                {{-- <option> 持ってる</option> --}}
                                <option value="pc"> パソコン</option>
                                <option value="smartphone"> スマートフォン</option>
                                <option value="tablet"> タブレット</option>
                            </select>
                        </div>
                    </div>

                      <div class="row pt-3 pb-3">
                        <h2 class="mx-auto _prefecture_">県下</h2>
                      </div>
                      <div class="row pt-3 pb-3">
                        <textarea name="prefecture" class="form-control"  rows="3">{{ $user->prefecture}}</textarea>
                      </div>


                      

                      <div class="row pt-3 pb-3">
                        <h4 class="mx-auto _introduction_">自分自身について</h4>
                      </div>
                      <div class="row pt-3 pb-3">
                        <textarea name="intro" class="form-control" rows="5">{{ $user->intro}}</textarea>
                      </div>
                      <div class="row pt-3 pb-3">
                        <h4 class="mx-auto certification">証明書</h4>
                      </div>
                      <div class="row pt-3 pb-3">
                        <textarea name="certification" class="form-control" rows="5">{{ $user->certification}}</textarea>
                      </div>

                      <div class="row pt-3 pb-3">
                        <h4 class="mx-auto _photo_path_">写真のパス</h4>
                      </div>
                      <div class="row pt-3 pb-3">
                        <textarea name="photo_path" class="form-control"  rows="5"></textarea>
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
                            <button type="submit" class="mx-auto btn  text-white btn-lg gradient">次へ</button>
                      </div>
              </div>
      
        </form>
      </div>

      <div class="tab-pane fade" id="changepassword" role="tabpanel" aria-labelledby="changepassword-tab">
        <form action="{{route('trainer.p-settings.submit')}}" method="post">
                   
            {{ csrf_field() }}
            <input type="hidden" name="email"  value="{{ $user->email}}">
            <input type="hidden" name="user_id"  value="{{ $user->id}}">   
            <input type="hidden" name="action_type"  value="password_update">   
            <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label">以前のパスワード <span style="color:red">*</span></label>
                </div>
                <div class="col-8">
                  <input type="password" name="oldpassword" class="form-control" value="" required="required">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label">パスワード <span style="color:red">*</span></label>
                </div>
                <div class="col-8">
                  <input type="password" name="password" class="form-control" value="" required="required">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label _confirm_password_">パスワード(確認) <span style="color:red">*</span></label>
                </div>
                <div class="col-8">
                  <input type="password" name="password_confirmation" class="form-control" value="" required="required">
                </div>
            </div>

        </div>
        <div class="card-footer">
            <div class="row pt-3 pb-3">
                <button type="submit" class="mx-auto btn btn-secondary text-white btn-lg gradient ">次へ</button>
            </div>
        </div>
      
        </form>
      </div>
    </div>




  </div>
</div>
</section>




@endsection
@section('footer_css_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script>
    $(document).ready(function() {

        $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
            $(".alert-success").slideUp(500);
        });

        $('.datepicker').datepicker();

    });

</script>
@endsection 