{{-- @extends('master_page') --}}
@extends('../master')
@section('title','trainer signup')
@section('header_css_js')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="{{asset('asset_v2/css/range_slider.css')}}">

@php 
    $param=encryptionValue(['user_id' => $user->id]);
@endphp
@endsection
@section('content')
<style>
</style>

<section class="review_part gray_bg section_padding">
    <div class="container">
      <div class="row justify-content-center">
          <div class="col-md-8 col-xl-6">
              <div class="section_tittle">
                  {{-- Trainer information --}}
                  <h2>トレーナー情報</h2>
              </div>

          </div>
      </div>
    </div>
        <div class="offset-sm-1 col-sm-10 mb-4">
          <div class="card card-info">
            <div class="card-header">
                  {{-- Add more information --}}
                  <h4 class="card-title">情報を登録する</h4>
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

            <form action="{{route('trainerSignupUpdate.submit')}}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
              <input type="hidden" name="email" class="form-control" value="{{ $user->email}}">
                  <input type="hidden" name="user_id" class="form-control" value="{{ $user->id}}">   
                  <div class="card-body">

                    <div class="row mb-3">
                      <div class="col-4">
                        <label class="col-form-label _first_name_">名字 <span style="color:red">*</span> </label>
                      </div>
                      <div class="col-8">
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name')}}" required="required">
                      </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                          <label class="col-form-label sex">性別 <span style="color:red">*</span> </label>
                        </div>
                         <div class="col-8">
                            <select class="form-control" name="sex" required="required">
                                {{-- 1 male, 0 女性  --}}
                                <option value="" > 性別をお選びください  </option> 
                                <option value="male" {{ $user->sex == 'male' ? 'selected' : ''}} > 男性</option> 
                                <option value="female" {{ $user->sex == 'female' ? 'selected' : ''}}> 女性</option>


                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-4">
                        <label class="col-form-label _first_phonetic_">フリガナ(名字)</label>
                      </div>
                      <div class="col-8">
                        <input type="text" name="first_phonetic" class="form-control" value="{{ old('first_phonetic') }}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-4">
                        <label class="col-form-label _family_name_">名前</label>
                      </div>
                      <div class="col-8">
                        <input type="text" name="family_name" class="form-control" value="{{ old('family_name') }}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-4">
                        <label class="col-form-label _family_phonetic_">フリガナ(名前)</label>
                      </div>
                      <div class="col-8">
                        <input type="text" name="family_phonetic" class="form-control" value="{{ old('family_phonetic') }}">
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
                          <label class="col-form-label _confirm_password_">パスワード(確認)<span style="color:red">*</span></label>
                        </div>
                        <div class="col-8">
                          <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation')}}" required="required">
                        </div>
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
                        <input type="text" name="phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  class="form-control" value="{{ old('phone')}}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-4">
                        <label class="col-form-label _unit_price">希望単価</label>
                      </div>
                      <div class="col-8">
                        <input type="text" name="unit_price" class="form-control">
                      </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                            <label class="col-form-label interface">機器</label>
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
                        <h2 class="mx-auto _prefecture_">都道府県</h2>
                      </div>
                      <div class="row pt-3 pb-3">
                        <textarea name="prefecture" class="form-control"  rows="3">{{ old('prefecture')}}</textarea>
                      </div>

                      <div class="row pt-3 pb-3">
                        <h4 class="mx-auto _introduction_">自己紹介</h4>
                      </div>
                      <div class="row pt-3 pb-3">
                        <textarea name="intro" class="form-control" rows="5">{{ old('intro')}}</textarea>
                      </div>
                      <div class="row pt-3 pb-3">
                        <h4 class="mx-auto certification">資格や実績など</h4>
                      </div>
                      <div class="row pt-3 pb-3">
                        <textarea name="certification" class="form-control" rows="5">{{ old('certification')}}</textarea>
                      </div>

                      {{-- <div class="row pt-3 pb-3">
                        <h4 class="mx-auto _photo_path_">写真のアップロード</h4>
                      </div>
                      <div class="row pt-3 pb-3">
                          <input type="file" name="image" id="photo_path" >

                      </div> --}}
                       <div class="row pt-3 pb-3">
                        <h4 class="mx-auto _photo_path_">写真のアップロード</h4>
                      </div>
                      <div class="row pt-3 pb-3" style="border: 1px solid #ebe7e7">
                        {{-- <textarea name="photo_path" class="form-control"  rows="5"></textarea> --}}
                        <div class="col-md-8">
                          @if($user->photo_path != NULL)

                            <img  style="width:200px" src="{{asset('images').'/'.$user->photo_path}}" style="height: 200;width: 200" />
                          @else 

                            <img src="{{asset('images/user-thumb.jpg')}}"  width="200" width="200">
                          @endif
                        </div>
                        <div class="col-md-4">
                          <h4 class="mx-auto _photo_path_">写真変更</h4>
                          <input type="file" name="image" id="photo_path" >

                        </div>
                      </div>

                        <!--- icon creation --->
                    <div class="row pt-3 pb-3">
                        <h4 class="mx-auto _photo_path_" id="original_icon">アイコン作成</h4>
                        
                    </div>
                    <div class="row pt-3 pb-3" style="border: 1px solid #ebe7e7">
                        <div class="col-md-8">
                           <div id="uploaded_image">
                                @if($user->icon_image != NULL)
                                    <img class="rounded-circle" src="{{ url('storage/icons/'.$user->icon_image)}}" />
                                @else 
                                <img src="{{asset('images/default.png')}}"  width="200" width="200">
                                @endif 
                            </div> 
                        </div>
                        <div class="col-md-4">
                            <h4 class="mx-auto _photo_path_" id="new_icon">アイコンを作成</h4>
                            <input type="file" class="mx-auto" name="icon_image" id="icon_image" accept="image/*" style="width: 100%" />
                            <p style="font-size:12px;padding: 5px;">顔が大きく映っている写真を選択してください</p>
                        </div>
                        <br>


                    {{-- <button type="button" class="mx-auto btn_2" style="border-radius: 1px !important;border: 2px solid #056fb8;color: #056fb8;font-size: 18px;" data-toggle="modal" data-target="#exampleModal">
                    アイコン作成
                    </button> --}}

                    </div>
                      <!--- ------------- --->

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
                                      <option value="0"> いいえ</option>


                                  </select>
                              </div>
                          </div>
                          @endforeach
                      @endif


                    @php 
                      $ratingsInput = \App\Model\RatingsSetup::where('status',1)->get();
                      $instructionSetupData = \App\Model\TrainerSetupData::where('status',1)->where('type','instruction')->get();
                    @endphp


                    @if(isset($instructionSetupData))
                    <div class="row mb-3">
                        <div class="col-4">
                            <label class="col-form-label interface">指導分野</label>
                        </div>
                        <div class="col-8">
                          @php 
                          $count=0;
                          @endphp
                          @foreach($instructionSetupData as $key=>$val)
                          @php 
                              $old="";
                              if($user->instructions && in_array($val->name,unserialize( $user->instructions))){
                                $old ='checked';
                              }   
                              if(is_array(old('instruction')) && in_array($val->name,old('instruction'))){ 
                                $old ='checked';
                              } 
                          @endphp 
                            <div class="form-check form-check-inline" >
                                <input class="form-check-input" style="transform: scale(1.5)" type="checkbox" id="inlineCheckbox_{{ $val->id}}" name="instruction[]" value="{{ $val->name}}"  {{ $old}}>
                                <label class="form-check-label" for="inlineCheckbox_{{ $val->id}}">{{ $val->name }}</label>
                            </div>

                            @php 
                              $count++;
                            @endphp

                           @endforeach   
                        </div>
                    </div>
                    @endif 


                     <div class="row pt-3 pb-3">
                        <h4 class="mx-auto">自己評価</h4>
                    </div>



                    
                      @if(isset($ratingsInput))
                        @foreach($ratingsInput as $val)
                          <div class="row mb-3">
                            <div class="col-4">
                              <label class="col-form-label float-left " style="font-size:1.3em;margin-top:10px;font-weight: bold"> {{ $val->name }} </label>
                            </div>

                            @php 
                            $eval_value = json_decode( $user->self_evaluation,true);
                            $old_val = "ratings_".$val->id;
                            
                            @endphp
                            <div class="col-8">
                                  <input type="text" class="js-range-slider" id="{{$val->id}}" name="ratings_{{ $val->id}}" value=""
                                  data-min="0"
                                  data-max="5"
                                  data-from="{{ $eval_value ? evalInitial($eval_value,$val->id) : (old($old_val) ? old($old_val) : 0) }}"
                                  />
                            </div>
                          </div>
                        @endforeach
                      @endif 
                <input type="hidden" id="total" name="total">
              </div>
              <div class="card-footer">
                      <div class="row pt-3 pb-3">
                            <button type="submit" class="mx-auto btn  text-white btn-lg gradient">次へ</button>
                      </div>
              </div>
            
               </form>

          </div>
          </div>
      
