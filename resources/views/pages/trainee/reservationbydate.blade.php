@extends('master_dashboard')
@section('title','trainee schedule')
@section('header_css_js')
<script src="{{ asset('asset_v2/js/sweetalert.min.js')}}"></script>
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css"/>
<link href='{{ asset('asset_v2/css/fullcalendar_main.min.css')}}' rel='stylesheet' />
<script src='{{ asset('asset_v2/js/fullcalendar_main.min.js')}}'></script>
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
  .table td,
  .table th {
    border: none !important;
  }
 .parent {
display: grid;
grid-template-columns: .2fr repeat(4, 1fr);
grid-template-rows: 1fr;
grid-column-gap: 0px;
grid-row-gap: 0px;
}

.div1 { grid-area: 1 / 1 / 2 / 2; }
.div2 { grid-area: 1 / 2 / 2 / 3; }
.div3 { grid-area: 1 / 3 / 2 / 4; }
.div4 { grid-area: 1 / 4 / 2 / 5; }
.div5 { grid-area: 1 / 5 / 2 / 6; }
.boxd{

    padding: 25px;
    border: 1px solid #eee;
    background: #fff;

}
.timeboxd{
  text-align: right;
  margin-top:-10px;
}
.imgd{

background: #fff;
margin: 10px;
padding: 6px;
-moz-box-shadow:2px 21px 21px 10px rgba(0,0,0,0.08); 
-webkit-box-shadow: 2px 21px 21px 10px rgba(0,0,0,0.08); 
box-shadow: 2px 21px 21px 10px rgba(0,0,0,0.08);

}
.tname{

    font-weight: bold;
    color: #000;
    margin-top: 2px;

}
.badge{

    background: #11090a;
    padding: 6px;
    color: #fff;
    font-family: sans-serif;
    font-size:13px;

}

.blue{
  background: #318cff;
  color:#fff;
  text-align:center;
}
.red{
  background: #c30f23;
  color:#fff;
  text-align:center;
}
.silver{
  background: rgb(237 237 237);
}
</style>
{{-- @include('pages.trainee.dashboard') --}}
<section class="review_part gray_bg section_padding">


    <form action="{{route('trainerSubmitBytime')}}" method="post" id="timesbmit" style="display: inline-block;">
        {{ csrf_field() }}
        <input type="hidden" name="trainer_id" id="trainer_id">
        <input type="hidden" name="date" value="{{ $date}}">
        <input type="hidden" name="time" id="time">
    </form>

     <form action="{{route('traineeCalendar.submit')}}" method="post" id="dateform">
      {{ csrf_field() }}


      <input type="hidden" name="user_id" value="{{ Session::get('user')->id }}">

      <input type="hidden" name="selected_date" id="selected_date" value="">
    </form>
    
  <div class="container my-4">
    @if(Session::has('message'))
    <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismiss">{!! Session::get('message') !!}</p>
    @endif

    @if(Session::has('errors_m'))
    <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-danger') }} alert-dismiss">{!! Session::get('errors_m') !!}</p>
  @endif
  
      <div id='calendar'></div>
  <input type="hidden" id="schedule" value="{{ json_encode($data,true)}}">
  <input type="hidden" id="date_value" value="{{ $date }}">


        <div class="row justify-content-center">
          <div class="container">


            <div class="parent">

              <div class="div1 timeboxd">
                  @php 
                    $i=2;
                    $k=2;
                  @endphp
              </div>

              @if(isset($data))
              @php 
                $data = array_slice($data,0,4,true);
              @endphp
              @foreach($data as $key=>$val)
                <div class="div{{ $i}} text-center imgd">
                  <input type="hidden" value="{{ 'trainer_id:'.$val['trainer_id'] }}">
                    
                   @if($val['imagesurl'] != NULL)

                      <img  style="width:200px" src="{{asset('images').'/'.$val['imagesurl']}}" style="height: 200;width: 200" />
                    @else 

                      <img src="{{asset('images/user-thumb.jpg')}}" style="height: 200;width: 200">
                    @endif
                   <p class="tname">{{ $val['name']}}</p>
                </div>
              @php 
                $i++;
              @endphp  
              @endforeach  
              @endif
 
            </div>


            @for($i=0;$i<24;$i++)
            <div class="parent">
                <div class="div1 timeboxd "> 
                  <span class="badge"> {{ $i}} </span>
                </div>
                
                @if(isset($data))
                @foreach($data as $key=>$value)

                  @php 
                    $time = Carbon\Carbon::parse($i.':00:00')->format('H:i:s');
                    $time_array =  timeslot($value['trainer_id'],$date,$time);

                    
                    // echo(json_encode($time_array));
                  @endphp

                <div data-trainer="{{$value['trainer_id']}}" data-time="{{$time}}" class="div{{ $key+2 }} boxd {{ $time_array == 'not_found' ?  '' : (isset($time_array->is_occupied) && $time_array->is_occupied == 1 ? 'red' : 'blue') }} "> 
                     {{-- <p style="color:white">{{ 'trainer_id:'.$value['trainer_id'] }}</p> --}}
                    @if($time_array != 'not_found')
                     {{-- {{ array_key_exists_r($key,$time_array) }} --}}
                          {{ Carbon\Carbon::parse($time_array->time)->format('H:i'). " ~ ".Carbon\Carbon::parse($time_array->time)->addHour()->format('H:i') }}
                    @endif

                       

                 
                </div>


                @php 
                  $k++;
                @endphp  
                @endforeach
                @endif

            </div>
            @endfor

            

         
        </div>
      </div>
    
  </div>

  

</section>
<input type="hidden" id="schedule_info" >
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
      initialDate: $("#date_value").val(),

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
          html: ' <span> <img class="rounded-circle" title="'+arg.event.extendedProps.trainer_id+'" src="'+arg.event.extendedProps.imageurl+'" height="50" width="50" style="border:1px solid #007bff;" /></span>   '
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
$(".blue").click(function(){
  let trainer_id = $(this).attr("data-trainer"); 
  let time = $(this).attr("data-time");
  $("#trainer_id").val(trainer_id);
  $("#time").val(time);
  $("#timesbmit").submit();

});
  $(".hour-list").click(function() {

    $('.hour-list').removeClass('selected-background');
    $(this).addClass('selected-background');
    $('.hour-list').siblings('button').prop( "disabled", true );


    $("#schedule_info").val('');
    $("#schedule_info").val(this.id);
    $(this).siblings('button').prop( "disabled", false );

  });
</script>
@endsection