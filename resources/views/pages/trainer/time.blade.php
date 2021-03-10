@extends('master_dashboard')
@section('title','trainer schedule')
@section('header_css_js')
<script src="{{ asset('asset_v2/js/sweetalert.min.js')}}"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css"/>
{{-- <link rel="stylesheet" href="{{asset('asset_v2/css/jquery.timepicker.min.css')}}"> --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css" integrity="sha512-/Ae8qSd9X8ajHk6Zty0m8yfnKJPlelk42HTJjOHDWs1Tjr41RfsSkceZ/8yyJGLkxALGMIYd5L2oGemy/x1PLg==" crossorigin="anonymous" /> --}}
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
    {{-- @include('pages.trainer.dashboard') --}}
<section class="review_part gray_bg section_padding">
    
             <div class="row justify-content-center">
                <div class="col-md-8 col-xl-6">
                    <div class="section_tittle">
                        <h3>スケジュール</h3>
                    </div>
                </div>
            </div>
  <div class="offset-md-1 col-md-10">
    <div class="row pb-5  page-content page-container" id="chart">

        @if(Session::has('message'))
        <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismiss">{{ Session::get('message') }}</p>
        @endif

        @if(Session::has('errors_m'))
        <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-danger') }} alert-dismiss">{{ Session::get('errors_m') }}</p>
        @endif

        

        @php 
            // $timePX =Carbon\Carbon::now()->format('i')."px";
            $timePX =Carbon\Carbon::now()->format('i');
            $hour =Carbon\Carbon::now()->format('H') +1;
           // echo $hour; 
        @endphp
      <table id="example" class="table  nowrap" style="width:100%">
        <thead>
            <tr>
                <th style="width: 68px;padding: 2px;border-bottom: 1px dotted rgb(192, 192, 192) !important;color: #bebebe;font-weight: normal;">GMT+06</th>
                <th style="width: 95vw;border-bottom:1px dotted #c0c0c0 !important;border-left:1px dotted #c0c0c0 !important; ">
                    <span style="background: #007bff;color: #fff;border-radius: 50%;width: 95px;padding: .6rem;">{{ Carbon\Carbon::now()->format('d')}}</span>
                </th>
            </tr>
        </thead>
        <tbody>
        
           
                @php 
                $reducer = 0;
                for($i=1;$i<=24;$i++){ 
                     // check available time background
                    $colorFormat = '';
                    $colorFormatLast = '';
                
                    @endphp
                     <tr  data-time="{{ Carbon\Carbon::parse($i.':00:00')->format('H') }}" data-date="{{$selected_date}}" id="{{ $i < 12 ? $i.'-AM' : (($i-12) ===0 ? '12-PM': ($i-12).'-PM' )}}"  >
                        {{-- hour marker like am / pm --}}
                        <td style="color: #bebebe;width: 5%;padding:0px;position:relative;border:none !important;">
                          @if($i != 24)
                                <span style="position:absolute;bottom:-8px;right:8px;">
                                 {{ $i < 12 ? $i.' AM' : (($i-12) ===0 ? '12 PM': ($i-12).' PM' )}}
                                 </span>
                             @endif
                        </td>
                        {{-- ============= --}}
                        {{-- minute marker hidden --}}
                        <td style="border-bottom:1px dotted #c0c0c0 !important;border-left:1px dotted #c0c0c0 !important;height: 60px;padding: 0px;background:{{ $colorFormat}}" class="">
                            
                            @for($t=0;$t<59;$t++)
                            
                            {{-- time right now --}}
                            @if($hour == $i && $timePX == $t)
                                <div style="height:1px;background:1px red;width:100%;" data-timemn="{{$t}}">&nbsp;</div>  
                            @else 


                             <div style="height:1px;background: {{ backgroundColor($i,$t,$time) }};width:100%;height:1px" data-timemn="{{$t}}">&nbsp;</div>    
                            

                            @endif
                            @endfor
                        
                        </td>
                        {{-- ============= --}}
                    </tr>
                @php 
                    $reducer++;
                }
                @endphp
                
           
        </tbody>
    </table>
        <form action="{{route('scheduleSubmit.submit')}}" method="post" id="dateform">
            {{ csrf_field() }}
            <input type="hidden" name="trainer_id" value="{{ Session::get('user')->id}}">
            <input type="hidden" name="date" id="selected_date" value="{{$selected_date}}">
            <input type="hidden" name="start_time"  id="selected_time" value="">
        </form>
    </div>
</div>
</section>
  @endsection
  @section('footer_css_js')

<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
{{-- <script src="{{ asset('asset_v2/js/jquery.timepicker.min.js')}}"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js" integrity="sha512-2xXe2z/uA+2SyT/sTSt9Uq4jDKsT0lV4evd3eoE/oxKih8DSAsOF6LUb+ncafMJPAimWAXdu9W+yMXGrCVOzQA==" crossorigin="anonymous"></script> --}}
<script src="{{asset('asset_v2/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>   

 <style>
        .swal2-styled.swal2-confirm{
            background-color: #a509a4

        }
        .swal2-styled.swal2-deny{
            background-color: #09951a;

        }
        .swal2-styled.swal2-cancel{
            background-color: #e93232;
        }
    </style>
    <script>


$(document).ready(function() {
    var table = $('#example').DataTable( {
        responsive: true,
        "bSort" : false ,
        searching: false, 
        paging: false,
    } );

    $('#example tbody').on('click', 'div', function () {

        // get div background color
        let rgbcolor = $(this).css('backgroundColor');
        let hex2rgb= c=> `rgb(${c.substr(1).match(/../g).map(x=>+`0x${x}`)})`;
        let rgb2hex= c=> '#'+c.match(/\d+/g).map(x=>(+x).toString(16).padStart(2,0)).join``;
        var hexaColor = rgb2hex(rgbcolor);
        console.log('backgroundcolor', rgb2hex(rgbcolor));

        // -----------------------

        console.log('minute: ' +$(this).data('timemn'));
        console.log('id: '+$(this).closest('tr').attr("id"));

            let timme = $(this).data('timemn');
            let hour = parseInt($(this).closest('tr').attr("data-time")) -1;
            if(hour == -1){
                hour = 23;
            }

            console.log('hour: '+hour);
            // prepare to set in hidden input
            var timES = (hour)+":"+timme; 

            // set in 1st date picker
            console.log('Datepicker1: '+moment(timES, 'HH:mm:ss').format('HH:mm A'));
            // let oktime=moment(timES, 'HH:mm:ss').format('HH:mm');
            // console.log('ok time: '+oktime);
            console.log();
            var id = $(this).closest('tr').attr("id") ;
            var result = id.split('-');
            var time="";
            // time to show in modal 
            if(result[1] == 'AM'){
                if(parseInt(result[0]) == 1){
                     time = '12:'+timme+ 'AM-1:'+timme+'AM';
                }else if(parseInt(result[0]) == 12){
                     time = '11:'+timme+ 'AM-12:'+timme+'PM';
                }else{
                    time=(parseInt(result[0]) -1 ) +':'+ timme +'AM -' + parseInt(result[0]) +':'+ timme +'AM'
                }
            }
            if(result[1] == 'PM'){

                if(parseInt(result[0]) == 12 ){
                     time = '11:'+timme+ 'PM-12:'+timme+'AM';

                }else if(parseInt(result[0]) == 1){
                     time = '12:'+timme+ 'PM-1:'+timme+'PM';
                }else{
                    time=(parseInt(result[0]) -1 ) +':'+ timme +'PM -' + parseInt(result[0]) +':'+ timme +'PM'
                }
            }
            // ------------------

            $(this).toggleClass('selected');

            // time to set for db insert 
            $("#selected_time").val('');
            $("#selected_time").val(timES);
            // ------------------

            console.log(this.dataset.timemn);
            var htmltime ="<b><span class='fas fa-clock'></span>"+time+"</b>";


            // red and green background color, will show the user info and history
            // blue background color will show the selected date

            if(hexaColor === '#1b97ef'){ // blue
                Swal.fire({
                  title: '予定を変更しますか？',
                  showDenyButton: true,
                  showCancelButton: true,
                    width: '650px',
                  confirmButtonText: `Reschedule`,
                  denyButtonText: `Delete`,
                }).then((result) => {
                  /* Read more about isConfirmed, isDenied below */
                  if (result.isConfirmed) {
                    Swal.fire('reschedule!', '', 'success')
                  } else if (result.isDenied) {
                    Swal.fire('Delete', '', 'info')
                  }else{
                    console.log('Delete');
                  }
                })
            }
            else if(hexaColor === '##a2ffb7'){ // green

            }
            else if(hexaColor === '#f4928e'){ // red

               Swal.fire({
                  title: '予定を変更しますか？',
                  showDenyButton: true,
                  showCancelButton: true,
                    width: '650px',
                  confirmButtonText: `Reschedule`,
                  denyButtonText: `View Details`,
                }).then((result) => {
                  /* Read more about isConfirmed, isDenied below */
                  if (result.isConfirmed) {
                    Swal.fire('Saved!', '', 'success')
                  } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                  }else{
                    console.log('Delete');
                  }
                })

            }
            else{
                // swal({
                // title: "本気ですか ？", //"Are you sure ?",
                // text: "Your available date is  "+$(this).closest('tr').attr("data-date")+" at "+time+ ".",
                // icon: "success",
                // buttons: [
                //         'No, cancel it!',
                //         'Yes, I AM sure!'
                //     ]
                // }).then(function(isConfirm) {
                //     if (isConfirm) {
                //         $('#dateform').submit();
                //     }else{
                //         console.log('no');
                //     }
                // })

                Swal.fire({
                  title: '予約を確定します。よろしいでしょうか？',
                // text: "Your available date is  "+$(this).closest('tr').attr("data-date")+" at "+time+ ".",
                  showDenyButton: false,
                // html: '<input class="" type="text" id="datetimepicker" readonly style="width:100px"> TO <input class="" type="text" id="datetimepicker2" readonly style="width:100px">'+"Your available date is "+$(this).closest('tr').attr("data-date")+" at <span id='timepicker1'>"+time+ " </span> ",
                html: "Your available date is "+$(this).closest('tr').attr("data-date")+' at <input class="" type="text" id="datetimepicker" readonly style="width:100px"> TO <input class="" type="text" id="datetimepicker2" readonly style="width:100px">',
                  showCancelButton: true,
                  confirmButtonText: `Save`,
                    width: '650px',
                  denyButtonText: `Don't save`,
                  didOpen:function(){
                    // $('#onselectExample').timepicker();
                    // $('#onselectExample').on('changeTime', function() {
                    //     // $('#onselectTarget').text($(this).val());
                    // });

                                // $('#timepicker1').timepicker();

                    $("#datetimepicker").datetimepicker({
                        formatViewType: 'time',
                        fontAwesome: true,
                        autoclose: true,
                        startView: 1,
                        maxView: 1,
                        minView: 0,
                        minuteStep: 5,
                        format: 'HH:ii P',
                        showMeridian: true,

                    });
                     $("#datetimepicker").val(moment(timES, 'HH:mm').format('HH:mm A'));
                     $("#datetimepicker2").val(moment(timES, 'HH:mm').add(60, 'minutes').format('HH:mm A'));

                      $("#datetimepicker").on("change.dp",function (e) {
                            let newtime = moment(this.value, 'HH:mm').add(60, 'minutes').format('HH:mm A');
                            $("#datetimepicker2").val(newtime);
                            $("#selected_time").val(this.value);

                    });



                  }
                }).then((result) => {
                  /* Read more about isConfirmed, isDenied below */
                  if (result.isConfirmed) {
                    $('#dateform').submit();
                  } 
                })
            }
            


        } );
 
} );
</script> 
{{-- Swal.fire({
  position: 'top-end',
  icon: 'success',
  title: 'Your work has been saved',
  showConfirmButton: false,
  timer: 1500
}) --}}

@endsection 