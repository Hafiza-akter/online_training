@extends('master_dashboard')
@section('title','trainee trainerlist')
@section('header_css_js')
<script src="{{ asset('asset_v2/js/sweetalert.min.js')}}"></script>
<script src="{{ asset('asset_v2/js/moment_2.29.1.min.js')}}" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>  
<script  src="https://momentjs.com/downloads/moment-timezone-with-data.js"></script>
<script type="text/javascript">
    Object.defineProperty(window.navigator, 'userAgent', {
      get: function () { return 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.163 Chrome/80.0.3987.163 Safari/537.36'; }
    });
  </script>
@endsection
      {{-- @include('pages.trainee.dashboard') --}}
@section('content')
<style>
.premeeting-screen .content .copy-meeting .copy-meeting-text,
.premeeting-screen .content .copy-meeting .url .jitsi-icon {
    display: none;
}
.performance{
    border: 1px solid #f8f8;
    padding: 14px;
    margin-bottom: 2px; 
}
 #clock {
    position: absolute;
    top: 40%;
    left: 1%;
    /*transform: translateX(-50%) translateY(-50%);*/
    color: red;
    font-size: 2rem;
   


}
.modal-backdrop {
   background: none !important;
}
.column{
  float: left;
  /*width: 50%;*/
  padding: 5px;
}

.mnt::after {
  content: "";
  clear: both;
  display: table;
}

</style>
<section class="review_part gray_bg section_padding">


    <div id="meet" style="height: 86vh;width: 100%;"></div>

    <div class="col-md-12 col-sm-12 mb-4">
        <div class="row justify-content-center">
        
          <div class="col text-center">
            <div class="card m-1 user" style="display:inline-flex;height: 80px;width:80px">
              <div class="card-body" >
                 <span><img src="{{ asset('images/user_camera.png')}}"></span>
              </div>
            </div>
            <div class="card m-1 trainer" style="display:inline-flex;height: 80px;width:80px">
              <div class="card-body" >
                <span><img src="{{ asset('images/camera.png')}}"></span>
              </div>
            </div>
            <div class="card m-1 screenshare" style="display:inline-flex;height: 80px;width:80px">
              <div class="card-body" >
                  <span><img src="{{ asset('images/share.png')}}"></span>
              </div>
            </div>
            <div class="card m-1" onclick="$('.bd-example-modal-lg4').modal()" style="display:inline-flex;height: 80px;width:80px">
              <div class="card-body" >
                  <span><img src="{{ asset('images/gif.png')}}"></span>

              </div>
            </div>
            <div class="card m-1"  style="display:inline-flex;height: 80px;width:80px">
              <div class="card-body" >
                  <span><img src="{{ asset('images/cl.png')}}"></span>

              </div>
            </div>
            
          </div>


      </div>
    </div>

