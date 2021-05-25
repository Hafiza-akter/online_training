@extends('master_dashboard')
@section('title','trainee schedule')
@section('header_css_js')
<script src="{{ asset('asset_v2/js/sweetalert.min.js')}}"></script>
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css"/>

@endsection
@section('content')

<style>
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
    <form action="{{route('trainerSubmitBytime')}}" method="post" id="dateform" style="display: inline-block;">
        {{ csrf_field() }}
        <input type="hidden" name="trainer_id" id="trainer_id">
        <input type="hidden" name="date" value="{{ $date}}">
        <input type="hidden" name="time" id="time">
    </form>
  <div class="container my-4">
   
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
                    
                   @if($val['imageurl'] != NULL)

                      <img  style="width:200px" src="{{asset('images').'/'.$val['imageurl']}}" style="height: 200;width: 200" />
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

                <div data-trainer="{{$value['trainer_id']}}" data-time="{{$time}}" class="div{{ $k}} boxd {{ $time_array == 'not_found' ?  '' : (isset($time_array->is_occupied) && $time_array->is_occupied == 1 ? 'red' : 'blue') }} "> 
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
<script>
//   function assignValue(d){

// $('h3').attr(
//   'class',
//   $('element').attr('class').replace(/\bclass-\d+\b/g, '')
// );
//     $('#'+d).addClass('red-background');
//     console.log(d);
//     $("#schedule_info").val('');
//     $("#schedule_info").val(d);
//   }
$(".blue").click(function(){
  let trainer_id = $(this).attr("data-trainer"); 
  let time = $(this).attr("data-time");
  $("#trainer_id").val(trainer_id);
  $("#time").val(time);
  $("#dateform").submit();

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