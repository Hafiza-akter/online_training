@extends('master_dashboard')
@section('title','trainee trainerlist')
@section('header_css_js')
<style>
  
/* Rating Star Widgets Style */
.rating-stars ul {
  list-style-type:none;
  padding:0;
  
  -moz-user-select:none;
  -webkit-user-select:none;
}
.rating-stars ul > li.star {
  display:inline-block;
  
}

/* Idle State of the stars */
.rating-stars ul > li.star > i.fa {
  font-size:1em; /* Change the size of the stars */
  color:#ccc; /* Color on idle state */
}

/* Hover state of the stars */
.rating-stars ul > li.star.hover > i.fa {
  color:#FFCC36;
}

/* Selected state of the stars */
.rating-stars ul > li.star.selected > i.fa {
  color:#FF912C;
}
</style>
<script src='{{ asset('asset_v2/js/Chart.min.js')}}'></script>
@endsection
@section('content')
    
       {{-- @include('pages.trainee.dashboard') --}}
<section class="review_part gray_bg section_padding">

  <div class="container col-md-12">
    <div class="row mb-5">
        <div class="offset-sm-2 col-sm-8">
     
        </div>   
    </div>
          <div class="row pb-5">
            <div class="col-sm middle">

                    <form action="{{route('traineeCalendar.view')}}" method="get" id="dateform">
                      {{ csrf_field() }}
                      <input type="hidden" name="trainer_id" value="{{ $trainerData->id }}">
                      <button type="submit" class="btn border-round btn-success" >次へ </button> 
                    <a class="btn border-round btn-warning" href="{{ url()->previous()}}">戻る </a>
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
                       <canvas id="line-chart" width="480" ></canvas>
                    </div>
                    <div class="col-sm middle">
                        @if($trainerData->photo_path != NULL)
                            <img class="img-fluid"  src="{{asset('images').'/'.$trainerData->photo_path}}" width="200">
                        @else 
                          <img src="{{asset('images/user-thumb.jpg')}}"  width="200" width="300">

                        @endif       
                        <br>
                        {{-- <h4 class="mx-auto _introduction_">トレーナー紹介</h4>
                        <p >{{ $trainerData->intro}}</p> --}}

                         <div class='rating-stars text-center'>
                            <ul class='stars'>
                              <li class='star'  data-value='1'>
                                <i class='fa fa-star fa-fw'></i>
                              </li>
                              <li class='star'  data-value='2'>
                                <i class='fa fa-star fa-fw'></i>
                              </li>
                              <li class='star' data-value='3'>
                                <i class='fa fa-star fa-fw'></i>
                              </li>
                              <li class='star'  data-value='4'>
                                <i class='fa fa-star fa-fw'></i>
                              </li>
                              <li class='star'  data-value='5'>
                                <i class='fa fa-star fa-fw'></i>
                              </li>
                            </ul>
                          </div>
<input type="hidden" id="total" value="{{ avgStarValue($trainerData->id)}}">
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
</section>
<input type="hidden" id="datasets" value="{{ radarLabel($trainerData->id)}}">
@endsection
@section('footer_css_js')
<script>
/* default ratings value */
   if(parseInt($("#total").val()) > 0){
        var stars = $('li.star');

      for (i = 0; i < parseInt($("#total").val()); i++) {
        $(stars[i]).addClass('selected');
      }
   }
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