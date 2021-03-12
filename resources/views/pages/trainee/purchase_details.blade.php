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
   {{--     <div class="row justify-content-center">
            <div class="col-md-8 col-xl-6">
                <div class="section_tittle">
                    <h3>購入プラン</h3>
                </div>
            </div>
        </div> --}}

        @if($userPurchasePlan)
          <div class="card">
            <!-- Card header --> 
            <div class="card-header success" >
                <h3 class="mb-0">
                  <i class="fas fa-check-circle"></i> 現在選択中のプランは <span style="color: green !important"> {{ \App\Model\PlanPurchase::where('id',$userPurchasePlan->purchase_plan_id)->get()->first()->name}} </span>です。
                </h3>
            </div>
          </div>
         @endif

          <br> <br>
        <div class="row justify-content-center">
          <div class="col-md-12 col-xl-12">

          <div class="card">
                <div class="card-header">
                    <h3 style="text-align: center;">購入プラン</h3>

                </div>
            <!-- Card body -->
              <div class="card-body">
                 <div class="row justify-content-center">
                      <div class="col-md-8 col-xl-6">
                          <div class="">
                              @if($purchase)
                                @foreach($purchase as $val)
                                  @if($val->times_per_week == 1)
                                       <h2 id="{{$val->id}}" style="text-align:center" >
                                        {{ $val->cost_per_month}} yen <small class="text-muted">/ mo</small>
                                       </h2>
                                  @else 
                                        <h2 id="{{$val->id}}" style="display: none;text-align:center">
                                        {{ $val->cost_per_month}} yen <small class="text-muted">/ mo</small>
                                       </h2>      
                                  @endif

                                @endforeach
                              @endif

                          </div>
                      </div>
                  </div>

                  <div class="form-group">
                    @if($purchase)
                    @foreach($purchase as $val)
                      <div id="{{$val->id}}" style="display: none;">
                       <h3 class="text-left">{{ $val->cost_per_month}} yen <small class="text-muted">/ mo</small></h3> 
                      </div>
                    @endforeach
                    @endif
                  </div>

                <table class="table">
                     
                      <tbody>
                        <tr>
                          <td>
                            <div class="form-group">
                              @if($purchase)
                                <select class="form-control" name="planname" style="padding:5px;" id="planToshow">
                                    @foreach($purchase as $val)
                                      <option value="{{$val->id}}" @if($val->times_per_week == 1) selected="selected" @endif >{{ $val->name}}</option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                          </td>

                         
                        </tr>
                         <tr>
                          <td>
                           <div class="form-group">
                                <select class="form-control" name="period_month" style="padding:5px;" id="period_month" >
                                  <option value="1">一か月</option>
                                  <option value="2">二か月</option>
                                  <option value="3">3ヶ月</option>
                                </select>
                            </div>
                          </td>
                       
                        </tr>
                        <tr>
                          <td>
                           <div class="form-group">
                                <select class="form-control" style="padding:5px;" id="weight_loss_gain" >
                                  <option value="weight_loss">Weight Loss</option>
                                  <option value="weight_gain">Weight Gain</option>
                                </select>
                            </div>
                          </td>
                       
                        </tr>
                         <tr>
                          <td>
                            <div class="form-group">
                                <label>Target Calory Gain ( <span style="font-size: 12px;"> Default value is {{ $bmrData*$user->pal }} </span>) </label>
                                <input  type="text" onblur="checkInput()"  onkeypress="return event.charCode >= 48 && event.charCode <= 57" onpaste="return false"  class="form-control" name="target_calory_gained" id="target_calory_gained" value="{{ $bmrData*$user->pal }}" placeholder="Enter target calory gain" />
                            </div>
                              <div class="fa-2x" style="display: none;" id="loader">
                                <i class="fas fa-spinner fa-spin"></i>
                              </div>
                          </td>                         
                        </tr>
                       
                        <tr>
                           

                        <td>
                            {{-- <button type="button" class="btn btn-lg btn-block" style="border-radius: 1px !important;border: 2px solid #c604c6;font-size: 18px;">Purchase</button> --}}

                            <div class="content">
                                <div class="links">
                                    <div id="paypal-button"></div>
                                </div>
                              </div>
                              
                             {{--  <h2><i class="fas fa-check-circle"></i> You already purchase  <span style="color: green !important"> {{ \App\Model\PlanPurchase::where('id',$userPurchasePlan->purchase_plan_id)->get()->first()->name}} </span>
                              </h2> --}}

                        </td>
                       
                      </tr>
                    </tbody>
                  </table>

                    <canvas id="line-chart" width="800" height="450"></canvas>

              </div>

          </div>
        </div>
      </div>
    <div class="offset-md-1 col-md-10 mt-30" id="scheduleList">

           <h4 class="" style="text-align: center;">購入リスト</h4>

    <table class="table table-striped" style="background: #f9f9ff;">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">購入プラン</th>
        <th scope="col">目標</th>
        <th scope="col">目標カロリー</th>
        <th scope="col">作成日</th>
      </tr>
    </thead>
    <tbody>
      @if($purchasePlaneList)
        @foreach($purchasePlaneList as $key=>$val)
          <tr>
            <th scope="row">{{ ++$key}}</th>
            <td>{{ \App\Model\PlanPurchase::where('id',$val->purchase_plan_id)->get()->first()->name}}</td>
            <td>{{ $val->objective}}</td>
            <td>{{ $val->target_calory_gained}}</td>
            <td>{{ $val->created_at}}</td>
          
          
          </tr>
        @endforeach
      @endif
      
    </tbody>
  </table>
