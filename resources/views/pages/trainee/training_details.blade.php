@extends('master_dashboard')
@section('title','trainee training')
@section('header_css_js')
<link href='{{ asset('asset_v2/css/fullcalendar_main.min.css')}}' rel='stylesheet' />
<script src='{{ asset('asset_v2/js/fullcalendar_main.min.js')}}'></script>

<script src="{{ asset('asset_v2/js/moment_2.29.1.min.js')}}" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>  
<script  src="https://momentjs.com/downloads/moment-timezone-with-data.js"></script>
<style>
  .loads{
  position: fixed;
  left: 50%;
  top: 50%;
  width: 100%;
  height: 100%;
  z-index: 9999;
  display:none;
}
  #clock {
    position: absolute;
    top: 30%;
    left: 1%;
    /*transform: translateX(-50%) translateY(-50%);*/
    color: red;
    font-size: 2rem;
   

}

@media only screen and (max-width: 768px) {
    #clock {
    position: absolute;
    top: 24%;
    left: 1%;
    /*transform: translateX(-50%) translateY(-50%);*/
    color: red;
    font-size: 1.5rem;
   

}
  .cals{
    width:100vh;
  }
}

.fixedbutton {
    position: fixed;
    bottom: 0px;
    right: 0px; 
}
.modal-backdrop {
   background: none !important;
}
.section_padding{
    padding: 76px 0;
}
.table td{
  border:none;
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
<script src="{{ asset('asset_v2/js/sweetalert.min.js')}}"></script>

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

</style>
<section class="review_part gray_bg section_padding pb-0" style="background:#494747" >
    <div id="meet" style="height: calc(100vh - 145px);width: 100%;"></div>
    <div id="clock"></div>

    <div class="container">

        <div class="row jsutify-content-center">


           <ul class="list-group list-group-horizontal mx-auto user_jitsi_menue">
            <li  class="list-group-item pointer " onclick="$('#dashboard').modal()">

              <img src="{{ asset('images/target.png')}}">
              <span> 実績 </span>
            </li>
            <li class="list-group-item pointer" onclick="$('.bd-example-modal-lg2').modal()">
              <img src="{{ asset('images/cours.png')}}" >
              <span> 説明 </span>

            </li>
            <li class="list-group-item pointer" onclick="show_calendar()">
               <img src="{{ asset('images/calendar.png')}}" >
              <span> 予約 </span>
            </li>
          </ul>

        </div>
    </div>
</section>


{{-- <div class="fixedbutton" style="height:50px;">
    <ul class="list-group list-group-horizontal">
      <li  class="list-group-item pointer" onclick="$('#dashboard').modal()">

        <img src="{{ asset('images/target.png')}}" height="26">
        <span> 実績 </span>
      </li>
      <li class="list-group-item pointer" onclick="$('.bd-example-modal-lg2').modal()">
        <img src="{{ asset('images/cours.png')}}" height="26">
        <span> 説明 </span>

      </li>
      <li class="list-group-item pointer" onclick="$('.bd-example-modal-lg5').modal()">
         <img src="{{ asset('images/calendar.png')}}" height="26">
        <span> 予約 </span>
      </li>
    </ul>
</div> --}}

<div class="modal fade left" id="dashboard" tabindex="-1" role="dialog" aria-labelledby="dashboard" aria-hidden="true">
  <div class="modal-dialog modal-dialog-slideout modal-lg crs" role="document" style="width:90vw;">
    <div class="modal-content">
        <div class="modal-header" style="background: #056fb8;">
          <h3 class="" style="text-align: center;color: white;">
          コースリスト
          </h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="_ct_">
        <p class="text-center">No active course found</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

  <div class="modal  fade left" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background: #056fb8;">
          <h3 class="" id="exampleModalLabel" style="text-align: center;color: white;">
          トレーニングデータ
          </h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal-body">

        </div>
      </div>
    </div>
    </div>
     
    <div class="modal fade left bd-example-modal-lg2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
          <div class="modal-header" style="background: #056fb8;">
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
                   $fimages= asset('images').'/'.$val->image_path;
                  }else{
                   $fimages= asset('images').'/no_image.png';
                  }
                @endphp
                  <tr>
                    <td>
                      <input type="radio" name="course_list" id="course_list_{{ $val->id}}" onclick="showExplanation(`{{ $fimages}}`,`{{ $val->summary}}`,`{{ $val->sub}}`,`{{ $val->way}}`,`{{ $val->motion}}`)">  
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

    <div class="modal fade bd-example-modal-lg3" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background: #056fb8;">
          <h3 class="" style="text-align: center;color: white;">
          コメント
          </h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
            <form action="{{route('trainee_training_feedback')}}" method="post" id="feed_back_form">
            <!-- edit mode form-->

              <input type="hidden" name="schedule_id" value="{{ $schedule->id}}">
              <input type="hidden" name="trainer_id" value="{{ $schedule->trainer_id}}">
            {{ csrf_field() }}
              <div class="form-group  row justify-content-center">
                <div class="col-sm-10">
                <label class="col-form-label">コメントの入力</label>
                    <textarea class="form-control customEditor"  name="user_feedback" style="width: 400px; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $exerciseData ? $exerciseData->comment : '' }}</textarea>
                </div>
            </div>
             <div class=" row justify-content-center">
          <button type="button" class="btn btn-secondary m-1" data-dismiss="modal">閉じる</button>
          <a id="f_btn" href="#" class="nav-link active__ m-1" style="color: white;">更新する</a>
        </div>
          </form>
        </div>
       
      </div>
    </div>
    </div>
    @php
      $date = Carbon\Carbon::parse($schedule->date)->format('Y/m/d');
      $hour = Carbon\Carbon::parse($schedule->time)->addHours(1)->format('H:i:s');
      $param=encryptionValue(['schedule_id' => $schedule->id]);

      if($hour == "00:00:00"){
        $hour = "24:00:00";
      }
    @endphp
    <input type="hidden" id="clock_value" value='{{ $date." ".$hour }}'>
    <input type="hidden" id="local_user" >
    <input type="hidden" id="remote_user" >


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
               {{--  <input type="hidden" id="schedule" value="{{ json_encode(getTrainerList($schedule->trainer_id,$schedule->user_id))}}"> --}}
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

