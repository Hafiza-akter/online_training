@extends('master_dashboard')
@section('title','trainee schedule')
@section('header_css_js')
<link href='{{ asset('asset_v2/css/fullcalendar_main.min.css')}}' rel='stylesheet' />
<script src='{{ asset('asset_v2/js/fullcalendar_main.min.js')}}'></script>
<script src="{{ asset('asset_v2/js/sweetalert.min.js')}}"></script>
@endsection
@section('content')

<style>
  .table td,
  .table th {
    border: none !important;
  }
  .fc-theme-standard td{
    background: #fff;
  }
  .fc-myCustomButton-button{
    background: none !important;
    color: #a509a4 !important;
    border: 1px solid #a509a4 !important;
  }
  .fc .fc-bg-event{
    opacity: 1 !important;
  }
  .disabled {
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
  .green{
    background: green !important;
    color:white !important;
  }
</style>
{{-- @include('pages.trainee.dashboard') --}}
<section class="review_part gray_bg section_padding">
<div class="offset-md-1 col-md-10">
          @if(Session::has('message'))
        <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismiss">{!! Session::get('message') !!}</p>
        @endif

        @if(Session::has('errors_m'))
        <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-danger') }} alert-dismiss">{!! Session::get('errors_m') !!}</p>
        @endif

  <div class="row pb-5  page-content page-container" id="chart">

    <form action="{{route('traineeCalendar.submit')}}" method="post" id="dateform">
      {{ csrf_field() }}


      @if(isset($_GET['trainer_id']) )
      <input type="hidden" name="trainer_id" value="{{ $_GET['trainer_id'] }}">
      @else
      <input type="hidden" name="user_id" value="{{ Session::get('user')->id }}">
      @endif

      <input type="hidden" name="event_type" id="event_type" value="">
      <input type="hidden" name="selected_date" id="selected_date" value="">
    </form>
  </div>

  <div id='calendar'></div>
  <input type="hidden" id="schedule" value="{{ $schedule}}">

  <div class="row mb-5 mt-3">
    {{-- <div class="offset-sm-4 col-sm-4 border-round">
      <a class="btn" href="{{ route('trainerlist') }}">トレーナーリスト </a>

    </div> --}}
  </div>


  <div class="offset-md-1 col-md-10 mt-30" id="scheduleList">

           <h4 class="" style="text-align: center;">サービスの特徴</h4>

    <table class="table table-striped" style="background: #f9f9ff;">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Date</th>
        <th scope="col">Available time</th>
        <th scope="col">Trainer</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      @if($listSchedule)
        @foreach($listSchedule as $key=>$val)
          <tr>
            <th scope="row">{{ ++$key}}</th>
            <td>{{ \Carbon\Carbon::parse($val->start_date)->format('d/m/Y')}}</td>
            <td>{{ \Carbon\Carbon::parse($val->time)->format('g:i A')}}</td>
            <td>
              @if($val->is_occupied )
                <button class="btn btn-info" {{ $val->is_occupied ? '' : 'disabled="disabled"'}} > Trainer Details</button>
              @else 
                <span> Not assigned yet </span>
              @endif
              
            </td>
            <td>
              <a href="{{ route('trainingtrainee',$val->id)}}" class="btn btn-success" {{ $val->is_occupied ? '' : 'disabled="disabled"'}} >Join Course</a>
              {{-- <a class="btn btn-danger" href="{{ route('trainerScheduleDelete',$val->id) }}">Delete</a> --}}
              {{-- <button class="btn btn-warning" {{ $val->is_occupied ? '' : 'disabled="disabled"'}}>Reschedule</button> --}}
            </td>
          </tr>
        @endforeach
      @endif
      
    </tbody>
  </table>
</div>
</div>

</section>
@endsection
@section('footer_css_js')
<script src="{{ asset('asset_v2/js/moment_2.29.1.min.js')}}" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>  


<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var dateData = JSON.parse($(schedule).val());
    // var trainingDay = JSON.parse($('#trainingDay').val());
    // var datePlan = $('#datePlan').val();


    console.log(dateData);
    var calendar = new FullCalendar.Calendar(calendarEl, {
      selectable: false,
       customButtons: {
        myCustomButton: {
          text: 'トレーナーリスト',
          click: function() {
             window.location.href ='{{ route('trainerlist') }}';
          }
        }
      },
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'myCustomButton'
      },
      eventDidMount: function(info) {


        if( info.event.extendedProps.type === 'disabled'){
           info.el.disabled = "true";
        }
   
      },
      eventClick:function(info){
        console.log('hello me');

      },
      dateClick: function(info) {

        console.log( $(info.dayEl).find('.fc-bg-event').attr('data-type'));
        
        $("#selected_date").val('');
        $("#event_type").val('');
        $("#event_type").val($(info.dayEl).find('.fc-bg-event').attr('data-type'));
        $("#selected_date").val(info.dateStr);
        // $("#selected_date").val(info);
        console.log(info);
        // if($(info.dayEl).find('.fc-bg-event').attr('data-type') == 'normal' || $(info.dayEl).find('.fc-bg-event').attr('data-type') == 'recurring') {
                     $('#dateform').submit();

        // }else{
        //   alert('Please select a valid day');
        // }
      },
      // select: function(info) {
      //   // alert('selected ' + info.startStr + ' to ' + info.endStr);
      // },
      eventDidMount: function(info){
        // console.log(info);
          info.el.setAttribute("data-type",info.event.extendedProps.type );
          // info.el.setAttribute("class",'tblue' );


      },
      select: function (start, end, jsEvent, view) {
            
          
        },

      events: dateData
    });

    calendar.render();
  });

  //   events: [
  //   {
  //     start: "2020-12-06",
  //     allDay: true,
  //     display: 'background',
  //     color: "#00FFFF"

  //   }
  // ]
</script>
@endsection