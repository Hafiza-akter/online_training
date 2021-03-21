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
    top: 20%;
    left: 5%;
    transform: translateX(-50%) translateY(-50%);
    color: red;
    font-size: 2rem;
   


}

</style>
<section class="review_part gray_bg section_padding" style="margin-top:-74px">
{{--     <div class="row justify-content-center">
        <div class="col-md-8 col-xl-6">
            <div class="section_tittle">
                <h3>トレーニングページ</h3>
            </div>
        </div>
    </div> --}}

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div id="meet"></div>
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
                        <label class="col-sm-2 col-form-label">メイン</label>
                            <select class="form-control main" style="width: 100%;" name="main[]" >
                                <option value="">--select-- </option>
                                @if($main)
                                  @foreach($main as $val)
                                    <option value="{{ $val->main}}" id="{{ $val->main}}">{{ $val->main}}</option>
                                  @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-4">
                        <label class="col-sm-2 col-form-label">コース</label>
                            <select class="form-control course" style="width: 100%;" name="course[]" required="required">
                                <option value="">--select--</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                        <label class="col-sm-2 col-form-label">備品</label>
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
              <a  class="nav-link active__ m-1 submit_performance" id="submit_performance" style="color: white;">送信する</a>
            
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
                        <label class="col-sm-2 col-form-label">メイン</label>
                            <select class="form-control main" style="width: 100%;" name="main[]" >
                                @if($main)
                                  @foreach($main as $val)
                                    <option value="{{ $val->main}}" id="{{ $val->main}}" {{$val->main ==  $coursesData->main ? 'selected' : '' }}>{{ $val->main}}</option>
                                  @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-4">
                        <label class="col-sm-2 col-form-label">コース</label>
                            <select class="form-control course" style="width: 100%;" name="course[]" required="required">
                                @foreach(getCourseDataMain($coursesData->main) as $v)
                                   <option value="{{$v->id}}" {{ $value->course_id == $v->id ? 'selected' : ''}}>{{ $v->course_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                        <label class="col-sm-2 col-form-label">備品</label>
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
                <a  href="#" class="nav-link active__ m-1 submit_performance" id="submit_performance" style="color: white;">送信する</a>
              
              </div>
            </form>
            @endif
            <!-- // end edit mode -->
          </div>
         {{--  <div class="modal-footer row justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="nav-link active__ submit_performance" style="color: white;">Submit</button>
          
          </div> --}}
        </div>
      </div>
      </div>
     <input type="hidden" value="{{ $exerciseData ? count($exerciseData->getExerciseData) : 1}}" id="counter">
  

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
                      <input type="radio" name="course_list" id="course_list_{{ $val->id}}" onclick="showExplanation(`{{ $val->summary}}`,`{{ $val->sub}}`,`{{ $val->way}}`,`{{ $val->motion}}`)">  
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
            <button type="button" class="nav-link active__" style="color: white;">送信する</button>
          </div> --}}
        </div>
      </div>
    </div>

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
          <button type="button" class="btn btn-secondary m-1" data-dismiss="modal">Close</button>
          <a type="submit" href="#" class="nav-link active__ m-1" id="f_btn" style="color: white;">Submit</a>
        </div>
          </form>
        </div>
       
      </div>
    </div>
    </div>
    @php
      $date = Carbon\Carbon::parse($schedule->date)->format('Y/m/d');
      $hour = Carbon\Carbon::parse($schedule->time)->format('H:i:s');

    @endphp
    <input type="hidden" id="clock_value" value='{{ $date." ".$hour }}'>

<button type="button" class="nav-link active__" data-toggle="modal" data-target="#exampleModalScrollable" style="color:white;position: absolute;top: 35%;right: 0;"> 実績 </button>
<button type="button" class="nav-link active__" data-toggle="modal" data-target=".bd-example-modal-lg2" style="color:white;position: absolute;top: 45%;right: 0"> 説明 </button>
<button type="button" class="nav-link active__" data-toggle="modal" data-target=".bd-example-modal-lg3" style="color:white;position: absolute;top: 55%;right: 0"> コメント </button>

<div id="clock"></div>

@endsection
@section('footer_css_js')
<script src='{{ asset('asset_v2/js/sweetalert2@10.js')}}'></script>
<script src='{{ asset('asset_v2/js/jquery.countdown.min.js')}}'></script>

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

var localtime =   moment.tz($("#clock_value").val(), "Asia/Tokyo");
console.log("----local  time :-----"+ localtime.toDate());
var exactTime = moment(localtime.toDate()).format('YYYY/MM/DD HH:mm:ss');


console.log('The exact time: '+exactTime);

  $('#clock').countdown(exactTime)
    .on('update.countdown', function(e) {
  // $(this).html(event.strftime('%D days %H:%M:%S'));
        $(this).html(e.strftime('<div id="countdown_container"><div class="countdown_wrap hours">%M:%S</div></div>'));
    })
    .on('finish.countdown', function(e) {
        console.log('hello');
        alert(e.strftime('%M:%S'));
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
      width: '100%',
      height: 640,
      parentNode: document.querySelector('#meet'),
      interfaceConfigOverwrite:{requireDisplayName: false},
      configOverwrite: {
          disableDeepLinking: true,
          prejoinPageEnabled: false
          
      },
      interfaceConfigOverwrite: {
     TOOLBAR_BUTTONS: [
            'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
            'fodeviceselection', 'hangup', 'profile', 'chat', 'recording',
            'livestreaming', 'etherpad', 'sharedvideo', 'settings', 'raisehand',
            'videoquality', 'filmstrip', 'feedback', 'stats', 'shortcuts',
            'tileview', 'videobackgroundblur', 'download', 'help', 'mute-everyone',
            'e2ee', 'security'
        ],
        filmStripOnly: true
      }
    }

    var api = new JitsiMeetExternalAPI(domain, options);
        api.on('videoConferenceLeft', () => {
           console.log('alert');
            window.location.href = "{{ route('trainingfinished',$schedule->id) }}";
    
    });
    // api.executeCommand('subject', '');
    // api.executeCommand('displayName', '');
       // jitsi end
       // jitsi end

      // for upazila
  $(document).on('change', '.main', function() {


  // $('.main').on('change', function() {
    // console.log($(this option:selected).text());
    var main =  $(this).find('option:selected').text();
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
        data: { 'main': main },
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

});
  $(document).on("click", ".remove", function() {
       $(this).parent().remove(); 
});

  function showExplanation(text,sub,way,motion){
        Swal.fire({
           icon: '',
           title: '説明',
           html: " <br> <b> サマリ:</b> "+text+" <br> <br> サブ: "+sub
          + " <br> <br> <b>方法:</b> "+way
          + " <br> <br> <b>モーション:</b> "+motion,
           showConfirmButton:false
         })
  }
  </script>

@endsection 