</div>
  </div>

  <input type="hidden" id="dataset" value="{{ $dataset}}">
  <input type="hidden" id="weight" value="{{ $user->weight}}">
  <input type="hidden" id="pal" value="{{ $user->pal}}">
  <input type="hidden" id="totalday" value="90">
  <input type="hidden" id="startday" value="1">
  <input type="hidden" id="bmrData" value="{{ $bmrData*$user->pal }}">

</section>






@endsection
@section('footer_css_js')
<script src="https://www.paypalobjects.com/api/checkout.js"></script>

  <script>
    if(("#paypal-button").length){
  paypal.Button.render({
    env: 'sandbox', // Or 'production'
    style: {
      size: 'large',
      color: 'gold',
      shape: 'pill',
    },
    // Set up the payment:
    // 1. Add a payment callback
    payment: function (data, actions) {
      // 2. Make a request to your server
      return actions.request.post('{{ route('cp')}}')
        .then(function (res) {
          // 3. Return res.id from the response
          // console.log(res);
          return res.id
        })
    },
    // Execute the payment:
    // 1. Add an onAuthorize callback
    onAuthorize: function (data, actions) {
      // 2. Make a request to your server
      return actions.request.post('{{ route('conp')}}', {
        payment_id: data.paymentID,
        payer_id: data.payerID,
        user_id: {{ Session::get('user.id')}},
        purchase_plan_id: $('#planToshow option:selected').attr('value'),
        period_month:$('#period_month option:selected').attr('value'),
        target_calory_gained: $('#target_calory_gained').val(),
        objective:$('#weight_loss_gain option:selected').attr('value')
      })
        .then(function (res) {
          console.log(res)
          alert('支払いが完了しました。');
          Swal.fire(
              '支払いが完了しました。'
            );
          location.reload();

          // 3. Show the buyer a confirmation message.
        })
    }
  }, '#paypal-button')
}
  </script>
<script>
$(document).on('change','#planToshow', function(e) {
    $('#1').hide();
    $('#2').hide();
    $('#3').hide();

  $('#'+$(this).val()).show();
});
var dataset = JSON.parse($('#dataset').val());
console.log(dataset);
var config = {
    type: 'line',

    data: {
      labels: [0,1,2,3],
      
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
        text: '体重減少グラフ'
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
            config.options.title.text= ( params.type == '-1' ? "体重増加グラフ" : "体重減少グラフ");
                window.myLine.update();
      })
    .catch(err => console.log(err))



}

function setInputFilter(textbox, inputFilter) {
  ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
    textbox.addEventListener(event, function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    });
  });
}
setInputFilter(document.getElementById("target_calory_gained"), function(value) {
  return /^-?\d*[.,]?\d*$/.test(value); 
});

</script>
@endsection