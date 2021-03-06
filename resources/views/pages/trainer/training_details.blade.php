@extends('master_dashboard')
@section('title','trainee trainerlist')
@section('header_css_js')
<link href='{{ asset('asset_v2/css/fullcalendar_main.min.css')}}' rel='stylesheet' />
<script src='{{ asset('asset_v2/js/fullcalendar_main.min.js')}}'></script>

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
.section_padding{
    padding: 76px 0;
}
.table td{
  border:none;
}
.f13{
  font-size: 13px;
}
.f11{
  font-size: 11px;
}
.static{
  background: green !important;
}
.remove{cursor: pointer;}
 #clock {
    position: absolute;
    top: 20%;
    left: 1%;
    /*transform: translateX(-50%) translateY(-50%);*/
    color: red;
    font-size: 1rem;
}
   


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
.combodate{
  margin:2px;
  padding:2px;
}
.row{
  margin: 0 !important;
  padding: 0 !important;
}
.ld{
  position: absolute;
  top:50%;
  left:50%;
  display:none;
}
.disabledDiv {
    pointer-events: none;
    opacity: 0.4;
}
.tblue{
  background: blue !important;
  opacity: 1 !important;
  color:white !important;
  border: 1px solid #ddd;
}
.tred{
  background: red !important;
  color:white !important;

}
.fc .fc-bg-event{
opacity: 1 !important;
}
.fc-event-time{
  display:none;
}
</style>
<section class="review_part gray_bg section_padding pb-0" style="overflow: hidden;">