</section>

    <div class="modal fade left" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background: #a331a3;">
            <h3 class="" id="exampleModalLabel" style="text-align: center;color: white;">
            トレーニングデータ
            </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <!-- insert mode -->
            
            @if(!$exerciseData || count($exerciseData->getExerciseData) == 0)
            <form action="{{route('training_performance')}}" method="post" id="performance_form">
              {{ csrf_field() }}
              <!-- insert mode form-->
                <input type="hidden" name="schedule_id" value="{{ $schedule->id}}">
                <input type="hidden" name="trainer_id" value="{{ $schedule->trainer_id}}">

                    <div class="container performance" id="performance">
                      <div class="row" >
                        <div class="col-sm-4">
                        <label class="col-form-label">メイン</label>
                            <select class="form-control main" style="width: 100%;" name="main[]" >
                                <option value="">--select-- </option>
                                @if($body_part)
                                  @foreach($body_part as $val)
                                    <option value="{{ $val->body_part}}" id="{{ $val->body_part}}">{{ $val->body_part}}</option>
                                  @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-4">
                        <label class="col-form-label">コース</label>
                            <select class="form-control course" style="width: 100%;" name="course[]" required="required">
                                <option value="">--select--</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                        <label class="col-form-label">備品</label>
                            <select class="form-control equipment" style="width: 100%;" name="equipment[]" >
                                <option value="">--select--</option>
                            </select>
                        </div>
                        
                      </div>
                      <div class="row justify-content-center">
                          <div class="col-sm-8  m-1 ">
                           <label class=" col-form-label">Set 1</label>
                            <input name="set1_kg[]" class="set1_kg kg p-1 m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>KG</span>
                            <input name="set1_times[]" class="set1_times times kg p-1 m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required" /><span>回</span>

                          </div>
                          <div class="col-sm-8 m-1">
                           <label class=" col-form-label">Set 2</label>
                            <input name="set2_kg[]" class="set2_kg set1  kg p-1 m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>KG</span>
                            <input name="set2_times[]" class="set2_times times kg p-1 m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  required="required"/><span>回</span>
                          </div>
                          <div class="col-sm-8 m-1">
                           <label class=" col-form-label">Set 3</label>
                            <input name="set3_kg[]" class="set3_kg kg p-1 m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>KG</span>
                            <input name="set3_times[]" class="set3_times times kg p-1 m-1"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>回</span>
                          </div>

                      </div>

                    </div>
                        <div class="row" >

                    <div class="col-sm-8 m-1">
                    <button type="button" class="btn btn-secondary float-right m-2 add_button" > <i class="fas fa-plus"></i> </button>
                    </div>
                    </div>
            <div class=" row justify-content-center m-1 p-1">
              <button type="button" class="btn btn-secondary m-1" data-dismiss="modal">閉じる</button>
              <a  class="nav-link active__ m-1 submit_performance" id="submit_performance" style="color: white;">更新する</a>
            
            </div>
            </form>
            @endif
            <!-- // end insert mode -->

            <!-- edit mode -->
            @if($exerciseData &&  count($exerciseData->getExerciseData) > 0)
            <form action="{{route('training_performance')}}" method="post" id="performance_form">
              {{ csrf_field() }}
              <!-- edit mode form-->

                <input type="hidden" name="schedule_id" value="{{ $schedule->id}}">
                <input type="hidden" name="trainer_id" value="{{ $schedule->trainer_id}}">
                    @foreach($exerciseData->getExerciseData as $key=>$value)
                    @php 
                        $coursesData = getCourseData($value->course_id);
                        $set1= $value->set_1;
                        $sd1=explode("_",$set1);

                        $set2= $value->set_2;
                        $sd2=explode("_",$set2);

                        $set3= $value->set_3;
                        $sd3=explode("_",$set3);

                        // dd($sd1[1]);

                    @endphp
                    <div class="container performance" id="performance{{$key > 0 ? $key : ''}}">
                      <div class="row" >
                        <div class="col-sm-4">
                        <label class="col-form-label">体の部分</label>
                            <select class="form-control main" style="width: 100%;" name="main[]" >
                                @if($body_part)
                                  @foreach($body_part as $val)
                                    <option value="{{ $val->body_part}}" id="{{ $val->body_part}}" {{$val->body_part ==  $coursesData->body_part ? 'selected' : '' }}>{{ $val->body_part}}</option>
                                  @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-4">
                        <label class="col-form-label">コース</label>
                            <select class="form-control course" style="width: 100%;" name="course[]" required="required">
                                @foreach(getCourseDataMain($coursesData->body_part) as $v)
                                   <option value="{{$v->id}}" {{ $value->course_id == $v->id ? 'selected' : ''}}>{{ $v->course_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                        <label class="col-form-label">備品</label>
                            <select class="form-control equipment" style="width: 100%;" name="equipment[]" >
                                   <option value="{{$v->equipment_id}}" >{{ getEquipment($coursesData->equipment_id)->name }}</option>
                            </select>
                        </div>
                        
                      </div>

                     

                      <div class="row justify-content-center">
                          <div class="col-sm-8  m-1 ">
                           <label class=" col-form-label">Set 1</label>
                            <input name="set1_kg[]" class="set1_kg kg p-1 m-1" value="{{ $sd1[0]}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>KG</span>
                            <input name="set1_times[]" class="set1_times times kg p-1 m-1" value="{{ $sd1[1]}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required" /><span>回</span>

                          </div>
                          <div class="col-sm-8 m-1">
                           <label class=" col-form-label">Set 2</label>
                            <input name="set2_kg[]" class="set2_kg set1  kg p-1 m-1" value="{{ $sd2[0]}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>KG</span>
                            <input name="set2_times[]" class="set2_times times kg p-1 m-1" value="{{ $sd2[1]}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  required="required"/><span>回</span>
                          </div>
                          <div class="col-sm-8 m-1">
                           <label class=" col-form-label">Set 3</label>
                            <input name="set3_kg[]" class="set3_kg kg p-1 m-1"  value="{{ $sd3[0]}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>KG</span>
                            <input name="set3_times[]" class="set3_times times kg p-1 m-1"  value="{{ $sd3[1]}}"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>回</span>
                          </div>

                          
                      </div>

                      @if($key > 0)
                      <input type="button" value="削除" class="m-1 remove btn btn-danger"/>
                      @endif
                    </div>
                    @endforeach

                        <button type="button" class="btn btn-secondary float-right m-2 add_button" > <i class="fas fa-plus"></i> </button>
                    <br>
              <div class=" row justify-content-center m-1 p-1">
                <button type="button" class="btn btn-secondary m-1" data-dismiss="modal">閉じる</button>
                <a  href="#" class="nav-link active__ m-1 submit_performance" id="submit_performance" style="color: white;">更新する</a>
              
              </div>
            </form>
            @endif
            <!-- // end edit mode -->
          </div>
         {{--  <div class="modal-footer row justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
            <button type="submit" class="nav-link active__ submit_performance" style="color: white;">送信</button>
          
          </div> --}}
        </div>
      </div>
      </div>
     <input type="hidden" value="{{ $exerciseData ? count($exerciseData->getExerciseData) : 1}}" id="counter">
  
<!-- simple course modal with explanation -->
    <div class="modal fade left bd-example-modal-lg2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
          <div class="modal-header" style="background: #a331a3;">
            <h3 class="" id="exampleModalLabel" style="text-align: center;color: white;">
            Course List
            </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              {{ csrf_field() }}

               <table class="table table-striped" style="background: #f9f9ff;">
                
                <tbody>
                  @if($course)
                @foreach( $course as $key=>$val)
                  <tr>
                    <td>
                      <input type="radio" name="course_list" id="course_list_{{ $val->id}}" onclick="showExplanation(`{{ $val->summary}}`,`{{ $val->body_part}}`,`{{ $val->main}}`,`{{ $val->sub}}`,`{{ $val->way}}`,`{{ $val->motion}}`)">  
                      <label for="course_list_{{ $val->id}}"> {{ $val->course_name}} </label>
                    </td>
                  </tr>
                @endforeach

              @endif
                 
                </tbody>
              </table>
              

                            
            </form>
          </div>
         {{--  <div class="modal-footer row justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
            <button type="button" class="nav-link active__" style="color: white;">更新する</button>
          </div> --}}
        </div>
      </div>
    </div>
<!-- ///////////////-->
<!-- simple course modal with gif -->
    <div class="modal fade left bd-example-modal-lg4" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
          <div class="modal-header" style="background: #a331a3;">
            <h3 class="" id="exampleModalLabel" style="text-align: center;color: white;">
            Course List
            </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              {{ csrf_field() }}

               <table class="table table-striped" style="background: #f9f9ff;">
                
                <tbody>
                  @if($course)
                @foreach( $course as $key=>$val)
                @php 
                  if($val->image_path != ''){
                   $image= asset('images').'/'.$val->image_path;
                  }else{
                   $image= asset('images').'/no_image.png';
                  }
                @endphp
                  <tr>
                    <td>
                      <input type="radio" name="course_list" id="course_list_{{ $val->id}}" onclick="showGif(`{{ $image}}`)">  
                      <label for="course_list_{{ $val->id}}"> {{ $val->course_name}} </label>
                    </td>
                  </tr>
                @endforeach

              @endif
                 
                </tbody>
              </table>
              

                            
            </form>
          </div>
        </div>
      </div>
    </div>
<!-- ///////////////-->

<!-- feedback -->
    <div class="modal fade left bd-example-modal-lg3" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog  modal-lg">
        <div class="modal-content">
          <div class="modal-header" style="background: #a331a3;">
            <h3 class="" id="exampleModalLabel" style="text-align: center;color: white;">
            コメント
            </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
              <form action="{{route('training_feedback')}}" method="post" id="feed_back_form">
              <!-- edit mode form-->

                <input type="hidden" name="schedule_id" value="{{ $schedule->id}}">
                <input type="hidden" name="trainer_id" value="{{ $schedule->trainer_id}}">
              {{ csrf_field() }}
                <div class="form-group  row justify-content-center">
                  <div class="col-sm-10">
                  <label class="col-form-label">コメントの入力</label>
                      @if(Session::get('user_type') == 'trainee'){
                      <textarea class="form-control customEditor"  name="user_feedback" style="width: 400px; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $exerciseData ? $exerciseData->comment : ''}}</textarea>
                      @else 
                       <textarea class="form-control customEditor"  name="user_feedback" style="width: 400px; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $exerciseData ? $exerciseData->comment: ''}}</textarea>
                      @endif
                  </div>
              </div>
               <div class=" row justify-content-center">
            <button type="button" class="btn btn-secondary m-1" data-dismiss="modal">閉じる</button>
            <a type="submit" href="#" class="nav-link active__ m-1" id="f_btn" style="color: white;">送信</a>
          </div>
            </form>
          </div>
         
        </div>
      </div>
    </div>
<!-- //////////////-->

<!-- monitor modal -->
    <div class="modal fade" id="rightModal" tabindex="-1" role="dialog" aria-labelledby="rightModalLabel" aria-hidden="true" >
      <div class="modal-dialog  modal-lg modal-dialog-slideout" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="rightModalLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body" style="overflow: scroll;">
            

          <div class="row mnt">
            <div class="column">
              <table style="border:1px solid #eee;">
                
                <tr>
                  <td  class="p-1">
                     <button class="btn btn-md btn-primary btn-outline btn-block">前回のリストをコピー</button>
                  </td>
                 
                </tr>
                <tr>
                  <td  class="p-1">
                     <button class="btn btn-md btn-secondary btn-outline btn-block">セットメニューからコピー</button>
                  </td>
                 
                </tr>
                <tr>
                  <td class="p-3">
                      <a href="#" class="previous" style="display:inline-block;">&laquo; Previous</a>
                       <a style="display:inline-block;"> 〇年〇月〇日 </a>
                      <a href="#" class="next" style="display:inline-block">Next &raquo;</a>
                  </td>
                </tr>

                <tr>

                <td class="p-3" style=" max-width: 200px;font-size: 12px;padding: 4px; font-weight: bold;border: 1px solid #bcbcbc;
                  ">
                  <span>
                  1) インクラインダンベルベンチプレス( 背中 )    備品: ダンベル ( 〇kg 〇回 〇 % )

                  </span>
                </td>

                </tr>
                <tr>

                <td class="p-3" style=" max-width: 200px;font-size: 12px;padding: 4px; font-weight: bold;border: 1px solid #bcbcbc;
                  ">
                  <span>
                  2) インクラインダンベルベンチプレス( 背中 )    備品: ダンベル ( 〇kg 〇回 〇 % )

                  </span>
                </td>

                </tr>
                <tr>

                <td class="p-3" style=" max-width: 200px;font-size: 12px;padding: 4px; font-weight: bold;border: 1px solid #bcbcbc;
                  ">
                  <span>
                  3) インクラインダンベルベンチプレス( 背中 )    備品: ダンベル ( 〇kg 〇回 〇 % )

                  </span>
                </td>

                </tr>
                <tr>

                <td class="p-3" style=" max-width: 200px;font-size: 12px;padding: 4px; font-weight: bold;border: 1px solid #bcbcbc;
                  ">
                  <span>
                  4) インクラインダンベルベンチプレス( 背中 )    備品: ダンベル ( 〇kg 〇回 〇 % )

                  </span>
                </td>

                </tr>
               

              </table>
            </div>
            <div class="column">
                <table style="border:1px solid #eee;">
                  <tr>
                    <th>メイン</th>
                    <th>コース</th>
                    <th>備品</th>
                  </tr>
                  <tr>
                    <td style="width: 150px" class="p-1">
                        <select class="main"  name="main[]" style="width: 100%;">
                            <option value="">--select-- </option>
                            @if($body_part)
                              @foreach($body_part as $val)
                                <option value="{{ $val->body_part}}" id="{{ $val->body_part}}">{{ $val->body_part}}</option>
                              @endforeach
                            @endif
                        </select>
                    </td>
                    <td style="width: 150px" class="p-1">
                      <select class=" course" style="width: 100%;" name="course[]" required="required">
                          <option value="">--select--</option>
                      </select>
                    </td>
                    <td style="width: 150px" class="p-1">
                        <select class=" equipment" style="width: 100%;" name="equipment[]" >
                            <option value="">--select--</option>
                        </select>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 150px">
                      <p class="" style="font-size: 12px;font-weight: bold;color: black;">Set 1</p>
                      <input style="width: 40px;height: 19px;" name="set1_kg[]" class="set1_kg kg  m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>KG</span>
                      <input style="width: 40px;height: 19px;" name="set1_times[]" class="set1_times times kg m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required" /><span>回</span>

                    </td>
                    <td style="width: 150px">

                      <p style="font-size: 12px;font-weight: bold;color: black;">Set 2</p>
                      <input style="width: 40px;height: 19px;" name="set2_kg[]" class="set2_kg set1  kg  m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>KG</span>
                      <input style="width: 40px;height: 19px;" name="set2_times[]" class="set2_times times kg p-1 m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  required="required"/><span>回</span>
                   
                      
                    </td>
                    <td>
                      <p style="font-size: 12px;font-weight: bold;color: black;">Set 3</p>
                      <input style="width: 40px;height: 19px;" name="set3_kg[]" class="set3_kg kg  m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>KG</span>
                      <input style="width: 40px;height: 19px;" name="set3_times[]" class="set3_times times kg  m-1"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>回</span>

                    </td>
                  </tr>
                  <tr>
                      <td>
                        
                      </td>
                      <td>
                        
                      </td>
                      <td>
                        <button class="btn btn-sm btn-primary" onclick="cloneList()"> メニューに追加</button>
                      </td>
                  </tr>
                  <tr>
                    <table>
                      <tr>
                          <ul id="sortable">
                          <li class="ui-state-default m-2" id="list1" style="display:none">
                            
                            <span style="border: 1px solid #c8c6c6;padding: 2px;margin: 3px;">
                           インクラインダンベルベンチプレス( 背中 )    備品: ダンベル ( 〇kg 〇回 〇 % )
                            </span>
                          </li>
                          <li class="ui-state-default m-2" id="list2" style="display:none">
                            
                            <span style="border: 1px solid #c8c6c6;padding: 2px;margin: 3px;">
                           インクラインダンベルベンチプレス( 背中 )    備品: ダンベル ( 〇kg 〇回 〇 % )
                            </span>
                          </li>
                          <li class="ui-state-default m-2" id="list3" style="display:none">
                            
                            <span style="border: 1px solid #c8c6c6;padding: 2px;margin: 3px;">
                           インクラインダンベルベンチプレス( 背中 )    備品: ダンベル ( 〇kg 〇回 〇 % )
                            </span>
                          </li>
                          <li class="ui-state-default m-2" id="list4" style="display:none">
                            
                            <span style="border: 1px solid #c8c6c6;padding: 2px;margin: 3px;">
                           インクラインダンベルベンチプレス( 背中 )    備品: ダンベル ( 〇kg 〇回 〇 % )
                            </span>
                          </li>

                          </ul>
                      </tr>
                    </table>
                  </tr>

                </table>
            </div>
  
          </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  <!--- //////////// ---->
    @php
      $date = Carbon\Carbon::parse($schedule->date)->format('Y/m/d');
      $hour = Carbon\Carbon::parse($schedule->time)->addHours(1)->format('H:i:s');

      if($hour == "00:00:00"){
        $hour = "24:00:00";
      }
    @endphp
    <input type="hidden" id="clock_value" value='{{ $date." ".$hour }}'>
    <input type="hidden" id="local_user" >
    <input type="hidden" id="remote_user" >

