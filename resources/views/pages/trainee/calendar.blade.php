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
</style>
{{-- @include('pages.trainee.dashboard') --}}
<section class="review_part gray_bg section_padding">
<div class="offset-md-1 col-md-10">

  <div class="row pb-5  page-content page-container" id="chart">

    <form action="{{route('traineeCalendar.submit')}}" method="post" id="dateform">
      {{ csrf_field() }}


      @if(isset($_GET['trainer_id']) )
      <input type="hidden" name="trainer_id" value="{{ $_GET['trainer_id'] }}">
      @else
      <input type="hidden" name="user_id" value="{{ Session::get('user')->id }}">
      @endif

      <input type="hidden" name="selected_date" id="selected_date" value="">
    </form>
  </div>

  <div id='calendar'></div>
  <input type="hidden" id="schedule" value="{{ $schedule}}">

  <div class="row mb-5 mt-3">
    <div class="offset-sm-4 col-sm-4 border-round">
      <a class="btn" href="{{ route('trainerlist') }}">トレーナーリスト </a>

    </div>
  </div>
</div>

</section>
@endsection
@section('footer_css_js')


<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var dateData = JSON.parse($(schedule).val());

    var calendar = new FullCalendar.Calendar(calendarEl, {
      selectable: true,
       customButtons: {
        myCustomButton: {
          text: 'トレーナーリスト',
          click: function() {
            alert('clicked the custom button!');
          }
        }
      },
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'myCustomButton'
      },
      dateClick: function(info) {
        // alert('clicked ' + info.dateStr);
        $("#selected_date").val('');
        $("#selected_date").val(info.dateStr);
        // $("#selected_date").val(info);
        console.log(info);
        $('#dateform').submit();
      },
      select: function(info) {
        // alert('selected ' + info.startStr + ' to ' + info.endStr);
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