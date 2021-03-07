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
    <div class="row pb-5">
      <h2 class="mx-auto">オンラー</h2>
    </div>
    <div class="row pb-3">
      <div class="col-sm border-round">
        <a class="btn">ログイン </a>       
      </div>
      <div class="col-sm border-round">
        <a class="btn">ログイン </a>       
      </div>
      <div class="col-sm border-round">
        <a class="btn">ログイン </a>       
      </div>
      <div class="col-sm border-round">
        <a class="btn">ログイン </a>       
      </div>
    </div>
    <div class="row mb-5">
      <div class="offset-sm-4 col-sm-4 border-round">
        <a class="btn">ログイン </a> 
     </div>
    </div>
    <div class="row pb-5  page-content page-container" id="chart">

        <form action="{{route('trainerSelectedDateTime.submit')}}" method="post" id="dateform">
		    {{ csrf_field() }}
		    <input type="hidden" name="trainer_id" value="{{ Session::get('user') ? Session::get('user')->id : ''}}">
		    <input type="hidden" name="date" id="selected_date" value="">
		    <input type="hidden" name="start_time"  id="selected_time" value="">
		</form>
    </div>

              <div id='calendar'></div>

  @endsection
  @section('footer_css_js')

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      selectable: true,
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: ''
      },
      dateClick: function(info) {
        alert('clicked ' + info.dateStr);
      },
      select: function(info) {
        alert('selected ' + info.startStr + ' to ' + info.endStr);
      }
    });

    calendar.render();
  });
</script>  
@endsection 