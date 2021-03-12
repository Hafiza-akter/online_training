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

    
  </div>

  <div id='calendar'></div>

 

</div>

</section>
@endsection
@section('footer_css_js')
<script src="{{ asset('asset_v2/js/moment_2.29.1.min.js')}}" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>  


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
                     window.location.href ='{{ route('traineeCalendar.view') }}';

      }
    });

    calendar.render();
  });
</script>
@endsection