@extends('master_dashboard')
@section('title','trainer schedule')
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

    {{-- @include('pages.trainer.dashboard') --}}
<section class="review_part gray_bg section_padding">

  <div class="offset-md-1 col-md-10">

        @if(Session::has('message'))
        <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismiss">{{ Session::get('message') }}</p>
        @endif

      <div class="row pb-5  page-content page-container" id="chart">

          <form action="{{route('trainerCalendar.submit')}}" method="post" id="dateform">
  		    {{ csrf_field() }}
  		    <input type="hidden" name="trainer_id" value="{{ Session::get('user') ? Session::get('user')->id : ''}}">
  		    <input type="hidden" name="selected_date" id="selected_date" value="">
  		</form>
      </div>

      <div id='calendar'></div>
      <input type="hidden" id="schedule" value="{{ $schedule}}">
  </div>

  <div class="offset-md-1 col-md-10 mt-30" id="scheduleList">

           <h4 class="" style="text-align: center;">サービスの特徴</h4>

    <table class="table table-striped" style="background: #f9f9ff;">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Date</th>
        <th scope="col">Available time</th>
        <th scope="col">User</th>
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
                <button class="btn btn-info" {{ $val->is_occupied ? '' : 'disabled="disabled"'}} > User Details</button>
              @else 
                <span> Not assigned yet </span>
              @endif
              
            </td>
            <td>
              <button class="btn btn-success" {{ $val->is_occupied ? '' : 'disabled="disabled"'}} >Start Course</button>
              <a class="btn btn-danger" href="{{ route('trainerScheduleDelete',$val->id) }}">Delete</a>
              <button class="btn btn-warning" {{ $val->is_occupied ? '' : 'disabled="disabled"'}}>Reschedule</button>
            </td>
          </tr>
        @endforeach
      @endif
      
    </tbody>
  </table>
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
            text: 'すべてのスケジュールリスト',
            click: function() {
             window.location.href ='#scheduleList';
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