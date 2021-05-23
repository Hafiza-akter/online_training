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
  
</style>
{{-- @include('pages.trainee.dashboard') --}}
<section class="review_part gray_bg section_padding">
  <div class="container my-4">
   
        <div class="row justify-content-center">
          <div class="container">

          <div class="card">
                <div class="card-header" style="background: #c30f23">
                    <h1 style="text-align: left;color:white">

                     {{ \Carbon\Carbon::parse($date)->format('Y/m/d')}}
                  </h1>

                </div>
            <!-- Card body -->
              <div class="card-body">
              
                 <div class="row justify-content-center" id="timeline">
                          @if(isset($data))
                          @php 
                              $i=0;
                          @endphp
                            @foreach($data as $val)
                              <div class="offset-sm-1 col-md-10 col-xl-10" style="display: inline-flex;">

                                  <div class="col-md-5 col-xl-5">
                                    
                                      @if($val['imageurl'] != NULL)

                                        <img  style="width:200px" src="{{asset('images').'/'.$val['imageurl']}}" style="height: 200;width: 200" />
                                      @else 

                                        <img src="{{asset('images/user-thumb.jpg')}}"  width="200" width="200">
                                      @endif

                                        <h3 style="color:black;font-weight: bold; padding: 10px;">{{ $val['name']}}</h3>
                                        <h3 style="color:black;font-weight: bold; padding: 2px;">【 指導分野 】</h3>

                                       @php 
                                          $arr=unserialize($val['instructions']);
                                          $string="";
                                          if(!empty($arr)){
                                            $string = implode('<span class="p-2"> / </span>',$arr);
                                          }
                                        @endphp
                                        <h3 style="color:#c30f23" class="p-2">{!! $string !!}</h4>

                                  </div>
                                  <div class="col-md-5 col-xl-5">

                                    @php 
                                     $time =  getTime($val['trainer_id'],$date);
                                    @endphp 

                                    @if(isset($time))

                                      @foreach($time as $value)
                                          <h3  id="{{ $i."_".$value['type']."_".$value['id'] }}" class="hour-list {{ isset($value['is_occupied']) && $value['is_occupied'] == 1 ? 'red-background' : '' }}" >
                                            {{ \Carbon\Carbon::parse( $value['time'])->format('H:i')}}

                                            ~
                                         
                                            {{ \Carbon\Carbon::parse( $value['time'])->addHour()->format('H:i')}} 

                                          </h3>

                                          @php 
                                            $i++;
                                          @endphp
                                      @endforeach

                                    @endif
                            

                                  <button class="btn bt-block float-right btn-primary" disabled="disabled">トレーニングを予約する</button>
                                  </div> 
                                
                              </div>

                            @endforeach
                          @endif
                      
                  </div>

              </div>

          </div>
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