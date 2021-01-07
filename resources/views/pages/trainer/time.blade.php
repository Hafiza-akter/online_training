@extends('auth/master')
@section('title','trainer schedule')
@section('content')
{{-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap.min.css">
 --}}


   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css"/>
    <style>
        .table td, .table th{
            border:none !important;
        }
        .dataTables_info{
            display: none !important;
        }
    </style>
    @include('pages.trainer.dashboard')

    <div class="row pb-5  page-content page-container" id="chart">

        @if(Session::has('message'))
        <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-info') }} alert-dismiss">{{ Session::get('message') }}</p>
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
  @endsection
  @section('footer_css_js')

<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
  {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<style>
    .swal2-styled.swal2-confirm{
        background-color: #ffc107

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

            var timES = (hour)+":"+timme; // prepare to set in hidden input
            var id = $(this).closest('tr').attr("id") ;
            var result = id.split('-');
            var time="";
            // time to show in modal 
            if(result[1] == 'AM'){
                if(parseInt(result[0]) == 1){
                     time = '12:'+timme+ 'am-1:'+timme+'am';
                }else if(parseInt(result[0]) == 12){
                     time = '11:'+timme+ 'am-12:'+timme+'pm';
                }else{
                    time=(parseInt(result[0]) -1 ) +':'+ timme +'am -' + parseInt(result[0]) +':'+ timme +'am'
                }
            }
            if(result[1] == 'PM'){

                if(parseInt(result[0]) == 12 ){
                     time = '11:'+timme+ 'pm-12:'+timme+'am';

                }else if(parseInt(result[0]) == 1){
                     time = '12:'+timme+ 'pm-1:'+timme+'pm';
                }else{
                    time=(parseInt(result[0]) -1 ) +':'+ timme +'pm -' + parseInt(result[0]) +':'+ timme +'pm'
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

            }
            else if(hexaColor === '##a2ffb7'){ // green

            }
            else if(hexaColor === '#f4928e'){ // red

               Swal.fire({
                  title: 'Do you want to save the changes?',
                  showDenyButton: true,
                  showCancelButton: true,
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
                //         'Yes, I am sure!'
                //     ]
                // }).then(function(isConfirm) {
                //     if (isConfirm) {
                //         $('#dateform').submit();
                //     }else{
                //         console.log('no');
                //     }
                // })

                Swal.fire({
                  title: '本気ですか ？',
                text: "Your available date is  "+$(this).closest('tr').attr("data-date")+" at "+time+ ".",
                  showDenyButton: false,
                  showCancelButton: true,
                  confirmButtonText: `Save`,
                  denyButtonText: `Don't save`,
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
@endsection 