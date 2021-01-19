@extends('master_dashboard')
@section('title','purchase plan')
@section('header_css_js')
<script src='{{ asset('asset_v2/js/Chart.min.js')}}'></script>
<script src='{{ asset('asset_v2/js/utils.js')}}'></script>
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
            <!--Accordion wrapper-->
    <div class="accordion md-accordion" id="accordionEx" role="tablist" aria-multiselectable="true">

      <!-- Accordion card -->
      <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="headingOne1">
          <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1" aria-expanded="true"
            aria-controls="collapseOne1">
            <h3 class="mb-0">
               Weekly Plan  <i class="fas fa-angle-down rotate-icon float-right float-right"></i>
            </h3>
          </a>
        </div>

        <!-- Card body -->
        <div id="collapseOne1" class="collapse show" role="tabpanel" aria-labelledby="headingOne1"
          data-parent="#accordionEx">
          <div class="card-body">

            <table class="table">
                 
                  <tbody>
                    <tr>
                      <td>
                        <div class="form-group">
                            <select class="form-control" style="padding:5px;">
                              <option>Weight Loss</option>
                              <option>Weight Gain</option>
                            </select>
                        </div>

                      </td>
                      <td><h3 class="text-center">24000 yen <small class="text-muted">/ mo</small></h3></td>
                      <td><button type="button" class="btn btn-lg btn-block" style="border-radius: 1px !important;border: 2px solid #c604c6;font-size: 18px;">Purchase</button></td>
                    </tr>
                  </tbody>
                </table>

                <canvas id="line-chart" width="800" height="450"></canvas>

          </div>
        </div>

      </div>
      <!-- Accordion card -->

      <!-- Accordion card -->
      <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="headingTwo2">
          <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseTwo2"
            aria-expanded="false" aria-controls="collapseTwo2">
            <h3 class="mb-0">
              Twice a week <i class="fas fa-angle-down rotate-icon float-right"></i>
            </h3>
          </a>
        </div>

        <!-- Card body -->
        <div id="collapseTwo2" class="collapse" role="tabpanel" aria-labelledby="headingTwo2"
          data-parent="#accordionEx">


          <div class="card-body">
            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
            labore sustainable VHS.
          </div>
        </div>

      </div>
      <!-- Accordion card -->

      <!-- Accordion card -->
      <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="headingThree3">
          <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseThree3"
            aria-expanded="false" aria-controls="collapseThree3">
            <h3 class="mb-0">
              Three times a week <i class="fas fa-angle-down rotate-icon float-right"></i>
            </h3>
          </a>
        </div>

        <!-- Card body -->
        <div id="collapseThree3" class="collapse" role="tabpanel" aria-labelledby="headingThree3"
          data-parent="#accordionEx">
          <div class="card-body">
            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
            labore sustainable VHS.
          </div>
        </div>

      </div>
       <div class="card">

        <!-- Card header -->
        <div class="card-header" role="tab" id="headingThree3">
          <a class="collapsed" data-toggle="collapse" data-parent="#accordionEx" href="#collapseThree3"
            aria-expanded="false" aria-controls="collapseThree3">
            <h3 class="mb-0">
              One time plan <i class="fas fa-angle-down rotate-icon float-right"></i>
            </h3>
          </a>
        </div>

        <!-- Card body -->
        <div id="collapseThree3" class="collapse" role="tabpanel" aria-labelledby="headingThree3"
          data-parent="#accordionEx">
          <div class="card-body">
            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
            wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
            eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla
            assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred
            nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer
            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus
            labore sustainable VHS.
          </div>
        </div>

      </div>
      <!-- Accordion card -->

    </div>
    <!-- Accordion wrapper -->

  </div>
</section>


<div class="row pb-5">
    <h2 class="mx-auto">Trainee's Page</h2>
</div>
{{-- <div class="row pb-3">
    <div class="col-sm border-round">
        <a class="btn">Schedule </a>
    </div>
    <div class="col-sm border-round">
        <a class="btn">Plan Purchase </a>
    </div>
    <div class="col-sm border-round">
        <a class="btn">Progress </a>
    </div>
    <div class="col-sm border-round">
        <a class="btn">ログインする </a>
    </div>
</div> --}}
{{-- <div class="row mb-5">
    <div class="offset-sm-4 col-sm-4 border-round">
        <a class="btn">Plan Purchase </a>
    </div>
    <div class="offset-sm-2 col-sm-8 pt-5">
        <h2 class="mx-auto">Current plan is weekly plan</h2>
    </div>
</div> --}}
<div class="row">
    <div class="col-sm">
        <div class="card-deck mb-3 text-center">
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Weekly Plan</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">24000 yen <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>24000 yen will increase for weight loss</li>
                    </ul>
                    <button type="button" class="btn btn-lg btn-block btn-primary">Purchase</button>
                </div>
            </div>
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Twice a week</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">48000 yen <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>lorem ipsum</li>

                    </ul>
                    <button type="button" class="btn btn-lg btn-block btn-primary">Purchase</button>
                </div>
            </div>
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Three times a week</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">72000 yen <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>lorem ipsum</li>

                    </ul>
                    <button type="button" class="btn btn-lg btn-block btn-primary">Purchase</button>
                </div>
            </div>

        </div>
    </div>

</div>
<div class="row">
    <div class="col-sm">
        <div class="card-deck mb-3 text-center">
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Three times a week</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">72000 yen <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>lorem ipsum</li>
                    </ul>
                    <button type="button" class="btn btn-lg btn-block btn-primary">Purchase</button>
                </div>
            </div>
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">One Time a week</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">4800 yen <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>lorem ipsum</li>

                    </ul>
                    <button type="button" class="btn btn-lg btn-block btn-primary">Purchase</button>
                </div>
            </div>
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Others any plan</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">---- yen <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>lorem ipsum</li>
                    </ul>
                    <button type="button" class="btn btn-lg btn-block btn-primary">Purchase</button>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

@endsection
@section('footer_css_js')
<script>
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
</script>
@endsection