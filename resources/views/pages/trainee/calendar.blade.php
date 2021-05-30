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
    color: #056fb8 !important;
    border: 1px solid #056fb8 !important;
  }
  .fc-myCustomButton2-button{
    background: none !important;
    color: #c30f23 !important;
    border: 1px solid #c30f23 !important;
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
      <a class="btn" href="{{ route('trainerlist') }}">トレーナー一覧</a>

    </div> --}}
  </div>


  <div class="offset-md-1 col-md-10 mt-30" id="scheduleList">

           <h4 class="" style="text-align: center;">スケジュール詳細</h4>

    <table class="table table-striped" style="background: #f9f9ff;">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">ステータス</th>
        <th scope="col">日時</th>
        <th scope="col">予約時間</th>
        <th scope="col">トレーナー</th>
        <th scope="col">コース開始</th>
      </tr>
    </thead>
    <tbody>
      @if($listSchedule)
        @foreach($listSchedule as $key=>$val)
            @php 
            
            $isToday=\Carbon\Carbon::parse($val->start_date)->isToday();
            $isPast=\Carbon\Carbon::parse($val->start_date)->isPast();
           
            @endphp

            @if(!checkPastTIme1(\Carbon\Carbon::parse($val->time)->format('H:i'),\Carbon\Carbon::parse($val->date)->format('Y-m-d')))
              <tr>
                <td scope="row">{{ ++$key}}</td>
                <td>
                  
                @if($val->is_occupied == 1)
                  @if($val->status === 'rescheduled')
                  <span class="btn-warning p-1"> {{ $val->status }}</span>
                  @endif

                  @if($val->status === 'cancelled')
                  <span class="btn-danger p-1"> {{ $val->status }}</span>
                  @endif
                  @if($val->status === 'completed')
                  <span class="btn-success p-1"> {{ $val->status }}</span>
                  @endif
                  @if($val->status === 'cancelled_penalty')
                  <span class="btn-red p-1"> {{ 'cancelled' }}</span>
                  @endif
                 @endif 
                </td>
                <td>{{ \Carbon\Carbon::parse($val->date)->format('Y-m-d')}}</td>
                <td>{{ \Carbon\Carbon::parse($val->time)->format('H:i')}}</td>
                <td>


                    @if($val->is_occupied )
                      <a class="btn btn-info"
                       {{ $val->is_occupied ? '' : 'disabled="disabled"'}} 
                       href="{{ route('trainerhistory',$val->trainer_id)}}" 
                       > トレーナー詳細</a>
                    @else 
                      <span> Not assigned yet </span>
                    @endif
                  
                </td>
                <td>
                  @php
                    $parameter =[
                    'id' =>$val->id,
                    ];
                    $parameter= \Crypt::encrypt($parameter);
                  @endphp
                  {{-- @if(!checkPastTIme(\Carbon\Carbon::parse($val->start_date)->format('Y-m-d'),\Carbon\Carbon::parse($val->time)->format('H:i:s'))) --}}

                  @if($val->status === NULL)
                <form action="{{ route('trainingtrainee',$parameter)}}" method="post" >
          
                   {{ csrf_field() }}
                  <button type="submit"  class="btn btn-success" {{ $val->is_occupied ? '' : 'disabled="disabled"'}} >トレーニング開始</button>
                </form>

                  @endif
                  {{-- @endif --}}
                  {{-- <a class="btn btn-danger" href="{{ route('trainerScheduleDelete',$val->id) }}">Delete</a> --}}
                  {{-- <button class="btn btn-warning" {{ $val->is_occupied ? '' : 'disabled="disabled"'}}>Reschedule</button> --}}
                </td>
              </tr>
              @endif
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
      showNonCurrentDates: false,
      fixedWeekCount:false,            

      firstDay: 0,

       customButtons: {
        myCustomButton: {
          text: 'トレーナー一覧',
          click: function() {
             window.location.href ='{{ route('trainerlist') }}';
          }
        },
        myCustomButton2: {
          text: 'トレーナー一予約',
          click: function() {
             window.location.href ='{{ route('reservation') }}';
          }
        }
      },
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'myCustomButton2,myCustomButton'
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
    calendar.setOption('locale', 'ja');
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