<button type="button" class="nav-link active__" data-toggle="modal" data-target="#exampleModalScrollable" style="color:white;position: absolute;top: 35%;right: 0;"> 実績 </button>
<button type="button" class="nav-link active__" data-toggle="modal" data-target=".bd-example-modal-lg2" style="color:white;position: absolute;top: 45%;right: 0"> 説明 </button>
<button type="button" class="nav-link active__" data-toggle="modal" data-target=".bd-example-modal-lg3" style="color:white;position: absolute;top: 55%;right: 0"> コメント </button>

<div class="card monitor_modal" style="height: 70px;width:70px;position: fixed;bottom:0px;right:0px;">
  <div class="card-body" >
      <span><img src="{{ asset('images/open.png')}}"></span>
  </div>
</div>

<div id="clock"></div>

@endsection
@section('footer_css_js')
<script src='{{ asset('asset_v2/js/sweetalert2@10.js')}}'></script>
<script src='{{ asset('asset_v2/js/jquery.countdown.min.js')}}'></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<style>
  

.modal.left .modal-dialog {
  position:fixed;
  right: 0;
  margin: auto;
  width: auto;
  height: 100%;
  -webkit-transform: translate3d(0%, 0, 0);
  -ms-transform: translate3d(0%, 0, 0);
  -o-transform: translate3d(0%, 0, 0);
  transform: translate3d(0%, 0, 0);
}

