@extends('auth/master')
@section('title','trainer schedule')
@section('content')
  <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.css' rel='stylesheet' />
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.js'></script>
    <style>
    	.table td, .table th{
    		border:none !important;
    	}
    </style>
    @include('pages.trainer.dashboard')
    <div class="row pb-5  page-content page-container" id="chart">

        <form action="{{route('trainerCalendar.submit')}}" method="post" id="dateform">
		    {{ csrf_field() }}
		    <input type="hidden" name="trainer_id" value="{{ Session::get('user') ? Session::get('user')->id : ''}}">
		    <input type="hidden" name="selected_date" id="selected_date" value="">
		</form>
    </div>

              <div id='calendar'></div>
              <input type="hidden" id="schedule" value="{{ $schedule}}">
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