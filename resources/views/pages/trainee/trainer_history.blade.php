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
  font-size:1.4em; /* Change the size of the stars */
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

  <div class="container col-md-12  my-4">
     <h2 style="text-align: center;color:#c30f23">{{ $trainerData->first_name }}</h2>

        <div class="card-group">
          <div class="card ">
            <div class="card-body text-left">

               <div class="row pb-5">
            <div class="col-sm middle">

                    <form action="{{route('traineeCalendar.view')}}" method="get" id="dateform">
                      {{ csrf_field() }}
                      <input type="hidden" name="trainer_id" value="{{ $trainerData->id }}">
                     
                    <a class="btn border-round btn-warning" href="{{ url()->previous()}}">戻る </a>
                  </form>


            </div>
          </div>
               <canvas id="line-chart"  ></canvas>

             
            </div>
          </div>
          <div class="card ">

            <div class="card-body text-left">
                  @if($trainerData->photo_path != NULL)
                      <img class="card-img-top"  src="{{asset('images').'/'.$trainerData->photo_path}}" style="width:400px">
                    @else 
                      <img class="card-img-top" src="{{asset('images/user-thumb.jpg')}}"   alt="Card image" style="width:400px" >
                    @endif


                    <div class='rating-stars text-left mt-3 mb-2' >
                      <ul class='stars'>
                        <li class='star selected'  data-value='1'>
                          <i class='fa fa-star fa-fw'></i> ( {{ totalStar($trainerData->id) }} )
                        </li>
                        
                        
                       
                      </ul>
                    </div>
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
</section>
<input type="hidden" id="datasets" value="{{ radarLabel($trainerData->id)}}">
@endsection
@section('footer_css_js')
<script>
/* default ratings value */
        var stars = $('li.star');

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
            callback: function() {return ""},
            beginAtZero: true,
            max: 5,
            min: 0
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