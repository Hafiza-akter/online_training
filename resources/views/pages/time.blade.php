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
    </style>
    <div class="row pb-5">
      <h2 class="mx-auto">オンラー</h2>
    </div>
    <div class="row pb-3">
      <div class="col-sm border-round">
        <a class="btn">ログイン </a>       
      </div>
      <div class="col-sm border-round">
        <a class="btn">ログイン </a>       
      </div>
      <div class="col-sm border-round">
        <a class="btn">ログイン </a>       
      </div>
      <div class="col-sm border-round">
        <a class="btn">ログイン </a>       
      </div>
    </div>
    <div class="row mb-5">
      <div class="offset-sm-4 col-sm-4 border-round">
        <a class="btn">ログイン </a> 
     </div>
    </div>
    <div class="row pb-5  page-content page-container" id="chart">
 		@php 
 			$timePX =Carbon\Carbon::now()->format('i')."px";
 			$hour =Carbon\Carbon::now()->format('H');
 			
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
        		for($i=1;$i<=24;$i++){ @endphp
        			 <tr data-date="{{$selected_date}}" id="{{ $i < 12 ? $i.'-AM' : (($i-12) ===0 ? '12-PM': ($i-12).'-PM' )}}">
        		         <td style="color: #bebebe;width: 5%;padding:0px;position:relative;border:none !important;">
{{-- 						    <span style="position:absolute">{{ $left}}</span>
 --}}						@if($i != 24)
	 							<span style="position:absolute;bottom:-8px;right:8px;">

	 							 {{ $i < 12 ? $i.' AM' : (($i-12) ===0 ? '12 PM': ($i-12).' PM' )}}
	 							 </span>
 							 @endif
						</td>
						<td style="border-bottom:1px dotted #c0c0c0 !important;border-left:1px dotted #c0c0c0 !important;height: 60px;padding: 0px;">
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
<script>
$(document).ready(function() {
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
			
            $(this).toggleClass('selected');
            $("#selected_time").val('');
            $("#selected_time").val(time);

            console.log(result);
            // var date ="<b><span class='fas fa-clock'></span>"+date+"</b>";
            var htmltime ="<b><span class='fas fa-clock'></span>"+time+"</b>";
            swal({
                title: "予約を確定します。よろしいでしょうか？", //"Are you sure ?",
                text: "予約時間は  "+this.dataset.date+" 日の "+time+ "時です。",
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


        } );
 
} );
</script>  
@endsection 