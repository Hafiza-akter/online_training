@extends('master_dashboard')
@section('title','trainee schedule')
@section('header_css_js')
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css"/>
@endsection
@section('content')


    <style>
        .table td, .table th{
            border:none !important;
        }
        .dataTables_info{
            display: none !important;
        }
    </style>
    <section class="review_part gray_bg section_padding">
    
             <div class="row justify-content-center">
                <div class="col-md-8 col-xl-6">
                    <div class="section_tittle">
                        <h3>スケジュール 時間</h3>
                    </div>
                </div>
            </div>
    <div class="offset-md-1 col-md-10">

{{--     @include('pages.trainee.dashboard')
 --}}
    <div class="row pb-5  page-content page-container" id="chart">

        @if(Session::has('message'))
        <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismiss">{{ Session::get('message') }}</p>
        @endif

        @php 
            $timePX =Carbon\Carbon::now()->format('i')."px";
            $hour =Carbon\Carbon::now()->format('H');
            
        @endphp
      {{--   <a class="btn btn-warning " href="{{ url()->previous()}}"> <i class="fas fa-backward"></i> back  </a> --}}
      <table id="example" class="table  nowrap" style="width:100%">
        <thead>
            <tr>
                <th style="width: 68px;padding: 2px;border-bottom: 1px dotted rgb(192, 192, 192) !important;color: #bebebe;font-weight: normal;">GMT+06</th>
                <th style="width: 95vw;border-bottom:1px dotted #c0c0c0 !important;border-left:1px dotted #c0c0c0 !important; ">
                    <span style="background: #007bff;color: #fff;border-radius: 50%;width: 95px;padding: .6rem;">{{ Carbon\Carbon::parse($selected_date)->format('d')}}</span>
                </th>
            </tr>
        </thead>
        <tbody>
        
           
                @php 
                $reducer = 0;
                for($i=1;$i<=24;$i++){ 
                    @endphp

                    @php 
                            // check available time background
                            $colorFormat = '';
                            $colorFormatLast = '';
                            $scheduleId = '';
                            $userId = 0;

                            if(!empty($time)){
                                    foreach($time as $val){

                                        if( Carbon\Carbon::parse($val->time)->format('H') == $i){
                                            $colorFormat = '#007bff91';
                                            $scheduleId = $val->id;
                                            if($val->is_occupied == 1 && ($val->user_id == Session::get('user')->id )){
                                                $colorFormat = '#ff121275';
                                                $userId = $val->user_id;
                                            }
                                            
                                        }

                                        if( Carbon\Carbon::parse($val->time)->format('H') == 0 && $i==24){
                                             
                                            $colorFormat = '#007bff91';
                                            $scheduleId = $val->id;

                                            if($val->is_occupied == 1 && ($val->user_id == Session::get('user')->id )){
                                                $colorFormat = '#ff121275';
                                                
                                            }
                                        }

                                    }
                            } 

                        @endphp

                     <tr data-time="{{ Carbon\Carbon::parse($i.':00:00')->format('H') }}" data-date="{{$selected_date}}" id="{{ $i < 12 ? $i.'-AM' : (($i-12) ===0 ? '12-PM': ($i-12).'-PM' )}}"  data-scheduleid={{ $scheduleId}} data-user_id={{ $userId}}>
                         <td style="color: #bebebe;width: 5%;padding:0px;position:relative;border:none !important;">
{{--                            <span style="position:absolute">{{ $left}}</span>
 --}}                       @if($i != 24)
                                <span style="position:absolute;bottom:-8px;right:8px;">

                                 {{ $i < 12 ? $i.' AM' : (($i-12) ===0 ? '12 PM': ($i-12).' PM' )}}
                                 </span>
                             @endif
                        </td>

                        <td style="border-bottom:1px dotted #c0c0c0 !important;border-left:1px dotted #c0c0c0 !important;height: 60px;padding: 0px;background:{{ $colorFormat}}" @if($colorFormat == '') class="unselectable"  @endif>
                            
                            @if($hour == $i)
                            <div style="height:1px;border:1px solid red;width:100%;margin-top:{{ $timePX}}">&nbsp;</div>    
                            @endif
                        </td>
                    </tr>
                @php 
                    $reducer++;
                }
                @endphp
                
           
        </tbody>
    </table>
        <form action="{{route('tscheduleSubmit.submit')}}" method="post" id="dateform">
            {{ csrf_field() }}
            <input type="hidden" name="user_id" value="{{ Session::get('user')->id}}">
            <input type="hidden" name="schedule_id"  id="schedule_id" value="">
            <input type="hidden" name="is_allowed"  id="is_allowed" value="">
            <input type="hidden" name="selected_time"  id="selected_time" value="">
            <input type="hidden" name="date" id="selected_date" value="{{$selected_date}}">

        </form>
    </div>
    </div>
</section>
  @endsection
  @section('footer_css_js')

<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$(document).ready(function() {
    $('.unselectable').prop("disabled",true);

    var table = $('#example').DataTable( {
        responsive: true,
        "bSort" : false ,
        searching: false, 
        paging: false,
    } );

    $('#example tbody').on('click', 'tr', function () {

        
            var id = this.id;
            var result = id.split('-');
            var time="";
            if(result[1] == 'AM'){
                if(parseInt(result[0]) == 1){
                     time = '12am-1am';
                }else if(parseInt(result[0]) == 11){
                    time = '11am-12pm';
                }else{
                    time=(parseInt(result[0]) -1 ) + 'am -' + parseInt(result[0])+'am'
                }
            }
            if(result[1] == 'PM'){

                if(parseInt(result[0]) == 12){
                     time = '11pm-12am';
                }else if(parseInt(result[0]) == 11){
                    time = '11pm-12am';
                }else{
                    time=(parseInt(result[0]) -1 ) + 'pm -' + parseInt(result[0])+'pm'
                }
            }
            
            // $(this).toggleClass('selected');
            if(this.dataset.scheduleid){

                $("#selected_time").val('');
                $("#selected_time").val(this.dataset.time);

                $("#schedule_id").val('');
                $("#is_allowed").val('');

                // $("#selected_time").val(this.dataset.time);
                $("#schedule_id").val(this.dataset.scheduleid);
                $("#is_allowed").val(1);



                // console.log(result);
                // var date ="<b><span class='fas fa-clock'></span>"+date+"</b>";
                // var htmltime ="<b><span class='fas fa-clock'></span>"+time+"</b>";
                if(this.dataset.user_id > 0){

                }else {
                      swal({
                    title: "本気ですか ？", //"Are you sure ?",
                    text: "You want to reserve  "+this.dataset.date+" at "+time+ ".",
                    icon: "success",
                    buttons: [
                        'No, cancel it!',
                        'Yes, I am sure!'
                    ]
                    }).then(function(isConfirm) {
                        if (isConfirm) {
                            $('#dateform').submit();
                        }else{
                            console.log('no');
                        }
                    })
                }
            }
            


        } );
 
} );
</script>  
@endsection 