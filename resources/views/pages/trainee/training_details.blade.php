@extends('master_dashboard')
@section('title','trainee training')
@section('header_css_js')
<script src="{{ asset('asset_v2/js/moment_2.29.1.min.js')}}" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>  
<script  src="https://momentjs.com/downloads/moment-timezone-with-data.js"></script>
<style>
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
<section class="review_part gray_bg section_padding" >
    <div class="row justify-content-center">
        <div class="col-md-8 col-xl-6">
            <div class="section_tittle">
                <h3>トレーニングページ</h3>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div id="meet" style="height: 86vh"></div>
        </div>   
    </div>
</section>

  <div class="modal  fade left" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
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
        <div class="modal-body" id="modal-body">

        </div>
      </div>
    </div>
    </div>
     
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

    <div class="modal fade bd-example-modal-lg3" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
      <div class="modal-content">
        <div class="modal-header" style="background: #a331a3;">
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

    @endphp
    <input type="hidden" id="clock_value" value='{{ $date." ".$hour }}'>

<button type="button" class=" nav-link active__"  style="color:white;position: absolute;top: 35%;right: 0;" id="performance_btn"> 実績 </button>

<button type="button" class="nav-link active__" data-toggle="modal" data-target=".bd-example-modal-lg2" style="color:white;position: absolute;top: 45%;right: 0"> 説明 </button>

{{-- <button type="button" class="nav-link active__" data-toggle="modal" data-target=".bd-example-modal-lg3" style="color:white;position: absolute;top: 55%;right: 0"> コメント </button> --}}
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
          window.location.href = "{{ route('userRatings',$param) }}";
    
    });
    // api.executeCommand('subject', '');
    api.executeCommand('displayName', '{{ isset($display_name) ? $display_name : ''}}');
       // jitsi end
       // jitsi end

      // for upazila
  

  
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


  function showExplanation(text,sub,way,motion){
        Swal.fire({
           icon: '',
           title: '説明',
           html: " <br> <b> サマリ:</b> "+text,
           showConfirmButton:false
         })
  }
  </script>

@endsection