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


  .fc-week_all-button{
    background: #a50ca4 !important;
    color: #fff !important;
    border: 1px solid #a509a4 !important;
  }
/*  .fc-timegrid-event-harness{
z-index: 1;inset: 21px -2% -65px !important;
  }
  .fc-daygrid-event fc-daygrid-dot-event fc-event fc-event-start fc-event-end fc-event-past{

  }*/
  .tblue{
    background: blue !important;
    opacity: 1 !important;
    color:white !important;
    border: 1px solid #ddd;
  }
  .exclude{
    display: none !important;
    opacity: 0 !important;
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
  .tblue1{
    background: blue !important;
    opacity: .4 !important;
    color:white !important;
    /*border: 1px solid #ddd;*/
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

        <div class="row justify-content-center">
            <div class="col-md-8 col-xl-6">
                <div class="section_tittle">
                    <h3>毎週のスケジュールを一斉登録できます。</h3>
                </div>
            </div>
        </div>

      <div id='calendar'></div>
      <button  class="fc-myCustomButton-button fc-button fc-button-primary mt-2" type="button" style="float: right;font-size: 20px" onclick="document.getElementById('scheduleForm').submit();">登録</button>
      <button  class="fc-myCustomButton-button fc-button fc-button-primary mt-2 btn-danger" type="button" id="scheduleDeletebtn" style="margin-right: 10px;display:none; float: right;font-size: 20px" onclick="document.getElementById('scheduleDelete').submit();">削除</button>

          <input type="hidden" id="schedule" value="{{ $schedule}}">

  </div>

  <div class="offset-md-1 col-md-10 mt-30" id="scheduleList">

           <h4 class="" style="text-align: center;">詳細</h4>

    <table class="table table-striped" style="background: #f9f9ff;">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">ステータス</th>
        <th scope="col">日付</th>
        <th scope="col">開始時刻</th>
        <th scope="col">ユーザー</th>
        <th scope="col">アクション</th>
      </tr>
    </thead>
    <tbody>
      @if($listSchedule)
        @foreach($listSchedule as $key=>$val)
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
                <span class="btn-green p-1"> {{ $val->status }}</span>
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
              <a class="btn btn-success"  href="{{ route('training',$parameter)}}"> トレーニング詳細</a>
              @if($val->status != 'cancelled')
              {{-- <a class="btn btn-danger" href="{{ route('trainerScheduleDelete',$val->id) }}">Delete</a> --}}
              @endif 
            </td>
          </tr>
        @endforeach
      @endif
      
    </tbody>
  </table>
      <form action="{{route('schedule')}}" method="post" id="scheduleForm">
        {{ csrf_field() }}
        <input type="hidden" name="trainer_id" value="{{ Session::get('user')->id}}">
        <input type="hidden" name="start_time"  id="selected_time">
        <input type="hidden" name="type"  id="action_type">
        <input type="hidden" name="gridView"  id="gridView">
        <input type="hidden" name="list"  id="list">

        <input type="hidden" name="db_start_time"  id="db_start_time">
        <input type="hidden" name="db_schedule_id"  id="db_schedule_id">
        <input type="hidden" name="db_date"  id="db_date">
      </form>

       <form action="{{route('scheduleDelete')}}" method="post" id="scheduleDelete" >
        {{ csrf_field() }}
        <input type="hidden" name="trainer_id" value="{{ Session::get('user')->id}}">
        <input type="hidden" name="dlist"  id="dlist">
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
<script src="{{asset('asset_v2/js/rrule.min.js')}}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

$(".tblue").click(function(){
  // Holds the product ID of the clicked element
  console.log($(this).attr('class'));


});
    var calendarEl = document.getElementById('calendar');
    var dateData = JSON.parse($(schedule).val());
    console.log(dateData[0]);
    let a = [];
    let selectedEvent = [];

    var calendar = new FullCalendar.Calendar(calendarEl, {

      selectable: true,
      allDaySlot: false,
   eventLongPressDelay:900,
      contentHeight:"auto",
      initialView: 'timeGridWeek',
      displayEventTime : false,
      // scrollTime:'01:00:00',
      slotDuration:'01:00:00',
    // firstDay: (new Date().getDay()), // returns the day number of the week, works! 

      views: {
        timeGridWeek: { // name of view
          dayHeaderFormat:{ weekday:'short' }
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
        left: 'month',
        center: '',
        right: 'week week_all',
         // right: 'dayGridMonth,timeGridWeek,timeGridDay'

      },

      dateClick: function(info) {
        // // alert('clicked ' + info.dateStr);
        // $("#selected_date").val('');
        // $("#selected_date").val(info.dateStr);
        //         console.log(info);

        // // $('#dateform').submit();
        if(info.view.type === 'dayGridMonth'){
            calendar.changeView('timeGridDay',info.dateStr);
          }
      },
      // selectAllow:function(info){
      //   console.log(info.startStr);
      //   if(info.startStr == "2021-02-07T00:00:00+06:00"){
      //     console.log('true');
      //     return true;
      //   }
      //   if(info.endStr == "2021-02-07T03:00:00+06:00"){

      //      return true;
      //   }
      //   // return true;

      //   $('.fc-timegrid-slot-lane').each(function(){
      //       console.log($(this).attr('data-time'));
      //       if($(this).attr('data-time') === '00:00:00'){
      //         $(this).css("background", "red");
      //         // $(this)(".fc-highlight").css("background", "yellow");
      //       }
      //    });
      //   // return true;
      // },
      // selectOverlap: function() {
      //   return false;
      // },
      select: function(info) {

          var evts = calendar.getEvents(); //get all in-memory events
          

          // let title=$(".fc-toolbar-title").text();
          // var numbers = title.match(/\d+/g).map(Number);


          // let startDate = moment(numbers[0]+"-"+numbers[1]+"-"+numbers[2], "YYYY-MM-DD");
          // let endDate = moment(numbers[0]+"-"+numbers[1]+"-"+numbers[3], "YYYY-MM-DD");
          let startDate = moment(info.startStr, "YYYY-MM-DD");
          let endDate = moment(info.endStr, "YYYY-MM-DD");
          if(moment(info.endStr).format('HH:mm:ss') == '00:00:00'){
            endDate=startDate;
          }
          let dateDiff = moment.duration(endDate.diff(startDate)).asDays();

          console.log(moment(info.endStr).format('HH:mm:ss'));
          console.log('Date diff '+dateDiff);

          let startTime = moment(info.startStr).format('HH:mm:ss');
          let endTime = moment(info.endStr).format('HH:mm:ss');
           if(endTime == '00:00:00'){
             endTime="24:00:00";
            console.log(endTime);
          }
          // calculation the hour diffierence
          let hrDiff = getHourDiff(startTime,endTime);
          // let incr= moment(startTime, "HH:mm:ss").add(1, 'hours').format('HH:mm:ss');
          // let dincr=moment(startDate, "YYYY-MM-DD").add(1, 'days').format('YYYY-MM-DD');

          // console.log(dincr+"T"+startTime);
          for(i=0;i<hrDiff;i++){

              let sT= moment(startTime, "HH:mm:ss").add(i, 'hours').format('HH:mm:ss');
              let eT= moment(startTime, "HH:mm:ss").add(i+1, 'hours').format('HH:mm:ss');
              let sTl= moment(startTime, "HH:mm:ss").add(i, 'hours').format('HH');
              if(eT == '00:00:00'){
                 eT="24:00:00";
                console.log(endTime);
              }
              for(j=0;j<=dateDiff;j++){


                let dincr=moment(startDate, "YYYY-MM-DD").add(j, 'days').format('YYYY-MM-DD');
              
                  

                  if($("."+dincr+sTl)[0]){
                    let dKdate = moment(dincr); // Thursday Feb 2015
                    let dow = dKdate.day();
                    console.log('already added');
                    // console.log(calendar.getEventById("-"+dincr+sTl+"-").extendedProps.type);
                    calendar.getEventById("-"+dincr+sTl+"-").remove();
                    var index = a.findIndex(function(o){
                      return o.id === "-"+dincr+sTl+"-";
                    })
                    if (index !== -1) a.splice(index, 1);


                    // if(isSelectedEvent(evts, dincr,sT) != 'False'){

                    //   var index2 = selectedEvent.findIndex(function(o){
                    //    return o === isSelectedEvent(evts, dincr,sT);
                    //   })
                    //   if (index2 !== -1) selectedEvent.splice(index2, 1);
                    // }

                      // selectedEvent.push(item);
                      // var index2 = selectedEvent.findIndex(function(o){
                      //  return o.id === check_time_already_exist(sT,dow,selectedEvent);
                      // })
                      // if (index2 !== -1) selectedEvent.splice(index2, 1);

                       dateData.filter(function (match) { 
                       if( match.startTime == sT && parseInt(match.daysOfWeek[0]) == dow){
                          // return console.log(match.id);
                          selectedEvent.pop(match);
                         }
                      });

                  }else{
                    let dKdate = moment(dincr); // Thursday Feb 2015
                    let dow = dKdate.day();
                    let item={
                        "title": sT + "-"+ eT,
                        'daysOfWeek': [ dow ], // these recurrent events move separately
                        'startTime': sT,
                        'endTime': eT,
                        // color: 'red',
                        'startRecur':dincr,
                        // 'endRecurr':dincr,
                        "title": "",
                        "id": "-"+dincr+sTl+"-",
                        "unique_id": "-"+dincr+sTl+"-",
                        // 'extendedProps': {
                        //   'type': 'recurring'
                        // },
                        "className": ["tblue1", dincr+sTl],
                        "textColor": "#ffffff",
                        display: 'background'

                    };

                

                    dateData.filter(function (match) { 
                     if( match.startTime == sT && parseInt(match.daysOfWeek[0]) == dow){
                        // return console.log(match.id);
                        match.db_date="Nan";
                        selectedEvent.push(match);
                       }
                    });
                   calendar.addEvent(item);
                   a.push(item);

                    // if(isSelectedEvent(evts, dincr,sT) != 'False'){
                    //   selectedEvent.push(parseInt(isSelectedEvent(evts, dincr,sT)));
                    // }

                   }

                   
            }
          }
          $("#action_type").val('');
          $("#list").val('');
          $("#list").val(JSON.stringify(a));
          $("#action_type").val('recuring_event');

          if(selectedEvent.length > 0){
            $("#dlist").val(JSON.stringify(selectedEvent));
            $("#scheduleDeletebtn").show();
          }else{
            $("#scheduleDeletebtn").hide();
          }

          
        

          console.log(info.view.type);
          console.log(a);
          console.log(selectedEvent.filter(onlyUnique));
          
        console.log('selected ' + info.startStr + ' to ' + info.endStr);
        // console.log(info);
        // find out all the date of the week
        // push to date array
        // let title=$(".fc-toolbar-title").text();
        // getAllDate(title,info);


        // Swal.fire({
        //   title: '本気ですか ？',
        //   showDenyButton: false,
        //   html: msg+' at <input class="" type="text" id="datetimepicker" readonly style="width:100px"> TO <input class="" type="text" id="datetimepicker2" readonly style="width:100px">',
        //   showCancelButton: true,
        //   confirmButtonText: `Save`,
        //   width: '650px',
        //   denyButtonText: `Don't save`,
        //   didOpen:function(){
                   
        //     $("#datetimepicker").datetimepicker({
        //         formatViewType: 'time',
        //         fontAwesome: true,
        //         autoclose: true,
        //         startView: 1,
        //         maxView: 1,
        //         minView: 0,
        //         minuteStep: 60,
        //         format: 'HH:ii P',
        //         showMeridian: true,

        //     });
            

        //     $("#datetimepicker").val(moment(info.startStr).format('hh:mm A'));
        //     $("#datetimepicker2").val(moment(info.startStr).add(60, 'minutes').format('hh:mm A'));
            
        //     $("#selected_time").val(moment(info.startStr).format('hh:mm A')); // form value
        //     $("#action_type").val('weekinsert'); // form value

        //     $("#datetimepicker").on("change.dp",function (e) {
        //         let newtime = moment(this.value, 'hh:mm').add(60, 'minutes').format('hh:mm A');
        //         $("#datetimepicker2").val(newtime);
        //         $("#selected_time").val(this.value);

        //       });
        //   }
        // }).then((result) => {
        //   if (result.isConfirmed) {
        //     $('#scheduleForm').submit();
        //   } 
        // })
      },
       // eventDidMount: function(info) {

      // $('.fc-event-title').each(function(){

      //       if($(this).text() === info.event.title && info.event.extendedProps.type === 'recurring'){
      //        if(info.event.extendedProps.exdate != null){
      //            if(info.event.extendedProps.exdate.split(",").includes($(this).parent().closest('td').attr("data-date"))){
      //                $(this).parent().closest('a').css("display", "none");
      //            }
      //        }
      //       }
      //    });
         

        // console.log(info.event.extendedProps.exclude);
      // },

       eventClick: function(info) {
        console.log(info);
        console.log('Event: ' + info.event.id);
        console.log('View: ' + info.view.type);
        console.log('date: ' + info.event.date_data);
        console.log('date: ' + info.event.extendedProps.type);


        if(info.view.type === 'timeGridWeek'){
          $('#gridView').val('timeGridWeek');
          let sad =info.event.extendedProps.type == 'recurring'  ? 'Every week ' : '';
          var msgse='Schedule date '+moment(info.event.start).format('YYYY-MM-DD');

          if(info.event.extendedProps.type == 'normal'){
            var msgse='Schedule date '+moment(info.event.start).format('YYYY-MM-DD');
          }
          if(info.event.extendedProps.type == 'recurring'){
            var msgse='Every week at ';
          }
          var dayname=moment(moment(info.event.start)).format('dddd');
          Swal.fire({
              title: '予定を変更しますか？',
              showDenyButton: false,
              showCancelButton: false,
              width: '650px',
              // html: "This week every day "+' at <input class="dtp" type="text"  readonly style="width:100px"> TO <input class="dtp2" type="text"  readonly style="width:100px">'
              // html: "<div class='row p-3'>" +dayname+ " day "+' at <input class="dtp ml-2 mr-2" type="text"  readonly style="width:100px"> TO <input class="dtp2 dtp ml-2 mr-2" type="text"  readonly style="width:100px"></div>'
              // +'<div class="row p-3 "><select class="form-control"  id="select_option">'
              //     +'<option value="reschedule"> Reschedule</option>'
              //     +'<option value="cancle_shedule"> Cancel Schedule</option>'
              // +'</select></div>'
              // ,
               html: "<div class='row p-3 justify-content-center'>" + msgse+
               ' at '+moment(info.event.start).format('hh:mm A')+' To '+moment(info.event.start).add(60, 'minutes').format('hh:mm A')
               +' </div>'
               +'<div class="row p-3 " id="res" style="display:none">'
               + 'Reschedule at <input class="dtp ml-2 mr-2" type="text"  disabled="disabled" style="width:100px"> TO <input class="dtp2  ml-2 mr-2" type="text"  disabled="disabled" style="width:100px">'
               +'</div>'
              
              ,


              confirmButtonText: `Delete Schedule`,
              cancelButtonText: `Delete Recurring Schedule`,
              
              didOpen:function(){
                // Swal.disableButtons();
                

                $("#selected_time").val(moment(info.event.start).format('hh:mm A')); // form value
                $("#db_start_time").val(moment(info.event.start).format('hh:mm A')); // form value
                $("#action_type").val(''); // form value
                // console.log(info.event.unique_id);
                $("#db_schedule_id").val(parseInt(info.event.id)); // form value
                $("#db_date").val(moment(info.event.start).format('YYYY-MM-DD')); // form value

                // let title=$(".fc-toolbar-title").text();
                // getAllDate(title,info);  // form value

            
            }

            }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                $("#action_type").val('recurring_delete'); // form value
                $('#scheduleForm').submit();
              } else if (result.isDenied) {
                console.log('details view');
              }else{
                if(result.dismiss === 'cancel'){
                $("#action_type").val('recurring_delete'); // form value
                $('#scheduleForm').submit();
                }
           
                console.log('he he he backdrop');
              }
          })
        }
        // change the border color just for fun
        // info.el.style.background = 'red';
      },
    //   eventRender: function(event, element, view) {
    //     console.log(event.extendedProps.type);
    //   // var theDate = event.start
    //   // var excludedDate = event.excludedDate;
    //   // var excludedTomorrrow = new Date(excludedDate);
    //   //  //if the date is in between August 29th at 00:00 and August 30th at 00:00 DO NOT RENDER
    //   // if( theDate >= excludedDate && theDate < excludedTomorrrow.setDate(excludedTomorrrow.getDate() + 1) ) {
    //   //     return false;
    //   // }
    // },
      events: dateData
      // events: [
      //        {
      //         title: 'my recurring event',
      //         color: 'red'
      //         rrule: {
      //           freq: 'weekly',
      //           interval: 5,
      //           byweekday: [ 'mo', 'fr' ],
      //           dtstart: '2021-02-11T10:30:00', // will also accept '20120201T103000'
      //         }
      //       }
      //     ]
              
      // [
      //     {
      //       "title": "12.06 am - 1.06 am",
      //       "start": "2021-01-25T00:30:00",
      //       "end": "2021-01-25T01:30:00",
      //         'className' : 'tblue',
      //         'textColor' : '#ffffff'


      //     },
      //     {
      //       "title": "12.06 am - 1.06 am",
      //       "start": "2021-01-26T00:30:00",
      //       "end": "2021-01-26T01:30:00",
      //         'className' : 'tblue',
      //         'textColor' : '#ffffff'

      //     }

      //   ]
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



        // console.log(selected);
  }
  function isSelectedEvent(evts, check_date,check_time) {
    var selectedEvent = null;

    for (i in evts) {
      // console.log(moment(evts[i].start).format('YYYY-MM-DD'));
      if((moment(evts[i].start).format('HH:mm:ss') == check_time) && (moment(evts[i].start).format('YYYY-MM-DD') ==check_date)){
        return evts[i].id;
      }
    }
    return "False";
  }

  function onlyUnique(value, index, self) {
    return self.indexOf(value) === index;
  }
  function check_time_already_exist(start_time,dow,event){
    console.log(dow);
    console.log(start_time);
    console.log(event);
    event.filter(function (match) { 
       if( match.startTime == start_time && parseInt(match.daysOfWeek[0]) == dow){
          // return console.log(match.id);
          return match;
       }else{
          // return console.log('not found');
          return 'not_found';
       }
    });

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