<div class="row  px-0 mx-0">
      <div class="col-sm-12 col-md-4  col-lg-4 col-xl-4 px-0 mx-0" style="height: calc(100vh - 82px)">
        <div id="meet" style="height:28vh;width: 100%;"></div>
        <div id="clock"></div>
           <ul class="list-group list-group-horizontal mx-auto jitsi_trainer_item mb-2">
            <li  class="list-group-item pointer col user" >

              <span><img src="{{ asset('images/user_camera.png')}}"></span>

            </li>
            <li class="list-group-item pointer col trainer">
              <span><img src="{{ asset('images/camera.png')}}"></span>


            </li>
            <li class="list-group-item pointer col screenshare" >
              <span><img src="{{ asset('images/share.png')}}"></span>

            </li>
            <li class="list-group-item pointer col" onclick="$('.bd-example-modal-lg4').modal()">
                    <span><img src="{{ asset('images/gif.png')}}"></span>

            </li>
            <li class="list-group-item pointer col" onclick="show_calendar()">
                    <span><img src="{{ asset('images/cl.png')}}"></span>
            </li>
          </ul>

      <div class="col-sm-12 col-md-12  col-lg-12 col-xl-12 mx-0 px-0  border border-primary">
        <div class="card p-2">
           <button class="float-right btn btn-sm btn-primary ml-2 fetchExerciseData f11"  style="position: absolute;right: 0px;z-index: 1;"> スタート</button>
          <button class="float-right btn btn-sm btn-danger save_start f11" disabled="disabled"  style="position: absolute;right: 0px;top:37px;z-index: 1;"> 記録して次へ</button>

        <div class="row ml-2 mb-1 f11" id="exercise_form_2">
        </div>
          <div class="row ml-2 mb-1 " id="exercise_form">

            <div class="col " data-course_id="">
                <label class="f11">コース</label>
                <p id="_label_course" class="f11"></p>
            </div>
            {{--  <div class="col-sm-4 ">
                <label class="col-form-label">メイン</label>
                <p id="_label_body_part"></p>
            </div> --}}
             <div class="col ">
                <label class="f11">備品</label>
                <p id="_label_equipment" class="f11"></p>
            </div>

          </div>

          <div class="row ml-2 mb-1">
            <div class="col">
                <label class="col-form-label">コメント</label><br>
                <textarea class="form-control f11" id="exercise_comment" style="height:35px"></textarea>
            </div>

            <div class="col pr-0">
                <label class="col-form-label">Set</label><br>
              <input  style="width:30px" id="set1_kg" class="set1_kg kg p-0 m-0 f11" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>KG</span>
              <input  style="width:30px" id="set1_times" class="set1_times times f11 kg p-0 m-0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required" /><span>回</span>
              <input  style="width:30px" id="efficiency" class="set1_efficiency f11 times kg p-0 m-0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required" /><span>%</span>
            </div>
          </div>


        </div>
      </div>

       <div class="col-sm-12 col-md-12  col-lg-12 col-xl-12 mx-0 px-0  border" style="">
        <div class="card p-2 mt-2" style="height:30vh;">

          <div class="row ml-2 mb-1 ">

            <div class="col " data-course_id="">
              <span style="position: absolute;right: 0px;">
                <input  style="width:30px"  class=" kg p-0 m-0 f13" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>%</span>
              </span>   

              <span style="position: absolute;right: 0px;top:33px;">
                  <button class="btn btn-secondary btn-sm btn-disabled">Explanation</button>
              </span>              
                <label class="col-form-label">センサー</label>
                 <p class="text-left"> Graph </p>
            </div>
          

          </div>




        </div>
      </div>
          {{-- <div class="row justify-content-center card"> --}}
          
            {{--<div class="col text-center">
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
              <div class="card m-1"  onclick="show_calendar()"style="display:inline-flex;height: 80px;width:80px">
                <div class="card-body" >
                    <span><img src="{{ asset('images/cl.png')}}"></span>

                </div>
              </div>
              
            </div> --}}


        {{-- </div> --}}
      </div>
      <div class="col px-0 mx-0 mx-0 px-0 text-center" style="height: calc(100vh - 82px);overflow: auto;">
        <div class="col-sm-12  mx-0 text-center p-3 card" >
          <button class="btn btn-md btn-primary btn-outline btn-block copy_list mt-3 ">前回のリストをコピー</button>
          <button class="btn btn-md btn-secondary btn-outline btn-block mt-3">セットメニューからコピー</button>
          <div class="mb-4 mt-4">
            <div class="row p-2 mx-auto" style="display:inline-block;" >

            <span class="prev"><i class="fas fa-chevron-circle-left" style="font-size:22px"></i></span>
              <input type="text" id="list_date" data-format="YYYY-MM-DD" data-template="YYYY MMM D" name="list_date" >
            <span class="next"><i class="fas fa-chevron-circle-right " style="font-size:22px"></i></span>

            
            </div>
          </div>
        </div>
        <div class="col-sm-12  mx-0 text-center p-3" >
          <div id="previous_data">
           
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-4  col-lg-4 col-xl-4  performance mx-0 px-0 card" id="performance" style="height: calc(100vh - 82px);overflow: auto;" >
        <div class=" p-3">
          <div class="row">
              <div class="col-sm-6 px-1">
                  {{-- <label class="col-form-label">メイン</label> --}}
                  <label class="">メイン</label>
                  {{-- <select class="form-control main" style="width: 100%;" name="main[]" > --}}
                  <select class=" main" style="width: 100%;" name="main[]" >
                      <option value="">--select-- </option>
                      @if($body_part)
                        @foreach($body_part as $val)
                          <option value="{{ $val->body_part}}" id="{{ $val->body_part}}">{{ $val->body_part}}</option>
                        @endforeach
                      @endif
                  </select>
              </div>
              <div class="col-sm-6 px-1">
                  <label class="">コース</label>
                  <select class=" course" style="width: 100%;" name="course[]" required="required">
                      <option value="">--select--</option>
                  </select>
              </div>
          </div>
          <br>
          <div class="row">
            <div class="col-sm-6 px-1">
                <label class="">備品</label>
                    <select class="equipment" style="width: 100%;" name="equipment[]" >
                        <option value="">--select--</option>
                    </select>
            </div>
            <div class="col-sm-6 px-1">
                <label class="">Set</label><br>
              <input  style="width:30px;height:22px" name="set1_kg[]" class="set1_kg kg p-0 m-0 f13" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>KG</span>
              <input  style="width:30px;height:22px" name="set1_times[]" class="set1_times times kg p-0 m-0 f13" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required" /><span>回</span>
              {{-- <input  style="width:30px" name="efficiency[]" class="set1_efficiency times kg p-1 m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required" /><span>%</span> --}}
            </div>
          </div>

          <div class="row ">
            <div class="col-sm-12">
              <button class="float-right btn btn-primary add_button f13 mt-1" disabled="disabled" > メニューに追加</button>
            </div>
          </div>

          <div class="row mb-1 mt-3" id="dashboard">
            <div class="col-sm-12 px-0">

              <div class="table-responsive">
                <table class="table table-striped">
                  <tbody id="menue_finished" class="f13 saved">
                  </tbody>
                </table>

                <table class="table table-striped">
                  <tbody id="menue_add" class="f13 running">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
        </div>
      </div>

</div>

</section>

  

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

