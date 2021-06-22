@extends('master_dashboard')
@section('title','trainer schedule')
@section('header_css_js')
<link href='{{ asset('asset_v2/css/fullcalendar_main.min.css')}}' rel='stylesheet' />
 


@endsection
@section('content')
<style>
  .current-time {
    background-color: rgba(20, 20, 20, 0.10);
    border-radius: 3px;
    color: #9B9B9B;
    position: relative;
    top: 2px;
    cursor: pointer;
}

  .table td,
  .table th {
    border: none !important;
  }
  .fc-theme-standard td{
    background: #fff;
  }

  .fc-button-active{
    background: #056fb8 !important;
  }
  /*.fc-myCustomButton-button{
    background: none !important;
    color: #a509a4 !important;
    border: 1px solid #a509a4 !important;
  }*/
/*  .fc-timegrid-event-harness{
z-index: 1;inset: 21px -2% -65px !important;
  }
  .fc-daygrid-event fc-daygrid-dot-event fc-event fc-event-start fc-event-end fc-event-past{

  }*/
      .fc-month-button{
    background: #056fb8 !important;
    color: #fff !important;
    border: 1px solid #056fb8 !important;
  }

  .tblue{
    background: blue !important;
    color:white !important;
  }
  .tred{
    background: red !important;
    color:white !important;
  }
  .green{
    background: green !important;
    color:white !important;
  }
  .swal2-styled.swal2-confirm{
      background-color: #a509a4

  }
  .swal2-styled.swal2-deny{
      background-color: #09951a;

  }
  .swal2-styled.swal2-cancel{
      background-color: #e93232;
  }
  .fc .fc-timegrid-slot{
    height:2.5em;
  }
  /*.fc .fc-bg-event{
    border:1px solid white;
    background: blue !important;
    opacity:1 !important;
  }*/
  .fc-highlight{
    background: none !important;
  }

</style>

    {{-- @include('pages.trainer.dashboard') --}}
<section class="review_part gray_bg section_padding">

  <div class="offset-md-1 col-md-10">

        @if(Session::has('message'))
        <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismiss">{!! Session::get('message') !!}</p>
        @endif

        @if(Session::has('errors_m'))
        <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-danger') }} alert-dismiss">{!! Session::get('errors_m') !!}</p>
        @endif


       

     {{--  <div class="row pb-5  page-content page-container" id="chart">

          <form action="{{route('trainerCalendar.submit')}}" method="post" id="dateform">
  		    {{ csrf_field() }}
  		    <input type="hidden" name="trainer_id" value="{{ Session::get('user') ? Session::get('user')->id : ''}}">
  		    <input type="hidden" name="selected_date" id="selected_date" value="">
  		</form>
      </div> --}}

      <div id='calendar'></div>
      <button type="submit" class="fc-myCustomButton-button fc-button fc-button-primary mt-2" type="button" style="float: right;font-size: 20px" onclick="document.getElementById('scheduleForm').submit();">登録</button>

          <input type="hidden" id="schedule" value="{{ $schedule}}">
          <input type="hidden" id="nschedule" value="{{ $nschedule}}">

  </div>

  <div class="offset-md-1 col-md-10 mt-30" id="scheduleList">

           <h4 class="" style="text-align: center;">詳細</h4>

    <table class="table table-striped" style="background: #f9f9ff;">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">ステータス</th>
        <th scope="col">日付</th>
        <th scope="col">開始時間</th>
        <th scope="col">ユーザー</th>
        <th scope="col">アクション</th>
      </tr>
    </thead>
    <tbody>
      @if($listSchedule)
        @foreach($listSchedule as $key=>$val)
          @if(!checkPastTIme1(\Carbon\Carbon::parse($val->time)->format('H:i'),\Carbon\Carbon::parse($val->date)->format('Y-m-d')))
          <tr>
            <td scope="row">{{ ++$key}}</td>
            <td >
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
                <a class="btn btn-info" {{ $val->is_occupied ? '' : 'disabled="disabled"'}} href="{{ route('userhistory',$val->user_id)}}"> ユーザー詳細</a>
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
          

                 <form action="{{ route('training',$parameter)}}" method="post" >
                        <input type="hidden" name="_schedulelist_" value="{{ $schedule}}">

                   {{ csrf_field() }}
                  <button type="submit"  class="btn btn-success" {{ $val->is_occupied ? '' : 'disabled="disabled"'}} > トレーニング開始 </button>
                </form>

              

              @if($val->status != 'cancelled')
              {{-- <a class="btn btn-danger" href="{{ route('trainerScheduleDelete',$val->id) }}">Delete</a> --}}
              @endif 
            </td>
          </tr>
          @endif
        @endforeach
      @endif
      
    </tbody>
  </table>
      <form action="{{route('schedule')}}" method="post" id="scheduleForm">
        {{ csrf_field() }}
        <input type="hidden" name="trainer_id" value="{{ Session::get('user')->id}}">
        <input type="hidden" name="date_array[]" id="selected_date">
        <input type="hidden" name="start_time"  id="selected_time">
        <input type="hidden" name="type"  id="action_type">
        <input type="hidden" name="gridView"  id="gridView">
        <input type="hidden" name="list"  id="list">
        <input type="hidden" name="event_type"  id="event_type">
        <input type="hidden" name="db_start_time"  id="db_start_time">
        <input type="hidden" name="db_schedule_id"  id="db_schedule_id">
        <input type="hidden" name="db_date"  id="db_date">
      </form>
