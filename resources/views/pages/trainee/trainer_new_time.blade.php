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

        <form action="{{route('trainerlistviatime')}}" method="post" id="dateform">
            {{ csrf_field() }}
            <input type="hidden" name="user_id" value="{{ Session::get('user') ? Session::get('user')->id : ''}}">
            <input type="hidden" name="selected_date" id="selected_date" value="{{ $selected_date}}">
            <input type="hidden" name="event_type" id="event_type" value="{{$event_type}}">
            {{-- <input type="hidden" name="trainer_id" id="trainer_id" value="{{$trainer_id}}"> --}}
            <input type="hidden" name="start_time" id="start_time" value="">
        </form>
      </div>

      <div id='calendar'></div>
      <button  class="fc-myCustomButton-button fc-button fc-button-primary mt-2" type="button" style="float: right;font-size: 20px" onclick="document.getElementById('scheduleForm').submit();">登録</button>
      <button  class="fc-myCustomButton-button fc-button fc-button-primary mt-2 btn-danger" type="button" id="scheduleDeletebtn" style="margin-right: 10px;display:none; float: right;font-size: 20px" onclick="document.getElementById('scheduleDelete').submit();">削除</button>

        <input type="hidden" id="schedule" value="{{ $schedule}}">
  </div>
</section>

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

      eventClick:function(info){
        console.log(info.event.extendedProps);
        if(info.event.extendedProps.is_occupied == 1){
            return false;
        }
        let startTime = info.event.extendedProps.startTime;
        let endTime = info.event.extendedProps.endTime;
        $("#start_time").val(info.event.extendedProps.startTime);
        $("#schedule_id").val(info.event.id);

        $('#dateform').submit();
           
      },

      events: dateData
     
    });

      calendar.render();
      calendar.setOption('locale', 'ja');
});

    
</script>  
@endsection 