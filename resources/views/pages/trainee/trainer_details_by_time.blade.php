@extends('master_dashboard')
@section('title','trainee trainerlist')
@section('header_css_js')
<script src='{{ asset('asset_v2/js/Chart.min.js')}}'></script>
@endsection
@section('content')
       {{-- @include('pages.trainee.dashboard') --}}
<section class="review_part gray_bg section_padding">

  <div class="container col-md-12">
  
        <div class="row pb-5">
          <div class="col-sm middle">

                  <form action="{{route('trainerSubmitBytime')}}" method="post" id="dateform" style="display: inline-block;">
                    {{ csrf_field() }}

                    <input type="hidden" name="trainer_id" value="{{ $trainerData->id }}">
                    <input type="hidden" name="date" value="{{ $date }}">
                    <input type="hidden" name="time" value="{{ $time }}">

                    <button type="submit" class="btn border-round btn-success" >トレーナーを選択 </button> 
              
                </form>
                 <form action="{{route('trainerlistviatime')}}" method="post" id="dateform" style="display: inline-block;">
                    {{ csrf_field() }}

                    <input type="hidden" name="trainer_id" value="{{ $trainerData->id }}">
                    <input type="hidden" name="selected_date" value="{{ $date }}">
                    <input type="hidden" name="start_time" value="{{ $time }}">

                    <button type="submit" class="btn border-round btn-warning" >戻る</button> 
                  
                </form>


          </div>
        </div>


         <div class="card">
            <div class="card-header">
              <h2 style="text-align: center;color:#c30f23">{{ $trainerData->first_name }}</h2>
            </div>
          <div class="card-body">
             <div class="row justify-content-center">
                <div class="row pb-5">
                   <div class="col-lg middle">
                       <canvas id="line-chart" width="500" ></canvas>
                    </div>
                    <div class="col-sm middle">
                        @if($trainerData->photo_path != NULL)
                            <img class="img-fluid"  src="{{asset('images').'/'.$trainerData->photo_path}}" width="300">
                        @else 
                          <img src="{{asset('images/user-thumb.jpg')}}"  width="200" width="300">

                        @endif       
                        {{-- <h4 class="mx-auto _introduction_">トレーナー紹介</h4>
                        <p >{{ $trainerData->intro}}</p> --}}

                    </div>
                    <div class="col-sm middle">
                      【 指導分野 】<br>
                      @php 
                        $arr=unserialize($trainerData->instructions);
                        $string="";
                        if(!empty($arr)){
                          $string = implode('<span class="p-2"> / </span>',$arr);
                        }
                      @endphp
                        <br>
                      <h4 style="color:#c30f23">{!! $string !!}</h4>

                      <br>

                      【 経歴 】<br><br>
                     
                      <p style="color:#c30f23">{{ $trainerData->intro}}</p>
                   </div>
                </div>
                </div>
            </div>
          </div>

        </div>


</div>
</section>
<input type="hidden" id="datasets" value="{{ radarLabel($trainerData->id)}}">
@endsection
@section('footer_css_js')
<script>

var Dataset = JSON.parse($('#datasets').val());
console.log(Dataset);


const dataset = Dataset;
console.log(dataset);
const config = {
  type: 'radar',
  data: dataset,
  options: {
    legend: {
            display: false
         },
    elements: {
      line: {
        borderWidth: 3
      }
    },
    scale: {
        ticks: {
            callback: function() {return ""}
        },
      gridLines: {
        color: 'black'
      },
      angleLines: {
        color: 'black'
      }
    },
    tooltips: {
            callbacks: {
                title: (tooltipItem, data) => data.labels[tooltipItem[0].index]
            }
        }
  },
};


  window.onload = function() {
      var ctx = document.getElementById('line-chart');
      window.myLine = new Chart(ctx, config);

    //   var myRadarChart = new Chart(ctx, {
    //     type: 'radar',
    //     data: data,
    //     options: options
    // });
  };
  </script>
@endsection