.modal.left .modal-content {
  height: 100%;
  overflow-y: auto;
}

.modal.right .modal-body {
  padding: 15px 15px 80px;
}

.modal.right.fade .modal-dialog {
  left: -320px;
  -webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
  -moz-transition: opacity 0.3s linear, left 0.3s ease-out;
  -o-transition: opacity 0.3s linear, left 0.3s ease-out;
  transition: opacity 0.3s linear, left 0.3s ease-out;
}

.modal.right.fade.show .modal-dialog {
  right: 0;
}
.swal2-container.swal2-backdrop-show, .swal2-container.swal2-noanimation{
  background:none !important;
}
#rightModal .modal-dialog-slideout {
  min-height: 100%;
  margin: 0 0 0 auto;
  background: #fff;
}

.modal.fade .modal-dialog.modal-dialog-slideout {
  -webkit-transform: translate(100%, 0)scale(1);
  transform: translate(100%, 0)scale(1);
}

.modal.fade.show .modal-dialog.modal-dialog-slideout {
  -webkit-transform: translate(0, 0);
  transform: translate(0, 0);
  display: flex;
  align-items: stretch;
  -webkit-box-align: stretch;
  height: 100%;
}

.modal.fade.show .modal-dialog.modal-dialog-slideout .modal-body {
  overflow-y: hidden;
  overflow-x: hidden;
}
/*html {
  overflow: hidden;
  height: 100%;
}
body {
  overflow: auto;
  height: 100%;
}

.modal-open {
 overflow: auto; 
}*/
body.modal-open {
    overflow: auto;
}
body.modal-open[style] {
    padding-right: 0px !important;
}

