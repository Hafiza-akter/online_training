@extends('../../master')
@section('title','trainer schedule')
@section('content')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.js'></script>
<style>
  .table td,
  .table th {
    border: none !important;
  }
</style>
@include('pages.trainee.dashboard')
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


@endsection
@section('footer_css_js')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var dateData = JSON.parse($(schedule).val());

    var calendar = new FullCalendar.Calendar(calendarEl, {
      selectable: true,
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: ''
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