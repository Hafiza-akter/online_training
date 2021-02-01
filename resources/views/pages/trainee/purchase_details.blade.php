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
                        <h3>購入プラン</h3>
                    </div>
                </div>
            </div>

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
            <!--Accordion wrapper-->
    <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">

      <!-- Accordion card -->
      <div class="card">

        <!-- Card header -->
  

        <!-- Card body -->
        <div>
          <div class="card-body">

            <table class="table">
                 
                  <tbody>
                    <tr>
                      <td>
                        <div class="form-group">
                          @if($purchase)
                            <select class="form-control" name="planname" style="padding:5px;" id="planToshow">
                              <option value="0">Select Plan</option>
                           @foreach($purchase as $val)
                              <option value="{{$val->id}}">{{ $val->name}}</option>
                            @endforeach
                            </select>
                            @endif
                        </div>
                      </td>
                      <td>
                        <div class="form-group">
                          @if($purchase)
                          @foreach($purchase as $val)
                            <div id="{{$val->id}}" style="display: none;">
                             <h3 class="text-left">{{ $val->cost_per_month}} yen <small class="text-muted">/ mo</small></h3> 
                            </div>
                            @endforeach
                            @endif
                        </div>
                      </td>
                     
                    </tr>

                    <tr>
                      <td>
                       <div class="form-group">
                            <select class="form-control" style="padding:5px;" id="weight_loss_gain">
                              <option>Weight Loss</option>
                              <option>Weight Gain</option>
                            </select>
                        </div>
                      </td>
                      <td>
                       <div class="form-group">
                        <input type="text" name="weight" class="" value="{{ \App\Model\User::where('id',Session::get('user')->id)->get()->first()->weight}}"> KG
                      </div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <p>身体活動レベル</p>
                         <div class="form-check">
                      <input class="form-check-input" type="radio" name="pal" id="exampleRadios1" value="low" >
                      <label class="form-check-label" for="exampleRadios1">
                        低 : 生活の大部分が座位で、静的な活動が中心の場合
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="pal" id="exampleRadios2" value="medium" checked>
                      <label class="form-check-label" for="exampleRadios2">
                        中 : 座位中心の仕事だが、職場内での移動や立位での作業・接客等、あるいは通勤・買物・家事、軽いスポーツ等のいずれかを含む場合
                      </label>
                    </div>
                    <div class="form-check ">
                      <input class="form-check-input" type="radio" name="pal" id="exampleRadios3" value="high" >
                      <label class="form-check-label" for="exampleRadios3">
                      高 : 移動や立位の多い仕事への従事者。あるいは、スポーツなど余暇における活発な運動習慣をもっている場合
                    </label>
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
    <!-- Accordion wrapper -->

  </div>

 
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
new Chart(document.getElementById("line-chart"), {
  type: 'line',

  data: {
    labels: [0,1,2,3],
    
    datasets: [
    { 
        data: [70,67,64,60],
        label: "",
        borderColor: "#6d93ff",
        fill: false
      }, 
      { 
        data: [70,64,60,55],
        label: "",
        borderColor: "green",
        fill: false
      },
       { 
        data: [70,62,55,50],
        label: "",
        borderColor: "yellow",
        fill: false
      }, 
    
    ]
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
});

document.getElementById('weight_loss_gain').addEventListener('change', function() {
      var colorName = colorNames[config.data.datasets.length % colorNames.length];
      var newColor = window.chartColors[colorName];
      var newDataset = {
        label: 'Dataset ' + config.data.datasets.length,
        backgroundColor: newColor,
        borderColor: newColor,
        data: [],
        fill: false
      };

      for (var index = 0; index < config.data.labels.length; ++index) {
        newDataset.data.push(randomScalingFactor());
      }

      config.data.datasets.push(newDataset);
      window.myLine.update();
    });
</script>
@endsection