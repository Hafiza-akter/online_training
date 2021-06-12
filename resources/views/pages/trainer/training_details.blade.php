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
.combodate{
  margin:2px;
  padding:2px;
}

</style>
<section class="review_part gray_bg section_padding">


<div class="row justify-content-center">
      <div class="col-sm-12 col-md-4  col-lg-4 col-xl-4">
        <div id="meet" style="height:86vh;width: 100%;"></div>

          <div class="row justify-content-center card">
          
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
              <div class="card m-1"  onclick="show_calendar()"style="display:inline-flex;height: 80px;width:80px">
                <div class="card-body" >
                    <span><img src="{{ asset('images/cl.png')}}"></span>

                </div>
              </div>
              
            </div>


        </div>
      </div>
      <div class="col-sm-12 col-md-4  col-lg-4 col-xl-4 card text-center pt-3">
         <button class="btn btn-md btn-primary btn-outline btn-block copy_list">前回のリストをコピー</button>
         <button class="btn btn-md btn-primary btn-outline btn-block">前回のリストをコピー</button>


          <div class="row p-2 mx-auto" >

          <span class="prev"><i class="fas fa-chevron-circle-left fa-2x"></i></span>
            <input type="text" id="list_date" data-format="YYYY-MM-DD" data-template="YYYY MMM D" name="list_date" >
          <span class="next"><i class="fas fa-chevron-circle-right fa-2x"></i></span>

          </div>
       

         <div id="previous_data">
           
         </div>

      </div>
      <div class="col-sm-12 col-md-4  col-lg-4 col-xl-4  performance px-1" id="performance">
        <div class="card px-1">
          <div class="row">
              <div class="col-sm-6 ">
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
              <div class="col-sm-6 ">
                  <label class="col-form-label">コース</label>
                  <select class="form-control course" style="width: 100%;" name="course[]" required="required">
                      <option value="">--select--</option>
                  </select>
              </div>
          </div>

          <div class="row ">
            <div class="col-sm-6">
                <label class="col-form-label">備品</label>
                    <select class="form-control equipment" style="width: 100%;" name="equipment[]" >
                        <option value="">--select--</option>
                    </select>
            </div>
            <div class="col-sm-6">
                <label class="col-form-label">Set</label><br>
              <input  style="width:30px" name="set1_kg[]" class="set1_kg kg p-1 m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>KG</span>
              <input  style="width:30px" name="set1_times[]" class="set1_times times kg p-1 m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required" /><span>回</span>
              <input  style="width:30px" name="efficiency[]" class="set1_efficiency times kg p-1 m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required" /><span>%</span>
            </div>
          </div>

          <div class="row mb-1">
            <div class="col-sm-12">
              <button class="float-right btn btn-primary add_button" disabled="disabled" > メニューに追加</button>
            </div>
          </div>

          <div class="row mb-1 mt-3">
            <div class="col-sm-12">

              <div class="table-responsive">
                <table class="table table-striped">
                  <tbody id="menue_add">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
        </div>
      </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-8  col-lg-8 col-xl-8  card mt-2 border border-primary">
        <div class="p-4">
          <div class="row ml-2 mb-1">
              <div class="col-sm-6 ">
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
              <div class="col-sm-6 ">
                  <label class="col-form-label">コース</label>
                  <select class="form-control course" style="width: 100%;" name="course[]" required="required">
                      <option value="">--select--</option>
                  </select>
              </div>
          </div>

          <div class="row ml-2 mb-1">
            <div class="col-sm-6">
                <label class="col-form-label">備品</label>
                    <select class="form-control equipment" style="width: 100%;" name="equipment[]" >
                        <option value="">--select--</option>
                    </select>
            </div>
            <div class="col-sm-6">
                <label class="col-form-label">Set</label><br>
              <input  style="width:30px" name="set1_kg[]" class="set1_kg kg p-1 m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>KG</span>
              <input  style="width:30px" name="set1_times[]" class="set1_times times kg p-1 m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required" /><span>回</span>
              <input  style="width:30px" name="efficiency[]" class="set1_efficiency times kg p-1 m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required" /><span>%</span>
            </div>
          </div>

          <div class="row ml-2 mb-1">
             <div class="col-md-8">
                <label class="col-form-label">コメント</label><br>
                <textarea class="form-control"></textarea>
            </div>
           
          </div>
          <div class="row ml-2 mb-1">
            <div class="col">
              <button class="float-right btn btn-primary ml-2"  > スタート</button>
              <button class="float-right btn btn-danger "  > 記録して次へ</button>
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
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="width:500px">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div id='calendar'></div>

          </div>
        </div>
      </div>
    </div>
<!-- ///////////////-->

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




<div id="clock"></div>

@endsection
@section('footer_css_js')
<script src='{{ asset('asset_v2/js/sweetalert2@10.js')}}'></script>
<script src='{{ asset('asset_v2/js/jquery.countdown.min.js')}}'></script>
<script src='{{ asset('asset_v2/js/combodate.js')}}'></script>
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
var initialDate = moment().format("YYYY-MM-DD");
calling_ajax_previous_data(initialDate);

$('#list_date').combodate('setValue',initialDate);
  $('.prev').click(function(){

    curent_val=$('#list_date').combodate('getValue');
    prev_val=moment(curent_val, "YYYY-MM-DD").add(-1, 'days').format('YYYY-MM-DD');
    $('#list_date').combodate('setValue',prev_val);
    calling_ajax_previous_data(prev_val);

  });
  $('.next').click(function(){
    curent_val=$('#list_date').combodate('getValue');
    nex_val=moment(curent_val, "YYYY-MM-DD").add(1, 'days').format('YYYY-MM-DD');
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
      console.log(course);
      let equipment=$('.equipment').find('option:selected').text();
      let set1_times = $('.set1_times').val();
      let set1_kg = $('.set1_kg').val();
      let set1_efficiency = $('.set1_efficiency').val();
      let r= $('<input type="button" value="削除" class="m-1 remove btn btn-danger"/>');
      let html="<tr>"+
              "<td>コース: " + course +" <br> "+
              " 備品: " +equipment +
              " <td>"+set1_kg+" KG "+set1_times+" 回 "+set1_efficiency +' % <span aria-hidden="true" class="remove float-right fa-2x text-danger" style="cursoer:pointr">×</span> '+ "</td>"
              "</tr>";
      
      // let id = 'performance'+ cloneCount++;
      // $("#performance").clone().attr('id',id).insertAfter($('[id^=performance]:last'));
      //   $("#"+id).append(r);
        $('#menue_add').append(html);

   }); 

   $(".copy_list").click(function(){

    $("#previous_data  table > tbody > tr").each(function () {

      // alert($(this).find('td').eq(0).text() + " " + $(this).find('td').eq(1).text() );
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

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      selectable: true,
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
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: ''
      },
      dateClick: function(info) {
                     // window.location.href ='{{ route('traininginfo')}}';

      }
    });

          calendar.render();
          calendar.setOption('locale', 'ja');

$('.bd-example-modal-lg5').on('shown.bs.modal', function () {
calendar.render();
calendar.setOption('locale', 'ja');
})

  });




  </script>

@endsection 