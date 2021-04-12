@extends('master_dashboard')
@section('title','trainer schedule')
@section('header_css_js')
<link href='{{ asset('asset_v2/css/fullcalendar_main.min.css')}}' rel='stylesheet' />
 


@endsection
@section('content')
<style>
  .current-time {
    background-color: rgba(20, 20, 20, 0.10);
    border-radius: 3px;
    color: #9B9B9B;
    position: relative;
    top: 2px;
    cursor: pointer;
}

  .table td,
  .table th {
    border: none !important;
  }
  .fc-theme-standard td{
    background: #fff;
  }

  .fc-button-active{
    background: #a50ca4 !important;
  }
  /*.fc-myCustomButton-button{
    background: none !important;
    color: #a509a4 !important;
    border: 1px solid #a509a4 !important;
  }*/
/*  .fc-timegrid-event-harness{
z-index: 1;inset: 21px -2% -65px !important;
  }
  .fc-daygrid-event fc-daygrid-dot-event fc-event fc-event-start fc-event-end fc-event-past{

  }*/
    .fc-week-button{
    background: #a50ca4 !important;
    color: #fff !important;
    border: 1px solid #a509a4 !important;
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
  .green{
    background: green !important;
    color:white !important;
  }
  .swal2-styled.swal2-confirm{
      background-color: #a509a4

  }
  .swal2-styled.swal2-deny{
      background-color: #09951a;

  }
  .swal2-styled.swal2-cancel{
      background-color: #e93232;
  }
  .fc .fc-timegrid-slot{
    height:2.5em;
  }
  .tblue1{
    background: blue !important;
    opacity: .4 !important;
    color:white !important;
    /*border: 1px solid #ddd;*/
  }
  /*.fc .fc-bg-event{
    border:1px solid white;
    background: blue !important;
    opacity:1 !important;
  }*/
  .fc-highlight{
    background: none !important;
  }

</style>

    {{-- @include('pages.trainer.dashboard') --}}
<section class="review_part gray_bg section_padding">

  <div class="offset-md-1 col-md-10">

        @if(Session::has('message'))
        <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismiss">{!! Session::get('message') !!}</p>
        @endif

        @if(Session::has('errors_m'))
        <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-danger') }} alert-dismiss">{!! Session::get('errors_m') !!}</p>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8 col-xl-6">
                <div class="section_tittle">
                        <h3>スケジュール</h3>
                </div>
            </div>
        </div>


      <div class="row pb-5  page-content page-container" id="chart">

        <form action="{{route('tscheduleSubmit.submit')}}" method="post" id="dateform">
            {{ csrf_field() }}
            <input type="hidden" name="user_id" value="{{ Session::get('user') ? Session::get('user')->id : ''}}">
            <input type="hidden" name="selected_date" id="selected_date" value="{{$selected_date}}">
            <input type="hidden" name="event_type" id="event_type" value="{{$event_type}}">
            <input type="hidden" name="trainer_id" id="trainer_id" value="{{$trainer_id}}">
            <input type="hidden" name="start_time" id="selected_time" value="">
            <input type="hidden" name="schedule_id" id="schedule_id" value="">
            <input type="hidden" name="type"  id="action_type">
            <input type="hidden" name="db_start_time"  id="db_start_time">
            <input type="hidden" name="db_schedule_id"  id="db_schedule_id">
            <input type="hidden" name="db_date"  id="db_date">

        </form>
      </div>

      <div id='calendar'></div>
      {{-- <button  class="fc-myCustomButton-button fc-button fc-button-primary mt-2" type="button" style="float: right;font-size: 20px" onclick="document.getElementById('scheduleForm').submit();">登録</button>
      <button  class="fc-myCustomButton-button fc-button fc-button-primary mt-2 btn-danger" type="button" id="scheduleDeletebtn" style="margin-right: 10px;display:none; float: right;font-size: 20px" onclick="document.getElementById('scheduleDelete').submit();">削除</button>
 --}}
        <input type="hidden" id="schedule" value="{{ $schedule}}">
  </div>
</section>
<input type="hidden" value="{{ $checkPenalty }}" id="checkPenalty">
<input type="hidden" name="dayGridspecific"  id="dayGridspecific" value="{{Session::get('dayGridspecific') ? Session::get('dayGridspecific') : 'FA'}}">
@endsection

@section('footer_css_js')

<script src='{{ asset('asset_v2/js/fullcalendar_main.min.js')}}'></script>
<script src='{{ asset('asset_v2/js/locales-all.js')}}'></script>
<script src='{{ asset('asset_v2/js/sweetalert2@10.js')}}'></script>


<script src="{{ asset('asset_v2/js/moment_2.29.1.min.js')}}" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>  
<script src="{{asset('asset_v2/js/bootstrap-datetimepicker.min.js')}}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    var calendarEl = document.getElementById('calendar');
    var dateData = JSON.parse($(schedule).val());
    let a = [];
    let selectedEvent = [];
    console.log(dateData);
    var calendar = new FullCalendar.Calendar(calendarEl, {
        // selectable: true,
        allDaySlot: false,
        initialDate: '{{ $selected_date}}',

        contentHeight:"auto",
        initialView: 'timeGridDay',
        // nowIndicator: true,
        // scrollTime:'01:00:00',
        slotDuration:'01:00:00',
    // firstDay: (new Date().getDay()), // returns the day number of the week, works! 

          views: {
            timeGridWeek: { // name of view
              dayHeaderFormat:{ weekday:'short', month: 'short', day: '2-digit' }
            }
          },

        customButtons: {
          week_all: {
            text: '週次定期予約',
            click: function() {
            
            }
          },
          week: {
            text: '週次予約',
            click: function() {
            
            }
          },
          month: {
            text: '月',
            click: function() {
             window.location.href ='{{ route('traineeCalendar.view') }}';
            
            }
          },
       },
        headerToolbar: {
            left: 'month',
            center: 'title',
            right: '',
             // right: 'dayGridMonth,timeGridWeek,timeGridDay'

        },

       select: function(info) {
        let startTime = moment(info.startStr).format('HH:mm:ss');
        let endTime = moment(info.endStr).format('HH:mm:ss');

        let msgse="予約時間は  "+$("#selected_date").val();
        console.log(info);
         Swal.fire({
                title: "予約を確定します。よろしいでしょうか？", //"Are you sure ?",
              showDenyButton: false,
              showCancelButton: false,
              width: '650px',

              // html: "This week every day "+' at <input class="dtp" type="text"  readonly style="width:100px"> TO <input class="dtp2" type="text"  readonly style="width:100px">'
              // html: "<div class='row p-3'>" +dayname+ " day "+' at <input class="dtp ml-2 mr-2" type="text"  readonly style="width:100px"> TO <input class="dtp2 dtp ml-2 mr-2" type="text"  readonly style="width:100px"></div>'
              // +'<div class="row p-3 "><select class="form-control"  id="select_option">'
              //     +'<option value="reschedule"> Reschedule</option>'
              //     +'<option value="cancle_shedule"> Cancel Schedule</option>'
              // +'</select></div>'
              // ,
               html: "<div class='row p-3 justify-content-center'>" + msgse+
               ' at '+startTime+' To '+endTime
               +' </div>'
                +'</div>'
              ,


              confirmButtonText: `Yes i am sure`,
              cancelButtonText: `Cancel`,
              
              didOpen:function(){
                // Swal.disableButtons();
                

                $("#start_time").val(startTime); // form value

            
            }

            }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                // $("#action_type").val('recurring_delete'); // form value
                // $('#dateform').submit();
                console.log('submit');

                    // e.preventDefault(); // avoid to execute the actual submit of the form.

                    var form = $("#dateform");
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
                                  title: 'スケジュール予約が完了しました',
                                  showConfirmButton:false
                                })
                                location.reload();
                           }
                    });

                    
              } else if (result.isDenied) {
                console.log('details view');
              }else{
                if(result.dismiss === 'cancel'){
                
                }
           
                console.log('he he he backdrop');
              }
          })
      },
      eventClick:function(info){
        console.log(info.event.extendedProps);

        let startTime = info.event.extendedProps.startTime;
        let endTime = info.event.extendedProps.endTime;
        
        $("#schedule_id").val(info.event.id);
        let msgse="You want to reserve  "+$("#selected_date").val();
        console.log(info);
        if(info.event.extendedProps.is_occupied == 1){
            var dayname=moment(moment(info.event.start)).format('dddd');
            Swal.fire({
              title: '予定を変更しますか？',
              showDenyButton: true,
              showCancelButton: true,
              showDenyButton: false,
              width: '650px',
              // html: "This week every day "+' at <input class="dtp" type="text"  readonly style="width:100px"> TO <input class="dtp2" type="text"  readonly style="width:100px">'
              // html: "<div class='row p-3'>" +dayname+ " day "+' at <input class="dtp ml-2 mr-2" type="text"  readonly style="width:100px"> TO <input class="dtp2 dtp ml-2 mr-2" type="text"  readonly style="width:100px"></div>'
              // +'<div class="row p-3 "><select class="form-control"  id="select_option">'
              //     +'<option value="reschedule"> Reschedule</option>'
              //     +'<option value="cancle_shedule"> Cancel Schedule</option>'
              // +'</select></div>'
              // ,
               html: "<div class='row p-3'>" + " 予約時間は  "
               +moment(info.event.start).format('YYYY-MM-DD')
               +' の '+moment(info.event.start).format('hh:mm A')+' から '+moment(info.event.start).add(60, 'minutes').format('hh:mm A')
               +'です。 </div>'
               +'<div class="row p-3 " id="res" style="display:none">'
               + '予約の変更は <input class="dtp ml-2 mr-2" type="text"  disabled="disabled" style="width:100px"> から <input class="dtp2  ml-2 mr-2" type="text"  disabled="disabled" style="width:100px">'
               +'です。</div>'
               +'<div class="row p-3 "><select class="form-control"  id="select_option" >'
              +'<option value="0">タイプを選択してください。</option>'
                  +'<option value="dayreschedule"> 予約を変更する</option>'
                  +'<option value="daycancle_schedule"> 予約をキャンセルする</option>'
              +'</select></div>'
              ,


              confirmButtonText: `予約を変更する`,
              denyButtonText: `詳細を確認する`,
              cancelButtonText: `予約をキャンセルする`,
              
              didOpen:function(){
                Swal.disableButtons();


                  $(".dtp").datetimepicker({
                    formatViewType: 'time',
                    fontAwesome: true,
                    autoclose: true,
                    startView: 1,
                    maxView: 1,
                    minView: 0,
                    minuteStep: 60,
                    format: 'HH:ii P',
                    showMeridian: true,

                });
              
                
                $(".dtp").val(moment(info.event.start).format('hh:mm A'));
                $(".dtp2").val(moment(info.event.start).add(60, 'minutes').format('hh:mm A'));
                
                $("#selected_time").val(moment(info.event.start).format('hh:mm A')); // form value
                $("#db_start_time").val(moment(info.event.start).format('hh:mm A')); // form value
                $("#action_type").val(''); // form value
                $("#event_type").val(info.event.extendedProps.type); // form value
                $("#db_schedule_id").val(info.event.id); // form value
                $("#db_date").val(moment(info.event.start).format('YYYY-MM-DD')); // form value
                $("#trainer_id").val(info.event.extendedProps.trainer_id); // form value
                $(".dtp").on("change.dp",function (e) {
                    let newtime = moment(this.value, 'hh:mm').add(60, 'minutes').format('hh:mm A');
                    $(".dtp2").val(newtime);
                    $("#selected_time").val(this.value);

                });

            }

            }).then((result) => {
              console.log(result);
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                $('#dateform').submit();
              } else if (result.isDenied) {
                console.log('details view');
              }else{
                if(result.dismiss === 'cancel'){
                  $('#dateform').submit();
                }
                console.log('he he he backdrop');
              }
          })
        }else{
          
        $("#selected_time").val(moment(info.event.start).format('hh:mm A')); // form value
                $("#db_start_time").val(moment(info.event.start).format('hh:mm A')); // form value
                $("#event_type").val(info.event.extendedProps.type); // form value
                $("#db_schedule_id").val(info.event.id); // form value
                $("#db_date").val(moment(info.event.start).format('YYYY-MM-DD')); // form value
                $("#trainer_id").val(info.event.extendedProps.trainer_id); // form 
         Swal.fire({
              title: "予約を確定します。よろしいでしょうか？", //"Are you sure ?",
              showDenyButton: false,
              showCancelButton: false,
              width: '650px',

              // html: "This week every day "+' at <input class="dtp" type="text"  readonly style="width:100px"> TO <input class="dtp2" type="text"  readonly style="width:100px">'
              // html: "<div class='row p-3'>" +dayname+ " day "+' at <input class="dtp ml-2 mr-2" type="text"  readonly style="width:100px"> TO <input class="dtp2 dtp ml-2 mr-2" type="text"  readonly style="width:100px"></div>'
              // +'<div class="row p-3 "><select class="form-control"  id="select_option">'
              //     +'<option value="reschedule"> Reschedule</option>'
              //     +'<option value="cancle_shedule"> Cancel Schedule</option>'
              // +'</select></div>'
              // ,
               html: "<div class='row p-3 justify-content-center'>" + msgse+
               ' at '+startTime+' To '+endTime
               +' </div>'
                +'</div>'
              ,


              confirmButtonText: `Yes i am sure`,
              cancelButtonText: `Cancel`,
              
              didOpen:function(){
                // Swal.disableButtons();
                

                $("#start_time").val(startTime); // form value

            
            }

            }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                // $("#action_type").val('recurring_delete'); // form value
                // $('#dateform').submit();
                console.log('submit');

                    // e.preventDefault(); // avoid to execute the actual submit of the form.
                    // $('#dateform').submit();
                    var form = $("#dateform");
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
                                  title: 'スケジュール予約が完了しました',
                                  showConfirmButton:false
                                })
                                location.reload();
                           },
                          error: function(xhr, status, error) {
                            // console.log(xhr.responseText.message);
                            var json = JSON.parse(xhr.responseText);
                            if(json.message == 'error_multiple_date'){
                               Swal.fire({
                                  icon: 'error',
                                  title: '日付と時刻はすでに占有されています',
                                  showConfirmButton:false
                                })
                          }
                            }
                           
                    });

                    
              } else if (result.isDenied) {
                console.log('details view');
              }else{
                if(result.dismiss === 'cancel'){
                
                }
           
                console.log('he he he backdrop');
              }
          })    
        }
      },

      events: dateData
     
    });

      calendar.render();
      calendar.setOption('locale', 'ja');
});
    $(document).on('change','#select_option', function(e) {

      if($(this).val() == 'reschedule'){
        console.log();
        Swal.disableButtons();
        Swal.getConfirmButton().removeAttribute('disabled');
         $('.dtp').removeAttr('Disabled');
         $('#res').show();
        $("#action_type").val('weekupdate'); // form value

      }
       if($(this).val() == 'cancle_schedule'){
        Swal.disableButtons();
        Swal.getCancelButton().removeAttribute('disabled');
        $('.dtp').attr('disabled', 'disabled' );
         $('#res').hide();
        $("#action_type").val('weekcancel'); // form value
      }
       if($(this).val() == '0'){
        Swal.disableButtons();
        $('.dtp').attr('disabled', 'disabled' );

      }

      if($(this).val() == 'dayreschedule'){
        if($('#checkPenalty').val() == 'found'){
          Swal.fire({
            icon: 'error',
            title: 'ペナルティがあるため、今週はリスケジュールが出来ません。',
            showConfirmButton:false
          })
           return false;
        }
       
        console.log('dayreschedule');

        Swal.disableButtons();
        Swal.getConfirmButton().removeAttribute('disabled');
         $('.dtp').removeAttr('Disabled');
         $('#res').show();
        $("#action_type").val('reschedule'); // form value

      }
       if($(this).val() == 'daycancle_schedule'){
        Swal.disableButtons();
        Swal.getCancelButton().removeAttribute('disabled');
        $('.dtp').attr('disabled', 'disabled' );
         $('#res').hide();
        $("#action_type").val('cancel'); // form value
      }
       if($(this).val() == '0'){
        Swal.disableButtons();
        $('.dtp').attr('disabled', 'disabled' );

      }


    });
    
</script>  
@endsection 