.modal::-webkit-scrollbar {
    width: 0 !important; 
}




</style>
<script>
function getdayFromNow() {
    // return new Date('2021-02-09 10:00:00');
    // 2021-02-09T10:00:00
    // console.log(new Date(new Date().valueOf() + 15 * 24 * 60 * 60 * 1000));
    return new Date('2021/03/09 12:00:00');

  }

  var $clock = $('#clock');

  // $clock.countdown('2021/03/09 09:56:00', function(event) {
  //   $(this).html(event.strftime('%M:%S'));
  //   if (event.type === 'finish.countdown') {
  //       console.log('hello');
  //       alert("the event is finish");
  //       window.location.href = "{{ route('traineelist') }}";
  //   }
  // });
console.log("----server provided time :-----"+ $("#clock_value").val());


var localtime =   moment.tz(new Date($("#clock_value").val()), "Asia/Tokyo");
console.log("----local  time :-----"+ localtime.toDate('ja', { timeZone: 'Asia/Tokyo' }));
var exactTime = moment(localtime.toDate()).format('YYYY/MM/DD HH:mm:ss');


console.log('The exact time: '+exactTime);

  $('#clock').countdown(exactTime)
    .on('update.countdown', function(e) {
  // $(this).html(event.strftime('%D days %H:%M:%S'));
        $(this).html(e.strftime('<div id="countdown_container"><div class="countdown_wrap hours">%H:%M:%S</div></div>'));
    })
    .on('finish.countdown', function(e) {
        console.log('hello');
        // alert(e.strftime('%M:%S'));
        alert('Your course time has finished');
        window.location.href = "{{ route('traineelist') }}";


    });

    

  </script>