</div>
</section>

<input type="hidden" name="dayGridspecific"  id="dayGridspecific" value="{{Session::get('dayGridspecific') ? Session::get('dayGridspecific') : 'FA'}}">
@endsection

@section('footer_css_js')

<script src='{{ asset('asset_v2/js/fullcalendar_main.min.js')}}'></script>
<script src='{{ asset('asset_v2/js/locales-all.js')}}'></script>
<script src='{{ asset('asset_v2/js/sweetalert2@10.js')}}'></script>


<script src="{{ asset('asset_v2/js/moment_2.29.1.min.js')}}" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>  
<script src="{{asset('asset_v2/js/bootstrap-datetimepicker.min.js')}}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

$(".tblue").click(function(){
  // Holds the product ID of the clicked element
  console.log($(this).attr('class'));


});
    var calendarEl = document.getElementById('calendar');
    var dateData = JSON.parse($(schedule).val());
    var nschedule = JSON.parse($('#nschedule').val());

    let a = [];

    var calendar = new FullCalendar.Calendar(calendarEl, {

      selectable: true,
      allDaySlot: false,
         showNonCurrentDates: false,
      fixedWeekCount:false,   
      contentHeight:"auto",
      initialView: '{{Session::get('gridView') ? Session::get('gridView') : $gridView}}',
      displayEventTime : false,
      // scrollTime:'01:00:00',
      slotDuration:'01:00:00',
    // firstDay: (new Date().getDay()), // returns the day number of the week, works! 

      views: {
        timeGridWeek: { // name of view
          dayHeaderFormat:{ weekday:'short', month: 'short', day: '2-digit' }
        }
      },

                customButtons: {
          week_all: {
            text: '週次定期予約',
            click: function() {
             window.location.href ='{{ route('calendar.view','week_all') }}';
            
            }
          },
          week: {
            text: '週次予約',
            click: function() {
             window.location.href ='{{ route('calendar.view','week') }}';
            
            }
          },
          month: {
            text: '月',
            click: function() {
             window.location.href ='{{ route('calendar.view','month') }}';
            
            }
          },
       },
      headerToolbar: {
        left: 'prev,next today month',
        center: 'title',
        right: 'week week_all',
         // right: 'dayGridMonth,timeGridWeek,timeGridDay'

      },
       eventDidMount: function(info) {



          $('.fc-event-title').each(function(){
          if($(this).text() === info.event.title && info.event.extendedProps.type === 'recurring'){
           if(info.event.extendedProps.exdate != null){
               if(info.event.extendedProps.exdate.split(",").includes($(this).parent().closest('td').attr("data-date"))){
                   $(this).parent().closest('a').css("display", "none");
               }
           }
          }
         });

        // console.log(info.event.extendedProps.exclude);
      },
       eventClick: function(info) {
        console.log(info);
        console.log('Event: ' + info.event.id);
        console.log('View: ' + info.view.type);
        console.log('date: ' + info.event.date_data);

        if(info.view.type === 'dayGridMonth'){
          $('#gridView').val('dayGridMonth');
           var dayname=moment(moment(info.event.start)).format('dddd');
            Swal.fire({
              title: '予定を変更しますか？',
              showDenyButton: false,
              showCancelButton: true,
              showConfirmButton: true,
              width: '650px',
              // html: "This week every day "+' at <input class="dtp" type="text"  readonly style="width:100px"> TO <input class="dtp2" type="text"  readonly style="width:100px">'
              // html: "<div class='row p-3'>" +dayname+ " day "+' at <input class="dtp ml-2 mr-2" type="text"  readonly style="width:100px"> TO <input class="dtp2 dtp ml-2 mr-2" type="text"  readonly style="width:100px"></div>'
              // +'<div class="row p-3 "><select class="form-control"  id="select_option">'
              //     +'<option value="reschedule"> Reschedule</option>'
              //     +'<option value="cancle_shedule"> Cancel Schedule</option>'
              // +'</select></div>'
              // ,
               html: "<div class='row p-3'>" + " 予約時間は  "
               +moment(info.event.start).format('YYYY-MM-DD')
               +' の '+moment(info.event.start).format('hh:mm A')+' から '+moment(info.event.start).add(60, 'minutes').format('hh:mm A')
               +'です。 </div>'
               +'<div class="row p-3 " id="res" style="display:none">'
               + '予約の変更は <input class="dtp ml-2 mr-2" type="text"  disabled="disabled" style="width:100px"> から <input class="dtp2  ml-2 mr-2" type="text"  disabled="disabled" style="width:100px">'
               +'です。</div>'
               +'<div class="row p-3 "><select class="form-control"  id="select_option" >'
              +'<option value="0">タイプを選択してください。</option>'
                  +'<option value="dayreschedule"> 予約を変更する</option>'
                  +'<option value="daycancle_schedule"> 予約をキャンセルする</option>'
              +'</select></div>'
              ,


              confirmButtonText: `予約を変更する`,
              denyButtonText: `詳細を確認する`,
              cancelButtonText: `予約をキャンセルする`,
              
              didOpen:function(){
                Swal.disableButtons();
                

                  $(".dtp").datetimepicker({
                    formatViewType: 'time',
                    fontAwesome: true,
                    autoclose: true,
                    startView: 1,
                    maxView: 1,
                    minView: 0,
                    minuteStep: 60,
                    format: 'HH:ii P',
                    showMeridian: true,

                });
              
                
                $(".dtp").val(moment(info.event.start).format('hh:mm A'));
                $(".dtp2").val(moment(info.event.start).add(60, 'minutes').format('hh:mm A'));
                
                $("#selected_time").val(moment(info.event.start).format('hh:mm A')); // form value
                $("#db_start_time").val(moment(info.event.start).format('hh:mm A')); // form value
                $("#action_type").val(''); // form value
                $("#event_type").val(info.event.extendedProps.type); // form value
                $("#db_schedule_id").val(info.event.id); // form value
                $("#db_date").val(moment(info.event.start).format('YYYY-MM-DD')); // form value

                $(".dtp").on("change.dp",function (e) {
                    let newtime = moment(this.value, 'hh:mm').add(60, 'minutes').format('hh:mm A');
                    $(".dtp2").val(newtime);
                    $("#selected_time").val(this.value);

                });
            }

            }).then((result) => {
              console.log(result);
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                $('#scheduleForm').submit();
              } else if (result.isDenied) {
                console.log('details view');
              }else{
                if(result.dismiss === 'cancel'){
                  $('#scheduleForm').submit();
                }
                console.log('he he he backdrop');
              }
          })
        }

       
        // change the border color just for fun
        // info.el.style.background = 'red';
      },

      events: dateData
      
    });

      calendar.render();
      calendar.setOption('locale', 'ja');


      // allDaySlot:false
      // calendar.select( 'allDay',false );
      // calendar.select( 'allDaySlot',false );

      // calendar.scrollToTime( '01:00');
      if($('#dayGridspecific').val() != 'FA' ){
                    calendar.changeView('timeGridDay',$('#dayGridspecific').val());
      }


    $(document).on('change','#select_option', function(e) {

      if($(this).val() == 'reschedule'){
        console.log();
        Swal.disableButtons();
        Swal.getConfirmButton().removeAttribute('disabled');
         $('.dtp').removeAttr('Disabled');
         $('#res').show();
        $("#action_type").val('weekupdate'); // form value

      }
       if($(this).val() == 'cancle_schedule'){
        Swal.disableButtons();
        Swal.getCancelButton().removeAttribute('disabled');
        $('.dtp').attr('disabled', 'disabled' );
         $('#res').hide();
        $("#action_type").val('weekcancel'); // form value
      }
       if($(this).val() == '0'){
        Swal.disableButtons();
        $('.dtp').attr('disabled', 'disabled' );

      }

      if($(this).val() == 'dayreschedule'){
        Swal.disableButtons();
        Swal.getConfirmButton().removeAttribute('disabled');
         $('.dtp').removeAttr('Disabled');
         $('#res').show();
        $("#action_type").val('dayupdate'); // form value

      }
       if($(this).val() == 'daycancle_schedule'){
        Swal.disableButtons();
        Swal.getCancelButton().removeAttribute('disabled');
        $('.dtp').attr('disabled', 'disabled' );
         $('#res').hide();
        $("#action_type").val('daycancel'); // form value
      }
       if($(this).val() == '0'){
        Swal.disableButtons();
        $('.dtp').attr('disabled', 'disabled' );

      }


    });

  });
  function getHourDiff(start,end){

      var startDTime = moment(start, "HH:mm:ss");
      var endDTime = moment(end, "HH:mm:ss");

      // calculate total duration
      var duration = moment.duration(endDTime.diff(startDTime));

      // duration in hours
      var hours = parseInt(duration.asHours());

      return hours;
  }

  function getAllDate(title,info){
    let selected = [];
    let datArray =title.split(' ');
    let firstDay=datArray[0]+' '+datArray[1];
    let startDay = moment(firstDay+', '+moment(info.dateStr).year(),'ll').format('YYYY-MM-DD');
    $("#selected_date").val("");

    if(info.view.type === 'timeGridDay'){
      for($i=0;$i<1;$i++){
          selected.push( moment(startDay, "YYYY-MM-DD").add($i, 'days').format('YYYY-MM-DD'));
      }
    }
    if(info.view.type === 'timeGridWeek'){
      for($i=0;$i<7;$i++){
          selected.push( moment(startDay, "YYYY-MM-DD").add($i, 'days').format('YYYY-MM-DD'));
      }
    }


    // console.log(selected);
    $("#selected_date").val((selected)); // form value
  }
  function isAnOverlapEvent(events, eventToCheck) {
    // Properties
    const resourceID = eventToCheck.id;
    console.log(events);
    console.log(resourceID);
    return true;
    // Moment.js objects
   

    // try {
    //     if (moment.isMoment(startMoment) && moment.isMoment(endMoment)) {
    //         // Filter Events by a specific resource
    //         const eventsByResource = events.filter(event => event.resourceId === resourceID);
    //         for (let i = 0; i < eventsByResource.length; i++) {
    //             const eventA = eventsByResource[i];
    //             if (moment.isMoment(eventA.start) && moment.isMoment(eventA.end)) {
    //                 // start-time in between any of the events
    //                 if (moment(startMoment).isAfter(eventA.start) && moment(startMoment).isBefore(eventA.end)) {
    //                     console.log("start-time in between any of the events")
    //                     return true;
    //                 }
    //                 //end-time in between any of the events
    //                 if (moment(endMoment).isAfter(eventA.start) && moment(endMoment).isBefore(eventA.end)) {
    //                     console.log("end-time in between any of the events")
    //                     return true;
    //                 }
    //                 //any of the events in between/on the start-time and end-time
    //                 if (moment(startMoment).isSameOrBefore(eventA.start) && moment(endMoment).isSameOrAfter(eventA.end)) {
    //                     console.log("any of the events in between/on the start-time and end-time")
    //                     return true;
    //                 }
    //             } else {
    //                 const error = 'Error, Any event on array of events is not valid. start or end are not Moment objects';
    //                 console.error(error);
    //                 throw new Error(error);
    //             }
    //         }
    //         return false;
    //     } else {
    //         const error = 'Error, start or end are not Moment objects';
    //         console.error(error);
    //         throw new Error(error);
    //     }
    // } catch (error) {
    //     console.error(error);
    //     throw error;
    // }
}

       
  //   events: [
    //   {
    //     start: "2020-12-06",
    //     allDay: true,
    //     display: 'background',
    //     color: "#00FFFF"

    //   }
    // ]
    // moment('2019-11-03T05:00:00.000Z').utc().format('hh:mm A')
    //'YYYY-MM-DD'
// $(document).on('change','#select_option', function(e) {

// });  // this works for static as well as content dynamically added in dom.
//     $('#select_option').change(function() {
//         console.log('The option with value ' + $(this).val() + ' and text ' + $(this).text() + ' was selected.');
//   });
</script>  
@endsection 