<!-- simple course modal with gif -->
    {{-- <div class="modal fade left bd-example-modal-lg5" tabindex="-1" role="dialog" aria-labelledby="bd-example-modal-lg5" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content"> --}}

   <div class="modal fade left bd-example-modal-lg5"  >
      <div class="modal-dialog modal-lg cals" style="width:90vw;">
        <div class="modal-content" >

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                  <div class="spinner-border text-primary ld">
                  <span class="sr-only">Loading...</span>
                  </div>
                <div id='calendar'></div>
                <input type="hidden" id="schedule" value="{{ json_encode(jitsi_trainer_calendar($schedule->trainer_id))}}">

            </div>
          </div>
        </div>
      </div>
      <div class="modal fade left bd-example-modal-lg6"  >
      <div class="modal-dialog modal-lg cals" style="width:90vw;">
        <div class="modal-content" >

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="md">

            </div>
          </div>
        </div>
      </div>
                <input type="hidden" id="occupiedList" value="{{ json_encode(getOccupiedList($schedule->user_id))}}">

<!-- ///////////////-->

    @php
      $date = Carbon\Carbon::parse($schedule->date)->format('Y/m/d');
      $hour = Carbon\Carbon::parse($schedule->time)->addHours(1)->format('H:i:s');

      if($hour == "00:00:00"){
        $hour = "24:00:00";
      }
      $lastDateNode=0;
      if(isset($lastDate)){
        $lastDateNode = count($lastDate);
      }
    @endphp
    <input type="hidden" id="clock_value" value='{{ $date." ".$hour }}'>
    <input type="hidden" id="local_user" >
    <input type="hidden" id="remote_user" >
    <input type="hidden" id="lastDateNode" value="{{ $lastDateNode}}" >
    <input type="hidden" id="exerciseDateList" value="{{ json_encode($lastDate,true)}}" >






@endsection
@section('footer_css_js')
<script src='{{ asset('asset_v2/js/sweetalert2@10.js')}}'></script>
<script src='{{ asset('asset_v2/js/jquery.countdown.min.js')}}'></script>
<script src='{{ asset('asset_v2/js/combodate.js')}}'></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

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
// showing previous exercise data//
$(function(){


  var allExercise = JSON.parse($('#exerciseDateList').val());
  var totalCount = allExercise.length;
  var counterD = totalCount;

  if(totalCount == 0){
    var initialDate = moment().format("YYYY-MM-DD");
  }else{
  var initialDate = moment(allExercise[totalCount-1]['created_at']).format("YYYY-MM-DD");
  }
  calling_ajax_previous_data(initialDate);

$('#list_date').combodate('setValue',initialDate);
  $('.prev').click(function(){

    console.log("Counter:" +  counterD);


    counterD--;
    console.log("index:" +  counterD);

    if(counterD < 0 ){
          counterD=-1;
          prev_val=moment($('#list_date').combodate('getValue'), "YYYY-MM-DD").add(-1, 'days').format('YYYY-MM-DD');
    }else{
        prev_val=moment(allExercise[counterD]['created_at']).format('YYYY-MM-DD');
    }

    console.log("Previous val"+prev_val);

    $('#list_date').combodate('setValue',prev_val);
    calling_ajax_previous_data(prev_val);

  });
  $('.next').click(function(){
      console.log("Counter:" +  counterD);
      counterD++;
      console.log("index:" +  counterD);

  
     if(counterD >= totalCount ){
          counterD=totalCount;
          nex_val=moment($('#list_date').combodate('getValue'), "YYYY-MM-DD").add(1, 'days').format('YYYY-MM-DD');
    }else{
        nex_val=moment(allExercise[counterD]['created_at']).format('YYYY-MM-DD');
    }
    console.log("nexT val"+nex_val);
    $('#list_date').combodate('setValue',nex_val);
    calling_ajax_previous_data(nex_val);

  });
  $('.year,.month,.day').change(function(){
        curent_val=$('#list_date').combodate('getValue');
        calling_ajax_previous_data(curent_val);
  });
});

function calling_ajax_previous_data(date){
  var action="{{ route('previoustraininglist')}}";
  var method="POST";
  var data={
      'user_id' : {{ $schedule->user_id }},
      'trainer_id' : {{ $schedule->trainer_id }},
      'date':date
  };
  var div="previous_data";
  ajax_request(action,method,data,div);
}
function check_disable_add_menu_button(){
   let main=$('.main').find('option:selected').val();
      let course=$('.course').find('option:selected').val();
      let equipment=$('.equipment').find('option:selected').val();

      if(main != '' && course != '' & equipment != ''){
           $('.add_button').prop('disabled', false);

      }else{
           $('.add_button').prop('disabled', true);

      }
}
// showing previous exercise data//

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
            'fodeviceselection', 'hangup', '', '', '',
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
    //    // jitsi end
    //    // jitsi end
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

          let action={
            'type':'set_large_vedio_open',
            'id':$("#remote_user").val()
          };
          api.executeCommand('sendEndpointTextMessage', $("#remote_user").val(), action);

        });

        $(document).on('click', '.trainer', function() {

          let action={
            'type':'set_large_vedio_open',
            'id':$("#local_user").val()
          };

          api.setLargeVideoParticipant($("#local_user").val());

          api.executeCommand('sendEndpointTextMessage', $("#remote_user").val(), action);
          // api.executeCommand('setLargeVideoParticipant',$("#local_user").val());
        });
        $(document).on('click', '.screenshare', function() {
          api.executeCommand('toggleShareScreen');

        });
        
      // for upazila


  $(document).on('change', '.equipment', function() {
    check_disable_add_menu_button();
  });

  $(document).on('change', '.main', function() {
    check_disable_add_menu_button();

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
        check_disable_add_menu_button();

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
      var menueArray = [];
      $( "#menue_add" ).sortable();
      $( "#menue_add" ).disableSelection();

      $(window).scroll(function () {
        $('.dashboard_menu').removeClass('menu_fixed');
            $('.dashboard_menu').removeClass('animated');
            $('.dashboard_menu').removeClass('fadeInDown');
    });

    // var cloneCount = parseInt($('#counter').val());
    var cloneCount = 0;
    // let r= $('<input type="button" value="削除" class="m-1 remove btn btn-danger"/>');

   $(".add_button").click(function(){

      let main=$('.main').find('option:selected').text();
      let course=$('.course').find('option:selected').text();

      let id=$('.course').find('option:selected').val();
      // console.log(course);
      let equipment=$('.equipment').find('option:selected').text();
      let set1_times = $('.set1_times').val();
      let set1_kg = $('.set1_kg').val();
      // let set1_efficiency = $('.set1_efficiency').val();
      // <span class='fa-box"+id+"'></span>
      let html="<tr id='menue_"+id+"' data-course_id='"+id+"'>"+
        "<td> <span class='course_name'>" + course +" </span> <td>" +
        " 備品: <span class='equp'>" +equipment + "<span class='kg'>"+set1_kg+"</span> KG <span class='times'>"+set1_times+"</span> 回 " + "<span aria-hidden='true' class='remove float-right fa-2x text-danger' style='cursor:pointer'>×</span> </td>  "
        "</tr>";

      // let id = 'performance'+ cloneCount++;
      // $("#performance").clone().attr('id',id).insertAfter($('[id^=performance]:last'));
      //   $("#"+id).append(r);
      $('.course').val('');
      $('.main').val('');
      $('.equipment').val('');
      $('.set1_times').val('');
      $('.set1_kg').val('');
      $('.add_button').prop('disabled', true);

      $('#menue_add').prepend(html);
      removeBorder();
      menueUpdate();

      // save to cookies//



   }); 

   $(".copy_list").click(function(){

    $("#previous_data  table > tbody > tr").each(function(index, tr){
      // console.log(tr);
      let clone = $(tr).clone()
      $(clone).find("td:eq(1)").prepend('<span aria-hidden="true"  class=" remove float-right fa-2x text-danger" style="cursor:pointer">×</span> ');
      // .append('<span aria-hidden="true"  class=" remove float-right fa-2x text-danger" style="cursor:pointer">×</span> ');
              $('#menue_add').append(clone);

      // alert($(this).find('tr').html());
      // alert($(this).find('td').eq(0).text() + " " + $(this).find('td').eq(1).text() );
    });
    menueUpdate();


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
        
        $(this).closest('tr').remove();
         arrayRemove(menueArray, $(this).closest('tr').attr('id'));
         menueUpdate();

  });

  $(document).on("click", ".fetchExerciseData", function() {
    let courseId = $("#menue_add tr:first").data('course_id');

    if(!courseId){
      alert('Please create your menue first');
      return false;
    }

    console.log("CourseId:"+courseId);
   

    // var action="{{ route('getcoursedetails')}}";
    // var method="POST";
    // var data={
    //   'course' : courseId,
    //   'ajax_with_view' : 1
    // };
    // var div="exercise_form";
    // ajax_request(action,method,data,div);

    // arrayRemove(menueArray, $("#menue_add tr:first").attr('id'));

    // $("#"+trId).addClass('static');
    $('#menue_finished').append($("#menue_add tr:first"));
    $("#menue_finished tr:last").css('opacity','0.5');
    $("#menue_finished tr:last").find("td:eq(0)").css('border','none');
    $("#menue_finished tr:last").find("td:eq(1)").css('border','none');
    $("#menue_finished tr:last").css("background",'#fff');

    $("#menue_finished tr:last").addClass('border');
    $("#menue_finished tr:last").addClass('border-primary');
    // $("#menue_finished").find("span").remove();
    // $("#menue_finished tr:last").find("td:eq(0)").prepend('');
    // initialCall();
      setLastRowData();


    $(this).prop('disabled', true);
    $(".save_start").attr('disabled', false);

    showExerciseDashboard();

  });

  $(document).on("click", ".save_start", function() {

    if(!$('#set1_kg').val()){
        alert('Please insert your set values');
        $('#set1_kg').addClass('border border-danger');
        return false;
    }
    if(!$('#set1_times').val()){
        
        alert('Please insert your set values');
        $('#efficiency').addClass('border border-danger');
        return false;
    }
    if(!$('#efficiency').val()){
        alert('Please insert your set values');
        $('#efficiency').addClass('border border-danger');
        return false;
    }
    
      setLastRowData();
    // let td1="備品:" + $("#_label_equipment").text() + " " +$("#set1_kg").val()+" KG "+$("#set1_times").val()+" 回 " + $("#efficiency").val()+" %"; 
    // let td= $("#_label_course").text() + ' \n' 
    // +" ダンベルカール: "+$("#exercise_comment").val(); 


    // $("#menue_finished tr:last").find("td:eq(0)").text(td);
    // $("#menue_finished tr:last").find("td:eq(1)").text(td1);


    // let courseId = $("#menue_finished tr").find('fa-circle-notch').data('course_id');
    let courseId = $("#menue_finished tr:first").data('course_id');

    var action="{{ route('training_performance')}}";
    var method="POST";
    var data={
      'course' : courseId,
      'schedule_id' : {{ $schedule->id}},
      'set1_kg':$("#set1_kg").val(),
      'set1_times':$('#set1_times').val(),
      'efficiency':$('#efficiency').val(),
      'exercise_comment':$('#exercise_comment').val(),
    };
    var div="exercise_form_2";
    ajax_request(action,method,data,div);

    

    $("#menue_finished tr").removeClass("border");
    $("#menue_finished tr").removeClass("border-primary");
    $("#menue_finished tr").find("i").remove();
    $("#menue_finished tr").find("td:eq(0)").prepend('<i class="fas fa-check text-success fa-2x"></i>');
    $("#menue_finished tr").css('opacity','1');
    $("#menue_finished tr").css("background",'#f2f2f2');


   
    



    $("#exercise_comment,#efficiency,#set1_times,#set1_kg").val('');

    
    $(this).prop('disabled', true);
    $(".fetchExerciseData").prop('disabled', false);
    activeFirstMenue();
    showExerciseDashboard();

  });


  function menueUpdate(){
        initialCall();
        $( "#menue_add" ).sortable({
        cursor: "move",
        dropOnEmpty: true,
        start: function( event, ui ) {

         removeBorder();
          menueArray = $('#menue_add').sortable("toArray");
          for (var i = 0; i < menueArray.length; i++) {
            // $("#menue_add .fa-box"+menueArray[i]).html('');
            // $("#menue_add .fa-box"+menueArray[i]).html(i+1);
            console.log("Position: " + i + " ID: " + menueArray[i]);
          }


        console.log(" sort start: "+menueArray);
        },
        update: function(event, ui) {

          menueArray = $('#menue_add').sortable("toArray");
          for (var i = 0; i < menueArray.length; i++) {
            // $("#menue_add .fa-box"+menueArray[i]).html('');
            // $("#menue_add .fa-box"+menueArray[i]).html(i+1);
            console.log("Position: " + i + " ID: " + menueArray[i]);
          }

          console.log(" sort update: "+menueArray);
          activeFirstMenue();
        }

        
      });
      showExerciseDashboard();


      //-> cookies
      let tMenu = [];
      let tFinished = [];
      let exerciseId = [];

      $('#menue_add tr').each(function() {
          let c=0;
          if($("#menue_add").data('exercise_id')) {

            if(exerciseId.indexOf($(this).data('exercise_id')) === -1) {
              exerciseId.push($(this).data('exercise_id'));
            }
          }else{

          }

          if(tMenu.indexOf($(this).data('course_id')) === -1) {
              tMenu.push($(this).data('course_id'));
          }

      });

      $('#menue_finished tr').each(function() {
          if(tFinished.indexOf($(this).data('course_id')) === -1) {
              tFinished.push($(this).data('course_id'));
          }
      });

      let current_value=JSON.stringify(tMenu);
      let saved_value=JSON.stringify(tFinished);

      if(tMenu.length > 0){
        setCookie("session_"+'{{ $schedule->id}}'+"_current",current_value);
      }
      if(tFinished.length > 0){
        setCookie("session_"+'{{ $schedule->id}}'+"_save",saved_value);
      }
      //<- cookies
   }
  function initialCall(){
              menueArray = $('#menue_add').sortable("toArray");

         for (var i = 0; i < menueArray.length; i++) {
            // $("#menue_add .fa-box"+menueArray[i]).html('');
            // $("#menue_add .fa-box"+menueArray[i]).html(i+1);
            console.log("Position: " + i + " ID: " + menueArray[i]);
          }
          activeFirstMenue();
   }

   function activeFirstMenue(){

      

if(!$(".fetchExerciseData").is(":disabled")){

    $("#menue_add tr:first").find("td:eq(0)").css('border','none');
    $("#menue_add tr:first").find("td:eq(1)").css('border','none');
    $("#menue_add tr:first").css("background",'#fff');

    $("#menue_add tr:first").addClass('border');
    $("#menue_add tr:first").addClass('border-primary');

    let c=$("#menue_add tr:first").find('.course_name').text();
    let f=$("#menue_add tr:first").find('.comment_name').text();
    let e=$("#menue_add tr:first").find('.equp').text();
    let k=$("#menue_add tr:first").find('.kg').text();
    let t=$("#menue_add tr:first").find('.times').text();
    let effi=$("#menue_add tr:first").find('.effi').text();

    console.log(c);
    $("#set1_kg").val( parseInt(k) || '');
    $("#set1_times").val(parseInt(t) || '');
    $("#efficiency").val(parseInt(effi) || '');

    $("#_label_course").text(c);
    $("#_label_equipment").text(e);
    $("#exercise_comment").text(f);

    }

      // let td1=$("#set1_kg").val()+" KG "+$("#set1_times").val()+" 回 " + $("#efficiency").val()+" %"; 

      // $("#menue_finished tr:last").find("td:eq(1)").text(td1);


   }

   function setLastRowData(){

    let td1="備品:" + $("#_label_equipment").text() + " " +$("#set1_kg").val()+" KG "+$("#set1_times").val()+" 回 " + $("#efficiency").val()+" %"; 
    let td= $("#_label_course").text() + ' \n' 
    +" <span class='comment_name'>ダンベルカール: "+$("#exercise_comment").val()+"</span>"; 

    $("#menue_finished tr:last").find("td:eq(1)").prepend('<span aria-hidden="true"  class=" remove float-right fa-2x text-danger" style="cursor:pointer">×</span> ');
    $("#menue_finished tr:last").find("td:eq(0)").html(td);
    $("#menue_finished tr:last").find("td:eq(1)").text(td1);
   }

   function removeBorder(){
      $("#menue_add tr").removeClass("border");
      $("#menue_add tr").removeClass("border-primary");
      $("#menue_add tr").css('opacity','1');
      $("#menue_add tr").css("background",'#f2f2f2');
   }

    function arrayRemove(arr, value) { 
    
        return arr.filter(function(ele){ 
            return ele != value; 
        });
    }
    
   
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
  function show_calendar(){

      let action={
            'type':'show_calendar',
            'id':$("#remote_user").val()
          };
          api.executeCommand('sendEndpointTextMessage', $("#remote_user").val(), action);


    $('.bd-example-modal-lg5').modal();
  }
  function showGif(image){

            let action={
            'type':'show_gif',
            'id':$("#remote_user").val(),
            'img':image
          };
          api.executeCommand('sendEndpointTextMessage', $("#remote_user").val(), action);

        Swal.fire({
           icon: '',
           title: 'コースイメージ',
           html: " <img alt='Image loading...' src='"+image
                 +"' >",
           showConfirmButton:false
         })
  }

  var dateData = JSON.parse($(schedule).val());
  var occupiedList = JSON.parse($("#occupiedList").val());
  // document.addEventListener('DOMContentLoaded', function() {

  var calendarEl = document.getElementById('calendar');
  // var dateData = JSON.parse($(schedule).val());

      var calendar = new FullCalendar.Calendar(calendarEl, {
        showNonCurrentDates: false,
        fixedWeekCount:false,            
        // validRange: {
        //   start: '2021-06-22'
        // },
        firstDay: 0,
        selectable: true,
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: ''
        },
         views: {
          timeGridWeek: { // name of view
            dayHeaderFormat:{ weekday:'short', month: 'short', day: '2-digit' }
          }
        },

        customButtons: {
          myCustomButton: {
            text: 'トレーナー一覧',
            click: function() {
               window.location.href ='{{ route('trainerlist') }}';
            }
          }
        },
        eventDidMount: function(info) {

          console.log(info.event.start);

          if(occupiedList.indexOf(moment(info.event.start).format("YYYY-MM-DD")) !== -1){
              info.el.disabled = "true";
             // info.el.css('background-color', 'green');
             // info.event.setProp('classNames', 'tred');
          } 
     
        },
        dateClick: function(info,date) {

          // calendar.changeView('timeGridDay', moment(info.startStr, "YYYY-MM-DD"));
          let da=moment(info.dateStr).format("YYYY-MM-DD");
          $(".ld").show();
          var url = '{{ route('getTime')}}';

          $.ajax({
            type: "POST",
            url: url,
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {'date':da, 'user_id':{{$schedule->user_id}},'trainer_id':{{$schedule->trainer_id}} }, // serializes the form's elements.
            success: function(data)
            {
                $('.bd-example-modal-lg5').modal('hide');
                $('.bd-example-modal-lg6').modal();

              
                $('#md').html(data.html);
                $(".ld").hide();


                let action={
                'type':'show_time_list',
                'id':$("#remote_user").val(),
                'content':data.html
                };
                api.executeCommand('sendEndpointTextMessage', $("#remote_user").val(), action);

            }
          }); 
        },
        events: dateData
      });

  calendar.render();
  calendar.setOption('locale', 'ja');

  $('.bd-example-modal-lg5').on('shown.bs.modal', function () {
    calendar.render();
  })


  function showExerciseDashboard(content){
      
      let contents=$("#dashboard").html();


      let action={
      'type':'show_dashboard',
      'id':$("#remote_user").val(),
      'content':contents
      };
      api.executeCommand('sendEndpointTextMessage', $("#remote_user").val(), action);


  }
  function submitAjax(date,trainer_id,time,user_id,obj){
            $(".ld").show();

    $('.disalbed_container').addClass('disabledDiv');

    
    // when time button  clicked
        let action={
          'type':'time_button_clicked',
          'id':$("#remote_user").val(),
          'content':'disabledDiv'
          };
        api.executeCommand('sendEndpointTextMessage', $("#remote_user").val(), action);
        // when time button is clicked

      $.ajax({
          type: "POST",
          url: '{{ route('jitsiUserSubmitTime') }}',
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {'date':date, 'user_id':user_id,'trainer_id':trainer_id,'time':time }, // serializes the form's elements.
          success: function(data)
          {
            $(".response_").html(data.html);
            $('.disalbed_container').removeClass('disabledDiv');
            $(".ld").hide();

            // when time button  response
            let action={
              'type':'time_button_response',
              'id':$("#remote_user").val(),
              'content':data.html
              };
            api.executeCommand('sendEndpointTextMessage', $("#remote_user").val(), action);
            // when time button get response

            if(data.success){
              $("#"+obj.id).removeClass('tblue');
              $("#"+obj.id).addClass('tred');
              $("#"+obj.id).addClass('disabledDiv');
              calendar.addEvent(
                  data.event
              );
              //->when response is successful
            let action={
              'type':'time_successfull',
              'id':$("#remote_user").val(),
              'obj':obj.id,
              'content':data.event
              };
            api.executeCommand('sendEndpointTextMessage', $("#remote_user").val(), action);
            //<- when time button is clicked and get response


            }

        

          }
        }); 
  }
  function show_calendar_jitsi(){
    $('.bd-example-modal-lg5').modal();
    $('.bd-example-modal-lg6').modal('hide');

      //->when back button is clicked
            let action={
              'type':'show_calendar_jitsi',
              'id':$("#remote_user").val(),
              'content':$('#initial_date').val()
              };
            api.executeCommand('sendEndpointTextMessage', $("#remote_user").val(), action);
      //<-when back button is clicked
         calendar.gotoDate($('#initial_date').val());


  }
  api.addEventListener('endpointTextMessageReceived' , function(abcd){
          let received_data=JSON.parse(JSON.stringify(abcd.data.eventData.text));
          console.log(received_data);
          console.log(received_data.type);
          $(".loads").show();
          if(received_data.type == 'set_large_vedio_open'){
            api.setLargeVideoParticipant(received_data.id);
          }

           if(received_data.type == 'show_gif'){
            showGif(received_data.img);
          }
          if(received_data.type == 'show_calendar'){
            $('.bd-example-modal-lg5').modal();
          }
          if(received_data.type == 'show_dashboard'){
            $("div#_ct_").html(received_data.content);
            $('#dashboard').modal();
            $('#dashboard').find(".remove").remove();
            $('#dashboard').find(".comment_name").remove();
            $('#dashboard').find(".comment_name_").remove();

            
          }
          if(received_data.type == 'show_time_list'){
              $('.bd-example-modal-lg5').modal('hide');
              $('.bd-example-modal-lg6').modal();

              $('#md').html(received_data.content);
          }

          if(received_data.type == 'time_button_clicked'){
            $(".ld").show();
            $('.disalbed_container').addClass('disabledDiv');
      
          }

          if(received_data.type == 'time_button_response'){
            $(".ld").hide();
            $('.disalbed_container').removeClass('disabledDiv');
            $(".response_").html(received_data.content);
          }
          if(received_data.type == 'time_successfull'){
              calendar.addEvent(received_data.content);
               $("#"+received_data.obj).removeClass('tblue');
              $("#"+received_data.obj).addClass('tred');
              $("#"+received_data.obj).addClass('disabledDiv');
        
          }
          if(received_data.type == 'show_calendar_jitsi'){
              $('.bd-example-modal-lg5').modal();
              calendar.gotoDate(received_data.content);

              $('.bd-example-modal-lg6').modal('hide');
          }
          
          if(received_data.type == 'next_prev_today'){
              calendar.gotoDate( received_data.content);
          }
          if(received_data.type == 'hide_modal'){
               $('.'+received_data.content).modal('hide');
          }
          
           $(".loads").hide();
          
    });

$('.fc-prev-button').click(function(){
   let date = calendar.getDate();
  // alert("The current date of the calendar is " + date.toISOString());
  
   //->when back button is clicked
            let action={
              'type':'next_prev_today',
              'id':$("#remote_user").val(),
              'content':moment(date.toISOString()).format("YYYY-MM-DD")
              };
            api.executeCommand('sendEndpointTextMessage', $("#remote_user").val(), action);
      //<-when back button is clicked
         calendar.gotoDate(moment(date.toISOString()).format("YYYY-MM-DD"));
});

$('.fc-next-button').click(function(){
  let date = calendar.getDate();
  // alert("The current date of the calendar is " + date.toISOString());
  
   //->when back button is clicked
            let action={
              'type':'next_prev_today',
              'id':$("#remote_user").val(),
              'content':moment(date.toISOString()).format("YYYY-MM-DD")
              };
            api.executeCommand('sendEndpointTextMessage', $("#remote_user").val(), action);
      //<-when back button is clicked
         calendar.gotoDate(moment(date.toISOString()).format("YYYY-MM-DD"));
});
$('.fc-today-button').click(function(){
  let date = calendar.getDate();
  // alert("The current date of the calendar is " + date.toISOString());
  
   //->when back button is clicked
            let action={
              'type':'next_prev_today',
              'id':$("#remote_user").val(),
              'content':moment(date.toISOString()).format("YYYY-MM-DD")
              };
            api.executeCommand('sendEndpointTextMessage', $("#remote_user").val(), action);
      //<-when back button is clicked
         calendar.gotoDate(moment(date.toISOString()).format("YYYY-MM-DD"));
});

$('.bd-example-modal-lg5').on('hidden.bs.modal', function () {
     //->when back button is clicked
            let action={
              'type':'hide_modal',
              'id':$("#remote_user").val(),
              'content':'bd-example-modal-lg5'
              };
            api.executeCommand('sendEndpointTextMessage', $("#remote_user").val(), action);
      //<-when back button is clicked
});
function setCookie(cname,cvalue) {

    console.log(cvalue);
    var now = new Date();
    var time = now.getTime();
    time += 3600 * 1000;
    now.setTime(time);
    document.cookie = cname + 
    '=' + cvalue + 
    '; expires=' + now.toUTCString() + 
    '; path=/';
}

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function checkCookie(name) {
  return getCookie(name);
 
}



function calling_ajax_course_list(){

let savedValue=checkCookie("session_"+'{{ $schedule->id}}'+"_saved");
let currentValue=checkCookie("session_"+'{{ $schedule->id}}'+"_current");

  var action="{{ route('previousMenuList')}}";
  var method="POST";
  var data={
      'user_id' : {{ $schedule->user_id }},
      'trainer_id' : {{ $schedule->trainer_id }},
      'saved_value' : savedValue,
      'current_value' : currentValue,
      'date':date
  };
  var div="previous_data";
  ajax_request(action,method,data,div);
}

  </script>

@endsection 