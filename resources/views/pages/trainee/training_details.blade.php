@extends('master_dashboard')
@section('title','trainee trainerlist')
@section('header_css_js')
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

    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background: #a331a3;">
            <h3 class="" id="exampleModalLabel" style="text-align: center;color: white;">
            Training Data
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
     

    <div class="modal fade bd-example-modal-lg2" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                      <input type="radio" name="course_list" id="course_list_{{ $val->id}}" onclick="showExplanation(`{{ $val->summary}}`)">  
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
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="nav-link active__" style="color: white;">Submit</button>
          </div> --}}
        </div>
      </div>
    </div>

    <div class="modal fade bd-example-modal-lg3" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
            <form action="{{route('training_feedback')}}" method="post" id="performance_form">
            <!-- edit mode form-->

              <input type="hidden" name="schedule_id" value="{{ $schedule->id}}">
              <input type="hidden" name="trainer_id" value="{{ $schedule->trainer_id}}">
            {{ csrf_field() }}
              <div class="form-group  row justify-content-center">
                <div class="col-sm-10">
                <label class="col-form-label">コメントの入力</label>
                    @if(Session::get('user_type') == 'trainee'){
                    <textarea class="form-control customEditor"  name="user_feedback" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $exerciseData ? $exerciseData->comment : ''}}</textarea>
                    @else 
                     <textarea class="form-control customEditor"  name="user_feedback" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $exerciseData ? $exerciseData->trainer_feedback: ''}}</textarea>
                    @endif
                </div>
            </div>
             <div class=" row justify-content-center">
          <button type="button" class="btn btn-secondary m-1" data-dismiss="modal">Close</button>
          <button type="submit" class="nav-link active__ m-1" style="color: white;">Submit</button>
        </div>
          </form>
        </div>
       
      </div>
    </div>
    </div>

<button type="button" class=" nav-link active__"  style="color:white;position: absolute;top: 35%;right: 0;" id="performance_btn"> 実績 </button>

<button type="button" class="nav-link active__" data-toggle="modal" data-target=".bd-example-modal-lg2" style="color:white;position: absolute;top: 45%;right: 0"> 説明 </button>
<button type="button" class="nav-link active__" data-toggle="modal" data-target=".bd-example-modal-lg3" style="color:white;position: absolute;top: 55%;right: 0"> コメント </button>

@endsection
@section('footer_css_js')
<script src='{{ asset('asset_v2/js/sweetalert2@10.js')}}'></script>

<script>
    Object.defineProperty(window.navigator, 'userAgent', {
      get: function () { return 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/80.0.3987.163 Chrome/80.0.3987.163 Safari/537.36'; }
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

 // Remove element

   //  $(".submit_performance").click(function(){

   //      var form = $("#performance_form");
   //      var url = form.attr('action');
        

   //      //  var lngtxt=(form.find('input[name="course[]"]').val()).length;
   //      // console.log(lngtxt);
   //      // if (lngtxt==0){
   //      //     alert('please enter value');
   //      //     return false;
   //      // }else{
   //      //     //submit
   //      // }
   //      $.ajax({
   //             type: "POST",
   //             url: url,
   //              headers: {
   //              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   //              },
   //             data: form.serialize(), // serializes the form's elements.
   //             success: function(data)
   //             {
   //                 // Swal.fire({
   //                 //    icon: 'success',
   //                 //    title: 'Schedule time set successfully! ',
   //                 //    showConfirmButton:false
   //                 //  })
   //                  // location.reload();
   //             }
   //      });
   // }); 

});
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

  function showExplanation(text){
        Swal.fire({
           icon: '',
           title: '説明',
           text: text,
           showConfirmButton:false
         })
  }
  </script>

@endsection 