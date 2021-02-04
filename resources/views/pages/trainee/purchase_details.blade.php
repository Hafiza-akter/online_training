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
                  <i class="fas fa-check-circle"></i> Your current purchase plan is <span style="color: green !important"> {{ \App\Model\PlanPurchase::where('id',$userPurchasePlan->purchase_plan_id)->get()->first()->name}} </span>
                </h3>
            </div>
          </div>
         @endif

          <br> <br>
        <div class="row justify-content-center">
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
                                <select class="form-control" style="padding:5px;" id="weight_loss_gain" onchange="updateConfigAsNewObject()">
                                  <option>Weight Loss</option>
                                  <option>Weight Gain</option>
                                </select>
                            </div>
                          </td>
                       
                        </tr>
                       
                        <tr>
                           

                          <td>
                            {{-- <button type="button" class="btn btn-lg btn-block" style="border-radius: 1px !important;border: 2px solid #c604c6;font-size: 18px;">Purchase</button> --}}

                            @if(!$userPurchasePlan)
                            <div class="content">
                                <div class="links">
                                    <div id="paypal-button"></div>
                                </div>
                              </div>
                              <script src="https://www.paypalobjects.com/api/checkout.js"></script>
                              <script>
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

                                  })
                                    .then(function (res) {
                                      console.log(res)
                                      alert('Payment successfully done!!');
                                      Swal.fire(
                                          'Payment successfully done'
                                        )
                                      // 3. Show the buyer a confirmation message.
                                    })
                                }
                              }, '#paypal-button')
                              </script>
                              @else 
                              <i class="fas fa-check-circle"></i> Your already purchase  <span style="color: green !important"> {{ \App\Model\PlanPurchase::where('id',$userPurchasePlan->purchase_plan_id)->get()->first()->name}} </span>

                              @endif 
                        </td>
                      </tr>
                    </tbody>
                  </table>

                    <canvas id="line-chart" width="800" height="450"></canvas>

              </div>

          </div>
        </div>
    
  </div>

  <input type="hidden" id="dataset" value="{{ $dataset}}">
</section>






@endsection
@section('footer_css_js')
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
        text: 'weight loss graph'
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



function updateConfigAsNewObject() {
    config.data= {
    labels: [0,1,2,3],
    
    datasets: [
      { 
        data: [70,68,60,50],
        label: "",
        borderColor: "#6d93ff",
        fill: false
      }, 
      { 
        data: [70,67,59,55],
        label: "",
        borderColor: "green",
        fill: false
      },
      { 
        data: [70,60,55,50],
        label: "",
        borderColor: "yellow",
        fill: false
      }, 
    
    ]
  };
      window.myLine.update();
}


</script>
@endsection