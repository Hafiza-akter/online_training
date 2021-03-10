@extends('auth/master')
@section('title','trainer schedule')
@section('content')
    <div class="row pb-5">
      <h2 class="mx-auto">オンライントレーニング</h2>
    </div>
    <div class="row pb-3">
      <div class="col-sm border-round">
        <a class="btn">ログイン </a>       
      </div>
      <div class="col-sm border-round">
        <a class="btn">ログイン </a>       
      </div>
      <div class="col-sm border-round">
        <a class="btn">ログイン </a>       
      </div>
      <div class="col-sm border-round">
        <a class="btn">ログイン </a>       
      </div>
    </div>
    <div class="row mb-5">
      <div class="offset-sm-4 col-sm-4 border-round">
        <a class="btn">ログイン </a> 
     </div>
    </div>
    <div class="row pb-5  page-content page-container" id="chart">
      <!-- <h2 class="mx-auto">オンライントレーニング</h2> -->
    </div>
    
  </div>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


<script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.bundle.min.js'></script>
  <script>
      var options = {
        series: [{
        data: [400, 430, 448, 470, 540, 580, 690, 1100, 1200, 1380]
      }],
        chart: {
        type: 'bar',
        height: 380
      },
      plotOptions: {
        bar: {
          barHeight: '100%',
          distributed: true,
          horizontal: true,
          dataLabels: {
            position: 'bottom'
          },
        }
      },
      colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
        '#f48024', '#69d2e7'
      ],
      dataLabels: {
        enabled: true,
        textAnchor: 'start',
        style: {
          colors: ['#fff']
        },
        formatter: function (val, opt) {
          return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val
        },
        offsetX: 0,
        dropShadow: {
          enabled: true
        }
      },
      stroke: {
        width: 1,
        colors: ['#fff']
      },
      xaxis: {
        categories: ['South Korea', 'Canada', 'United Kingdom', 'Netherlands', 'Italy', 'France', 'Japan',
          'United States', 'China', 'India'
        ],
      },
      yaxis: {
        labels: {
          show: false
        }
      },
      title: {
          text: '',
          align: 'center',
          floating: true
      },
      subtitle: {
          text: '',
          align: 'center',
      },
      tooltip: {
        theme: 'dark',
        x: {
          show: false
        },
        y: {
          title: {
            formatter: function () {
              return ''
            }
          }
        }
      }
      };

      var chart = new ApexCharts(document.querySelector("#chart"), options);
      chart.render();
  </script>
  @endsection