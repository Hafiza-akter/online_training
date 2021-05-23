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
  .fc-daygrid-event-harness{display:inline-flex; }

</style>
{{-- @include('pages.trainee.dashboard') --}}
<section class="review_part gray_bg section_padding">
<div class="container my-4 offset-md-1 col-md-10">
        @if(Session::has('message'))
        <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismiss">{!! Session::get('message') !!}</p>
        @endif

        @if(Session::has('errors_m'))
        <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-danger') }} alert-dismiss">{!! Session::get('errors_m') !!}</p>
        @endif
        @php
            $param1=encryptionValue(['sorting' => 'favourite']);
            $param2=encryptionValue(['sorting' => 'history']);
            $param3=encryptionValue(['sorting' => 'recommended']);
            $param4=encryptionValue(['sorting' => '00:00:00-06:00:00']);
            $param5=encryptionValue(['sorting' => '06:00:00-12:00:00']);
            $param6=encryptionValue(['sorting' => '12:00:00-18:00:00']);
            $param7=encryptionValue(['sorting' => '18:00:00-24:00:00']);
        @endphp
<div class="row content-justify-center ">
  <div class="col mb-3">
    <a  href="{{ route('sorting',$param1)}}" class="sorting-button p-3 {{ !empty($sorting) &&  $sorting == 'favourite' ? 'active-sorting' : ''}}  "> お気に入り </a>
  </div>

  <div class="col">
      <a  href="{{ route('sorting',$param2)}}" class="sorting-button  p-3 {{ !empty($sorting) &&  $sorting == 'history' ? 'active-sorting' : ''}} "> 歴史 </a>
  </div>

  <div class="col">
      <a  href="{{ route('sorting',$param3)}}" class="sorting-button  p-3 {{ !empty($sorting) &&  $sorting == 'recommended' ? 'active-sorting' : ''}} "> 勧める </a>
  </div>
</div>

<div class="row content-justify-center ">
  <div class="col">
    <a  href="{{ route('sorting',$param4)}}" class="sorting-button {{ !empty($sorting) &&  $sorting == '00:00:00-06:00:00' ? 'active-sorting' : ''}} "> 0.00 - 6.00 </a>
  </div>

  <div class="col">
      <a  href="{{ route('sorting',$param5)}}" class="sorting-button {{ !empty($sorting) &&  $sorting == '06:00:00-12:00:00' ? 'active-sorting' : ''}}"> 6.00 - 12.00  </a>
  </div>

  <div class="col">
      <a  href="{{ route('sorting',$param6)}}" class="sorting-button {{ !empty($sorting) &&  $sorting == '12:00:00-18:00:00' ? 'active-sorting' : ''}}"> 12.00 - 18.00 </a>
  </div>
    <div class="col">
      <a  href="{{ route('sorting',$param7)}}" class="sorting-button {{ !empty($sorting) &&  $sorting == '18:00:00-24:00:00' ? 'active-sorting' : ''}}"> 18.00 - 24.00 </a>
  </div>
</div>
  
  <form action="{{route('traineeCalendar.submit')}}" method="post" id="dateform">
      {{ csrf_field() }}


      <input type="hidden" name="user_id" value="{{ Session::get('user')->id }}">

      <input type="hidden" name="selected_date" id="selected_date" value="">
    </form>

  <div id='calendar'></div>
  <input type="hidden" id="schedule" value="{{ $schedule}}">

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
             window.location.href ='{{ route('reservation') }}';
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

      eventContent: function(arg) {
        console.log(arg.event.extendedProps);
        return {
          html: ' <span> <img class="rounded-circle" src="'+arg.event.extendedProps.imageurl+'" height="27" width="27" style="border:1px solid #007bff;" /></span>   '
        }
      },
      eventClick:function(info){
        console.log('hello me');

      },
      dateClick: function(info) {
        $("#selected_date").val('');
        $("#selected_date").val(info.dateStr);
        console.log(info);
        $('#dateform').submit();
     
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