{{-- <button type="button" class=" nav-link active__"  style="color:white;position: absolute;top: 35%;right: 0;" id="performance_btn"> 実績 </button>

<button type="button" class="nav-link active__" data-toggle="modal" data-target=".bd-example-modal-lg2" style="color:white;position: absolute;top: 45%;right: 0"> 説明 </button> --}}

{{-- <button type="button" class="nav-link active__" data-toggle="modal" data-target=".bd-example-modal-lg3" style="color:white;position: absolute;top: 55%;right: 0"> コメント </button> --}}
<div class="loads" >
    <i class="fas fa-circle-notch fa-spin fa-4x"></i>
</div>
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
.swal2-container.swal2-backdrop-show, .swal2-container.swal2-noanimation{
  background:none !important;
}
</style>
<script>
function getdayFromNow() {
    // return new Date('2021-02-09 10:00:00');
    // 2021-02-09T10:00:00
    // console.log(new Date(new Date().valueOf() + 15 * 24 * 60 * 60 * 1000));
    return new Date($("#clock_value").val());

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
  // console.log($("#clock_value").val());
  // console.log(moment());
// var localTime = moment.tz( moment($("#clock_value").val()), 'Asia/Tokyo').format('YYYY/MM/DD HH:mm:ss');
// var time = moment($("#clock_value").val()).format('YYYY/MM/DD hh:mm:ss');
// console.log( 'This is the time ' +time );

// var main_time= moment.tz( time, 'Asia/Tokyo').format('YYYY/MM/DD HH:mm:ss');
// console.log( 'This is the main time ' +main_time);


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
        window.location.href = "{{ route('userRatings',$param) }}";


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
      // width: '100%',
      // height: 640,
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
          window.location.href = "{{ route('userRatings',$param) }}";
    
    });
    // api.executeCommand('subject', '');
    api.executeCommand('displayName', '{{ isset($display_name) ? $display_name : ''}}');
       // jitsi end
       // jitsi end

        api.addEventListener('videoConferenceJoined' , function(abcd){
          $("#local_user").val(abcd.id );
          console.log("pparticipants: " +JSON.stringify(abcd));
        });
        api.addEventListener('participantJoined' , function(abcd){
          // var x=api.getParticipantsInfo();
          $("#remote_user").val(abcd.id );
        });

    api.addEventListener('incomingMessage' , function(abcd){
          // var x=api.getParticipantsInfo();
          // alert();
        });
     api.addEventListener('endpointTextMessageReceived' , function(abcd){
          // var x=api.getParticipantsInfo();
          let received_data=JSON.parse(JSON.stringify(abcd.data.eventData.text));
          console.log(received_data);
          console.log(received_data.type);
          $(".loads").show();
          // alert(received_data.type);
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

            // $('#menue_finished tr').css("border", "#e3e3e3 solid 1px"); 
            
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
              calendar.gotoDate( received_data.content);

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
  
 // Remove element

$('#performance_btn').click(function(){

    $.ajax({
        type: "POST",
        url: '{{ route('ajax_training_performance', $schedule->id)}}',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { 'modal_view': 'modal_view' },
        cache: false,
        success: function(res) {

            // get the ajax response data
            var data = res.html;
            console.log(data);
            // update modal content here
            // you may want to format data or 
            // update other modal elements here too
            $('#modal-body').html(data);

            // show modal
            $('#exampleModalScrollable').modal('show');

        },
        error:function(request, status, error) {
            console.log("ajax call went wrong:" + request.responseText);
        }
    });
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
var dateData = JSON.parse($(schedule).val());
var occupiedList = JSON.parse($("#occupiedList").val());
// document.addEventListener('DOMContentLoaded', function() {

var calendarEl = document.getElementById('calendar');
// var dateData = JSON.parse($(schedule).val());
console.log(dateData);

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
            // info.el.disabled = "true";
           // info.el.css('background-color', 'green');
           // info.event.setProp('classNames', 'tred');
        } 

        // if( moment(info.event.start).format("YYYY-MM-DD") === '2021-06-29'){
          
        // }
   
      },
      dateClick: function(info,date) {

        // calendar.changeView('timeGridDay', moment(info.startStr, "YYYY-MM-DD"));
        let da=moment(info.dateStr).format("YYYY-MM-DD");
        // console.log(da);
        // calendar.setOption('headerToolbar', {
        //     left: '',
        //     center: 'title',
        //     right: 'prev,next today'
        //   });
                
        // calendar.removeAllEvents();
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

// });

  function showExplanation(img,text,sub,way,motion){
        Swal.fire({
          showCloseButton: true,
           icon: '',
           title: '説明',
           html: " <br> "+" <img alt='Image loading...' src='"+img
                 +"' >"+"<br><b> サマリ:</b> "+text,
           showConfirmButton:false
         })
  }
  function showGif(image){
        Swal.fire({
          showCloseButton: true,
           icon: '',
           title: 'コースイメージ',
           html: " <img alt='Image loading...' src='"+image
                 +"' >",
           showConfirmButton:false
         })
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
    calendar.gotoDate($('#initial_date').val());

      //->when back button is clicked
            let action={
              'type':'show_calendar_jitsi',
              'id':$("#remote_user").val(),
              'content':$('#initial_date').val()
              };
            api.executeCommand('sendEndpointTextMessage', $("#remote_user").val(), action);
      //<-when back button is clicked

  }
    function show_calendar(){

      let action={
            'type':'show_calendar',
            'id':$("#remote_user").val()
          };
          api.executeCommand('sendEndpointTextMessage', $("#remote_user").val(), action);


    $('.bd-example-modal-lg5').modal();
  }
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
  </script>

@endsection