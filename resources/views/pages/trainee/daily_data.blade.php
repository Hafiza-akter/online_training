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
                    <h3>ユーザーの成果</h3>
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
                              <i class="fas fa-trophy"></i> ユーザーの成果
                            </a>
                          </li>

                          <li class="list-inline-item {{ $isActive == 'dailydata' ? 'btn_active_' : 'btn-secondary'}}" style="padding:10px;color: white;">
                            <a href="{{ route('dailydata',date('Y-m-d'))}}" style="color: #fff">
                            <i class="fas fa-plus"></i>  毎日のデータ
                            </a>
                           </li>

                        </ul>

                    </div>
                <!-- Card body -->
                   <form action="{{route('dailydata.submit')}}" method="post">

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


                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    @if(Session::has('success'))
                                    <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}</p>
                                    @endif

                                </div>

                          <div class="col-md-12 col-xl-12">

                           <table class="table">
                     
                          <tbody>
                   
                            {{ csrf_field() }}
                                <input type="hidden" name="email" class="form-control" value="{{ $user->email}}">
                                <input type="hidden" name="user_id" class="form-control" value="{{ $user->id}}">   
                             <tr>
                              <td>
                                <div class="form-group">
                                    <label> Date </label>
                                    <input  type="text"   class="form-control" name="datepicker_" id="datepicker_" value="{{ $ua && $ua->recorded_at ? $ua->recorded_at : ''}}" placeholder="" />
                                </div>
                              </td> 
                              <td></td>
                                                       
                            </tr>
                            <tr>
                              <td>
                                <div class="form-group">
                                    <label> Weight Morning(Kg) </label>
                                    <input  type="number"    step="0.01"    class="form-control" name="weight_morning" id="weight" value="{{ $ua && $ua->weight_morning ? $ua->weight_morning : ''}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="" />
                                </div>
                              </td> 
                               <td>
                                <div class="form-group">
                                    <label> Weight Evening(Kg)  </label>
                                    <input  type="number"    step="0.01"  class="form-control" name="weight_evening" id="fat" value="{{ $ua && $ua->weight_evening ? $ua->weight_evening : ''}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="" />
                                </div>
                              </td>                          
                            </tr>

                            <tr>
                              <td>
                                <div class="form-group">
                                    <label>  Body Fat Percentage Morning(%)</label>
                                    <input  type="text"    onpaste="return false"  class="form-control" name="fat_morning" value="{{ $ua && $ua->body_fat_percentage_morning ? $ua->body_fat_percentage_morning : ''}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="" />
                                </div>
                              </td> 
                               <td>
                                <div class="form-group">
                                    <label> Body Fat Percentage Evening(%) </label>
                                    <input  type="text"    onpaste="return false"  class="form-control" name="fat_evening" id="fat" value="{{ $ua && $ua->body_fat_percentage_evening ? $ua->body_fat_percentage_evening : ''}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="" />
                                </div>
                              </td>                          
                            </tr>
                             <tr>
                              <td>
                                <div class="form-group">
                                    <label> Calory Gained </label>
                                    <input  type="number"    onpaste="return false"  class="form-control" name="calory_gained" id="calory_gained" value="{{ $ua && $ua->calory_gained ? $ua->calory_gained : ''}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  placeholder="" />
                                </div>
                              </td> 
                               <td>

                              </td>                          
                            </tr>


                            
                           
                        </tbody>
                         </table>
                          <div class="col">
                                    <label class="col-form-label _pal_">身体活動レベル <span style="color:red">*</span> </label>
                                    <div class="col-8">
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" name="pal" id="exampleRadios1" value="low" {{ $ua && $ua->pal == 1.55 ? 'checked': ''}} >
                                          <label class="form-check-label" for="exampleRadios1">
                                              低 ( 生活の大部分が座位で、静的な活動が中心の場合 )
                                          </label>
                                        </div>
                                        <div class="form-check">
                                          <input class="form-check-input" type="radio" name="pal" id="exampleRadios2" value="medium"  {{ $ua && $ua->pal == 1.75 ? 'checked': ''}}>
                                          <label class="form-check-label" for="exampleRadios2">
                                            中 ( 座位中心の仕事だが、職場内での移動や立位での作業・接客等、あるいは通勤・買物・家事、軽いスポーツ等のいずれかを含む場合 )
                                          </label>
                                        </div>
                                        <div class="form-check disabled">
                                          <input class="form-check-input" type="radio" name="pal" id="exampleRadios3" value="high" {{ $ua && $ua->pal == 2 ? 'checked': ''}}>
                                          <label class="form-check-label" for="exampleRadios3">
                                            高 ( 移動や立位の多い仕事への従事者。あるいは、スポーツなど余暇における活発な運動習慣をもっている場合 )
                                          </label>
                                        </div>
                                    </div>
                                </div>
                                
                          </div>
                      </div>
                  </div>
                      <div class="card-footer">
                          <div class="row ">
                              <button type="submit" class="mx-auto btn btn_2 sibscribe-btm mt-10 ">参加する</button>
                          </div>
                      </div>
                           </form>

              </div>
            </div>
          </div>
    
  </div>

  <div class="offset-md-1 col-md-10 mt-30" id="scheduleList">

           <h4 class="" style="text-align: center;">サービスの特徴</h4>

    <table class="table table-striped" style="background: #f9f9ff;">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Date</th>
        <th scope="col">Weight Morning</th>
        <th scope="col">Weight Evening</th>
        <th scope="col">Calory Gained</th>
        <th scope="col">PAL</th>
        <th scope="col">Action</th>
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
              <a class="btn btn-danger" href="{{ route('dailydata',\Carbon\Carbon::parse($val->recorded_at)->format('Y-m-d')) }}">Edit</a>
            </td>
          </tr>
        @endforeach
      @endif
      
    </tbody>
  </table>
     
</div>
</section>



@endsection
@section('footer_css_js')

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>

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

$(function() {
  $('input[name="datepicker_"]').daterangepicker({
    singleDatePicker: true,
    locale: {
      format: 'YYYY-MM-DD'
    }
  });
});

</script>
@endsection