<script src="https://meet.jit.si/external_api.js"></script>
<script>
       // TOOLBAR_BUTTONS: [
       //      'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
       //      'fodeviceselection', 'hangup', 'profile', 'chat', 'recording',
       //      'livestreaming', 'etherpad', 'sharedvideo', 'settings', 'raisehand',
       //      'videoquality', 'filmstrip', 'invite', 'feedback', 'stats', 'shortcuts',
       //      'tileview', 'videobackgroundblur', 'download', 'help', 'mute-everyone',
       //      'e2ee', 'security'
       //  ],
       // jitsi start
       // jitsi start
    var domain = "meet.jit.si";

    var options = {
      roomName: "training_{{ $schedule->id}}",
      // width: '%',
      // height: 100%,
      parentNode: document.querySelector('#meet'),
      interfaceConfigOverwrite:{requireDisplayName: false},
      configOverwrite: {
          disableDeepLinking: true,
          prejoinPageEnabled: false
          
      },
      interfaceConfigOverwrite: {
     TOOLBAR_BUTTONS: [
            'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
            'fodeviceselection', 'hangup', '', 'chat', '',
            '', '', '', '', '',
            '', 'filmstrip', '', '', '',
            'tileview', '', '', '', '',
            '', ''
        ],
        filmStripOnly: true
      }
    }

    var api = new JitsiMeetExternalAPI(domain, options);
        api.on('videoConferenceLeft', () => {
           console.log('alert');
            window.location.href = "{{ route('trainingfinished',$schedule->id) }}";
    
    });
    api.executeCommand('subject', '');
    api.executeCommand('displayName', '{{ isset($display_name) ? $display_name : ''}}');
       // jitsi end
       // jitsi end
        var x=api.getParticipantsInfo();
        console.log("pparticipants: " +JSON.stringify(x));
        api.addEventListener('videoConferenceJoined' , function(abcd){

        $("#local_user").val(abcd.id );
        

        console.log("pparticipants: " +JSON.stringify(abcd));
        });
        api.addEventListener('participantJoined' , function(abcd){
          // var x=api.getParticipantsInfo();
          $("#remote_user").val(abcd.id );
        });
        $(document).on('click', '.user', function() {
          console.log('user interface');
          api.setLargeVideoParticipant($("#remote_user").val());

          // api.executeCommand('setLargeVideoParticipant',$("#remote_user").val());

        });
        $(document).on('click', '.trainer', function() {
          console.log('trainer interface');
          api.setLargeVideoParticipant($("#local_user").val());
          // api.executeCommand('setLargeVideoParticipant',$("#local_user").val());
        });
        $(document).on('click', '.screenshare', function() {
          api.executeCommand('toggleShareScreen');

        });
        
      // for upazila
  $(document).on('change', '.main', function() {


  // $('.main').on('change', function() {
    // console.log($(this option:selected).text());
    var body_part =  $(this).find('option:selected').text();
    // console.log(main);
    var id = $(this).parent().closest('.performance').attr('id');
    // console.log(id);
    $.ajax
      ({
        type: "POST",
        url: '{{ route('getcourse')}}',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { 'body_part': body_part },
        cache: false,
        success: function (data) {
          // console.log(data.location);
          console.log(id);
          console.log($(this).find('.course'));

          // console.log($('.course','#'.id));

          $('.course','#'+id).empty();
          $('.equipment','#'+id).empty();
           $('.set1_kg','#'+id).empty();
          $('.set1_times','#'+id).empty();

          $('.set2_kg','#'+id).empty();
          $('.set2_times','#'+id).empty();

          $('.set3_kg','#'+id).empty();
          $('.set3_times','#'+id).empty();

          $('.equipment','#'+id).empty();
          

          // $('#equipment').append($('<option>', { value: '', text: '--select--' }));
          $('.course','#'+id).append($('<option>', { value: '', text: '--select--' }));
          $('.equipment','#'+id).append($('<option>', { value: '', text: '--select--' }));
          $.each(data, function (i, item) {
            // console.log(item.upazila_name);
            $('.course','#'+id).append($('<option>', { value: item.id, text: item.course_name }));
            $('.equipment','#'+id).append($('<option>', { value: item.equipment_id, text: item.equipment_name }));
          });
        },
        dataType: "json"
      });
  });

  $(document).on('change', '.course', function() {
    // console.log($("#course option:selected").value());
    var course = $(this).find('option:selected').val();
    console.log(course);
    var id = $(this).parent().closest('.performance').attr('id');

    $.ajax
      ({
        type: "POST",
        url: '{{ route('getcoursedetails')}}',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { 'course': course },
        cache: false,
        success: function (data) {


          // console.log(data.location);
          // console.log(data);
          $('.set1_kg','#'+id).empty();
          $('.set1_times','#'+id).empty();

          $('.set2_kg','#'+id).empty();
          $('.set2_times','#'+id).empty();

          $('.set3_kg','#'+id).empty();
          $('.set3_times','#'+id).empty();

          $('.equipment','#'+id).empty();
          $('.equipment','#'+id).append($('<option>', { value: '', text: '--select--' }));
          
          $.each(data, function (i, item) {
            // console.log(item.upazila_name);
            let s1= item.set_1.split("_");$('.set1_kg','#'+id).val(s1[0]);$('.set1_times','#'+id).val(s1[1]);
            let s2= item.set_2.split("_");$('.set2_kg','#'+id).val(s2[0]);$('.set2_times','#'+id).val(s2[1]);
            let s3= item.set_3.split("_");$('.set3_kg','#'+id).val(s3[0]);$('.set3_times','#'+id).val(s3[1]);
            $('.equipment','#'+id).append($('<option>', { value: item.equipment_id, text: item.equipment_name }));
          });
        },
        dataType: "json"
      });
  });
  $(document).ready(function(){
      $( "#sortable" ).sortable();
      $( "#sortable" ).disableSelection();

      $(window).scroll(function () {
        $('.dashboard_menu').removeClass('menu_fixed');
            $('.dashboard_menu').removeClass('animated');
            $('.dashboard_menu').removeClass('fadeInDown');
    });

    var cloneCount = parseInt($('#counter').val());
    // let r= $('<input type="button" value="削除" class="m-1 remove btn btn-danger"/>');

   $(".add_button").click(function(){
      let r= $('<input type="button" value="削除" class="m-1 remove btn btn-danger"/>');
      let id = 'performance'+ cloneCount++;
      $("#performance").clone().attr('id',id).insertAfter($('[id^=performance]:last'));
        $("#"+id).append(r);
   }); 


   $("#f_btn").click(function(){
        
         var form = $("#feed_back_form");
          var url = form.attr('action');
          
          $.ajax({
                 type: "POST",
                 url: url,
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                 data: form.serialize(), // serializes the form's elements.
                 success: function(data)
                 {
                     Swal.fire({
                        icon: 'success',
                        title: 'Course feedback set successfully ',
                        showConfirmButton:true
                      })
                      // location.reload();
                 }
          });
    
   });

    $("#submit_performance").click(function(){
        
         var form = $("#performance_form");
          var url = form.attr('action');
          
          $.ajax({
                 type: "POST",
                 url: url,
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                 data: form.serialize(), // serializes the form's elements.
                 success: function(data)
                 {
                     Swal.fire({
                        icon: 'success',
                        title: 'Course data set successfully ',
                        showConfirmButton:true
                      })
                      // location.reload();
                 }
          });

        //  var lngtxt=(form.find('input[name="course[]"]').val()).length;
        // console.log(lngtxt);
        // if (lngtxt==0){
        //     alert('please enter value');
        //     return false;
        // }else{
        //     //submit
        // }
    
   }); 

   $(".monitor_modal").click(function(){
      $("#rightModal").modal();
   });

});
  $(document).on("click", ".remove", function() {
       $(this).parent().remove(); 
});

  function showExplanation(text,body_part,main,sub,way,motion){
        Swal.fire({
           icon: '',
           title: '説明',
           html: " <br> <b> サマリ:</b> "+text
           +" <br> <br> 体の部分: "+body_part
           +" <br> <br> メイン: "+main
           +" <br> <br> サブ: "+sub
          + " <br> <br> <b>方法:</b> "+way
          + " <br> <br> <b>モーション:</b> "+motion,
           showConfirmButton:false
         })
  }
  var incr=1;
  function cloneList(){
    $("#list"+incr).show();
    incr++;
  }
  function showGif(image){
        Swal.fire({
           icon: '',
           title: 'コースイメージ',
           html: " <img alt='Image loading...' src='"+image
                 +"' >",
           showConfirmButton:false
         })
  }
  </script>

@endsection 