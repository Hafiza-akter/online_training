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
  .fc-daygrid-more-link{
    display:none;
  }
.radios .radio {
    background-color: #c5e043;
    display: inline-block;
    width: 10px;
    height: 10px;
    cursor: pointer;
}

.radios input[type=radio] {
    display: none;
}

.radios input[type=radio]:checked + .radio {
    background-color: #241009;
}
.fc-direction-ltr .fc-daygrid-event.fc-event-end, .fc-direction-rtl .fc-daygrid-event.fc-event-start{
  margin:0px;
  
}
.fc-direction-ltr .fc-daygrid-event.fc-event-start, .fc-direction-rtl .fc-daygrid-event.fc-event-end{
  margin:0px;
}
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
            // $param1=encryptionValue(['sorting' => 'favourite']);
            // $param2=encryptionValue(['sorting' => 'history']);
            // $param3=encryptionValue(['sorting' => 'recommended']);
            // $param4=encryptionValue(['sorting' => '00:00:00-06:00:00']);
            // $param5=encryptionValue(['sorting' => '06:00:00-12:00:00']);
            // $param6=encryptionValue(['sorting' => '12:00:00-18:00:00']);
            // $param7=encryptionValue(['sorting' => '18:00:00-24:00:00']);   

            $param1= 'favourite';
            $param2= 'history';
            $param3= 'recommended';
            $param4= '00:00:00-06:00:00';
            $param5= '06:00:00-12:00:00';
            $param6= '12:00:00-18:00:00';
            $param7= '18:00:00-24:00:00';

        
        @endphp
<div class="row content-justify-center ">



  <div class="col px-1 mb-3" >
    <p   data-sort="{{ $param1 }}"  style="cursor: pointer" class=" sort sorting-button p-3 {{ !empty($sorting) &&  $sorting == 'favourite' ? 'active-sorting' : ''}}  "> お気に入り </p>
  </div>

  <div class="col px-1" >
      <p  data-sort="{{ $param2 }}"  class="pointer sort sorting-button  p-3 {{ !empty($sorting) &&  $sorting == 'history' ? 'active-sorting' : ''}} "> 履歴 </p>
  </div>

  <div class="col px-1" >
      <p  data-sort="{{ $param3 }}"  class="pointer sort sorting-button  p-3 {{ !empty($sorting) &&  $sorting == 'recommended' ? 'active-sorting' : ''}} "> おすすめ </p>
  </div>
</div>

<div class="row content-justify-center ">
  <div class="col px-1">
    <p  data-sort="{{ $param4 }}"  class="pointer sort2 sorting-button {{ !empty($sorting2) &&  $sorting2 == '00:00:00-06:00:00' ? 'active-sorting' : ''}} "> 0.00 - 6.00 </p>
  </div>

  <div class="col px-1" >
      <p  data-sort="{{ $param5 }}"  class="pointer sort2 sorting-button {{ !empty($sorting2) &&  $sorting2 == '06:00:00-12:00:00' ? 'active-sorting' : ''}}"> 6.00 - 12.00  </p>
  </div>

  <div class="col px-1" >
      <p   data-sort="{{ $param6 }}"  class="pointer sort2 sorting-button {{ !empty($sorting2) &&  $sorting2 == '12:00:00-18:00:00' ? 'active-sorting' : ''}}"> 12.00 - 18.00 </p>
  </div>
    <div class="col px-1" >
      <p   data-sort="{{ $param7 }}"  class="pointer sort2 sorting-button {{ !empty($sorting2) &&  $sorting2 == '18:00:00-24:00:00' ? 'active-sorting' : ''}}"> 18.00 - 24.00 </p>
  </div>
</div>
<form action="{{route('sorting')}}" method="post" id="sortform">
      {{ csrf_field() }}

  <input type="hidden" name="sorting" id="active_sort" value="{{ isset($sorting) &&  $sorting ? $sorting : ''}}">
  <input type="hidden" name="sorting2" id="active_sort2" value="{{ isset($sorting2) &&  $sorting2 ? $sorting2 :''}}">

</form>

  <form action="{{route('traineeCalendar.submit')}}" method="post" id="dateform">
      {{ csrf_field() }}


      <input type="hidden" name="user_id" value="{{ Session::get('user')->id }}">

      <input type="hidden" name="selected_date" id="selected_date" value="">
      <input type="hidden" name="sorting"  value="{{ isset($sorting) &&  $sorting ? $sorting : ''}}">
      <input type="hidden" name="sorting2" value="{{ isset($sorting2) &&  $sorting2 ? $sorting2 :''}}">

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
      dayMaxEvents:4,
      firstDay: 0,
        height: 650,

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
        right: ''
      },
      eventDidMount: function(info) {


          if( info.event.extendedProps.type === 'disabled'){
           info.el.disabled = "true";
        }
   
      },

      eventContent: function(arg) {
        // console.log(arg.event.extendedProps);
        return {
          html: ' <span> <img class="rounded-circle" title="'+arg.event.extendedProps.name+" ("+arg.event.extendedProps.trainer_id+')" src="'+arg.event.extendedProps.imageurl+'" height="40" width="40" style="border:1px solid #007bff;" /></span>   '
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
  $(".sort").click(function(){

    let string="";
    if($(this).hasClass( "active-sorting" )){

      $('.sort')
      .removeClass("active-sorting");

    }else{

      $(this)
      .addClass('active-sorting');
       string=$(this)
      .attr('data-sort');

    }

    

    

   


    $('#active_sort').val();
    $('#active_sort').val(string);

      // var d = $('.mumu').map((_,el) => el.value).get();
      // console.log(d);
      $("#sortform").submit();
  });

  $(".sort2").click(function(){
    let string="";

    if($(this).hasClass( "active-sorting" )){

      $('.sort2')
      .removeClass("active-sorting");

    }else{

      $(this)
      .addClass('active-sorting');
       string=$(this)
      .attr('data-sort');

    }

    

    $('#active_sort2').val();
    $('#active_sort2').val(string);
    $("#sortform").submit();

  });

</script>
@endsection