</section>


    <div class="row"></div>

<!-- Modal -->
<div id="uploadimageModal" class="modal" role="dialog" style="z-index: 30032">
 <div class="modal-dialog">
  <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">写真加工</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </div>

        <div class="modal-body">
          <div class="row">
       <div class="col-md-8 text-center">
        <div id="image_demo" style="width:350px; margin-top:30px"></div>
       </div>
       <div class="col-md-4" style="padding-top:30px;">
        <br />
        <br />
        <br/>
     </div>
    </div>
        </div>
        <div class="modal-footer" >
            <span id="loading"  style="display: none;"> 
               アイコン作成... <i class="fas fa-spinner fa-spin fa-2x "></i>
            </span>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
        <button type="button" class="btn btn-primary crop_image">決定</button>        </div>
     </div>
    </div>
</div>

@endsection
@section('footer_css_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script src="{{asset('asset_v2/js/croppie.min.js')}}"></script>

<link rel="stylesheet" href="{{asset('asset_v2/css/croppie.css')}}">
<script src="{{asset('asset_v2/js/range_slider.js')}}"></script>


<script>
 
        $image_crop = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
          width:200,
          height:200,
          type:'circle' //circle
        },
        boundary:{
          width:300,
          height:300
        },
        enableOrientation: true,
            enforceBoundary: true,
            enableResize: false


        });
      


      var fileTypes = ['jpg', 'jpeg', 'png'];
        $('#icon_image').on('change', function() {
          var reader = new FileReader();
          var file = this.files[0]; // Get your file here
          var fileExt = file.type.split('/')[1]; // Get the file extension

          if (fileTypes.indexOf(fileExt) !== -1) {
            reader.onload = function(event) {
              $image_crop.croppie('bind', {
                url: event.target.result
              }).then(function() {
                console.log('jQuery bind complete');
              });
              
            }
            reader.readAsDataURL(file);
            $('#uploadimageModal').modal('show');
          } else {
            alert('File not supported');
          }

          $("#icon_image").val('');
        });


    $('.crop_image').click(function(event){
        $('#loading').show();
        $image_crop.croppie('result', {
          type: 'canvas',
          size: 'viewport'
        }).then(function(response){

            $.ajax({
                type: "POST",
                url: '{{ route('icon_creation', $param)}}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: { 'image': response },
                cache: false,
                success: function(res) {

                    $('#uploadimageModal').modal('hide');
                    $('#uploaded_image').html(res.html);
                    $('#loading').hide();

                },
                error:function(request, status, error) {
                    console.log("ajax call went wrong:" + request.responseText);
                }
            });

        })
    });

    $(function () {
    $('#photo_path').change(function () {
        var val = $(this).val().toLowerCase(),
            regex = new RegExp("(.*?)\.(jpg|jpeg|png)$");
        if (!(regex.test(val))) {
            $(this).val('');
            alert(' Image file is not valid !!');
        }
    });

});
      function setRatings(val){
          
          $("#total").val(val);

      }
      function updateArray(key,val){
        ratingsArray[key] = val;
        $("#total").val('');
        $("#total").val(JSON.stringify(ratingsArray));
      }


      var ratingsArray = {
      };
      $(".js-range-slider").ionRangeSlider({
        min: 0,
        max: 5,
        from: 0,
        skin:'big',
        onStart: function (data) {
           if(data.from == 0){
              $(".irs-single").hide();
            }
    
            updateArray(data.input.attr('id'),$("input[name^="+data.input.attr('name')+"]").val());
          
        },
    
        onChange: function (data) {
            if ($("#"+data.input.attr('id')).val() > 0){
                  $("#"+data.input.attr('id')).siblings('span').find('.irs-single').show();
            }else{
                  $("#"+data.input.attr('id')).siblings('span').find('.irs-single').hide();
            }
            // Called every time handle position is changed
            updateArray(data.input.attr('id'),$("input[name^="+data.input.attr('name')+"]").val());


        },
    
        onFinish: function (data) {
            // Called then action is done and mouse is released
    
            updateArray(data.input.attr('id'),$("input[name^="+data.input.attr('name')+"]").val());
            // console.log(ratingsArray);
            //   let total = Object.values(ratingsArray).reduce((t, n) => parseInt(t) + parseInt(n))
              // setRatings(total);
            // console.log('On finish '+total);
        },
        onUpdate: function (data) {
            // Called then slider is changed using Update public method
    
          console.log.log('update'); 

        }
    });

</script>
@endsection 