@extends('master_dashboard')
@section('title','purchase plan')
@section('header_css_js')
<script src='{{ asset('asset_v2/js/Chart.min.js')}}'></script>
<script src='{{ asset('asset_v2/js/utils.js')}}'></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<style>
.table td, .table th{
    border:none !important;
}
</style>
@endsection
@section('content')
<section class="review_part gray_bg section_padding">
  <div class="container my-4">

       <div class="row justify-content-center">
            <div class="col-md-8 col-xl-6">
                <div class="section_tittle">
                    <h3>達成状況</h3>
                </div>
            </div>
        </div>

   
        <div class="row justify-content-center">
            <div class="col-md-12 col-xl-12">
              <div class="card">
                    <div class="card-header">
                       <ul class="list-inline">
                          <li class="list-inline-item {{ $isActive == 'progress' ? 'btn_active_' : 'btn-secondary'}}" style="padding: 10px;color: white;">
                            <a href="{{ route('progress')}}" style="color: #fff">
                              <i class="fas fa-trophy"></i> 達成状況
                            </a>
                          </li>

                          <li class="list-inline-item {{ $isActive == 'dailydata' ? 'btn_active_' : 'btn-secondary'}}" style="padding:10px;color: white;">
                            <a href="{{ route('dailydata',date('Y-m-d'))}}" style="color: #fff">
                            <i class="fas fa-plus"></i>  日別データ入力
                            </a>
                           </li>

                        </ul>

                    </div>
                <!-- Card body -->
                  <div class="card-body">

                     <div class="row justify-content-center">

                       <div class="col-md-12 col-xl-12">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if(Session::has('success'))
                            <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}</p>
                            @endif
                        </div>

                        <div class="col-md-12 col-xl-12">

                            <table class="table">
                     
                              <tbody>
                       
                                    <input type="hidden" name="email" class="form-control" value="{{ $user->email}}">
                                    <input type="hidden" name="user_id" class="form-control" value="{{ $user->id}}">   
                                <tr>
                               
                                  <td></td>                          
                                </tr>
                                
                               
                              </tbody>
                          </table>
                          </div>


                        <div class="col-md-12 col-xl-12">
                            <canvas id="line-chart" width="800" height="450"></canvas>
                        </div>
                      </div>

                  </div>

              </div>
            </div>
          </div>
    
  </div>
  <input type="hidden" id="dataset" value="{{ $dataset}}">
{{--   <input type="hidden" id="datasetlebel" value="{{ $datasetlebel['1/02','2/02','3/02','4/02','5/02','6/02','7/02']}}">
 --}}
 <div class="offset-md-1 col-md-10 mt-30" id="scheduleList">

           <h4 class="" style="text-align: center;">詳細</h4>

    <table class="table table-striped" style="background: #f9f9ff;">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">日時</th>
        <th scope="col">体重(午前)</th>
        <th scope="col">体重(午後)</th>
        <th scope="col">摂取カロリー</th>
        <th scope="col">PAL</th>
        <th scope="col">アクション</th>
      </tr>
    </thead>
    <tbody>
      @if($list)
        @foreach($list as $key=>$val)
          <tr>
            <td scope="row">{{ ++$key}}</td>
            <td >
            {{ \Carbon\Carbon::parse($val->recorded_at)->format('Y-m-d')}}
            </th>
            <td>{{ $val->weight_evening}}</td>
            <td>{{ $val->weight_morning}}</td>
            <td>{{ $val->calory_gained}}</td>
            <td>{{ $val->pal}}</td>

            <td>
              <a class="btn btn-danger" href="{{ route('dailydata',\Carbon\Carbon::parse($val->recorded_at)->format('Y-m-d')) }}">編集</a>
            </td>
          </tr>
        @endforeach
      @endif
      
    </tbody>
  </table>
     
</div>s
</section>



@endsection
@section('footer_css_js')

<script>

var dataset = JSON.parse($('#dataset').val());
console.log(dataset);
var config = {
    type: 'line',

    data: {
      labels: [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90],
      
      datasets: dataset 
      // [
      // { 
      //     data: [70,67,64,60],
      //     label: "",
      //     borderColor: "#6d93ff",
      //     fill: false
      //   }, 
      //   { 
      //     data: [70,64,60,55],
      //     label: "",
      //     borderColor: "green",
      //     fill: false
      //   },
      //    { 
      //     data: [70,62,55,50],
      //     label: "",
      //     borderColor: "yellow",
      //     fill: false
      //   }, 
      
      // ]
    },
    options: {
      title: {
        display: true,
        text: '達成状況確認グラフ'
      },
      tooltips: {
                  enabled: true,
                  mode: 'single',
                  callbacks: {
                      label: function(tooltipItems, data) { 
                          return tooltipItems.yLabel + ' KG';
                      }
                  }
              },
              scales: {
              yAxes: [{
                  ticks: {
                      // Include a dollar sign in the ticks
                      callback: function(value, index, values) {
                          return  value +' KG';
                      }
                  }
              }]
          }
    }
  };

  window.onload = function() {
      var ctx = document.getElementById('line-chart').getContext('2d');
      window.myLine = new Chart(ctx, config);
  };


function checkInput(){
  let AcinputDigit  = $("#target_calory_gained").val();
  let inputDigit = Math.floor($("#target_calory_gained").val());
      console.log(inputDigit);

  if(inputDigit.toString().length >= 3){
    console.log('heelo');
    let bmrData = $("#bmrData").val();

    if(bmrData != AcinputDigit){
          updateConfigAsNewObject();
    }
  }
}
function updateConfigAsNewObject() {
console.log($('#weight_loss_gain option:selected').attr('value'));
  
const params = {
  type: $('#weight_loss_gain option:selected').attr('value'),
  weight:$('#weight').val(),
  pal:$('#pal').val(),
  totalday:$('#totalday').val(),
  startdat:$('#startdat').val(),
  bmrData:$('#target_calory_gained').val()
}



fetch('{{ route('purchaseajaxcall')}}', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      body: JSON.stringify(params)
    }).then(response => response.json())
      .then(repos => {
        // console.log(repos);
            config.data= {
              labels: [0,1,2,3],
              
              datasets: repos
            };
            config.options.title.text= ( params.type == '-1' ? "Weight Gain Graph" : "Weight Loss Graph");
                window.myLine.update();
      })
    .catch(err => console.log(err))



}

// function setInputFilter(textbox, inputFilter) {
//   ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
//     textbox.addEventListener(event, function() {
//       if (inputFilter(this.value)) {
//         this.oldValue = this.value;
//         this.oldSelectionStart = this.selectionStart;
//         this.oldSelectionEnd = this.selectionEnd;
//       } else if (this.hasOwnProperty("oldValue")) {
//         this.value = this.oldValue;
//         this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
//       } else {
//         this.value = "";
//       }
//     });
//   });
// }
// setInputFilter(document.getElementById("target_calory_gained"), function(value) {
//   return /^-?\d*[.,]?\d*$/.test(value); 
// });



</script>
@endsection