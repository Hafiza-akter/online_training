@extends('master_dashboard')
@section('title','trainee trainerlist')
@section('header_css_js')
<script src="{{ asset('asset_v2/js/sweetalert.min.js')}}"></script>


@endsection
      {{-- @include('pages.trainee.dashboard') --}}
@section('content')
<style>
    .premeeting-screen .content .copy-meeting .copy-meeting-text,
.premeeting-screen .content .copy-meeting .url .jitsi-icon {
    display: none;
}
.performance{
    border: 1px solid #f8f8;
    padding: 14px;
    margin-bottom: 2px; 
}

</style>
<section class="review_part gray_bg section_padding">
    <div class="row justify-content-center">
        <div class="col-md-8 col-xl-6">
            <div class="section_tittle">
                <h3>トレーニング履歴</h3>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-10 col-xl-10">
        <div class="card mt-4">
            <div class="card-header">
                {{-- <h3 class="card-title">トレーニングリスト</h3> --}}
              <form action="{{route('traininglist')}}" method="post">
                   
                {{ csrf_field() }}               
                 <div class="row mb-3">
                  <div class="col-3">
                    <p class="col-form-label birthday">総トレーニング数:  {{ count($list)}}  </p>
                  </div>
                    <div class="col-4">
                    <input type="text" name="birthday" class="form-control datepicker" value="{{ $date != '' ? date('Y-m',strtotime($date)) : date('Y-m')}}" readonly="readonly">
                    
                  </div>
                  <div class="col-2">
                      <input type="submit" value="submit" class="nav-link active__" style="color:white;">
                  </div>
                </div>
              </form>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>トレーニング日</th>
                            <th>フィードバック</th>
                            <th>ユーザー名</th>
                            <th>詳細</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $i=1 @endphp
                    @if($list)
                      @foreach($list as $val)
                      @if(getTrainerName($val->trainer_schedule_id)->id == Session::get('user.id'))

                          <tr>
                              <td>{{ date('Y-m-d',strtotime($val->created_at)) }}</td>
                              <td>{{$val->trainer_feedback}}</td>
                              <td>{{ getUserName($val->trainer_schedule_id)->name }}</td>
                              <td>
                                <button type="button" class="nav-link active__" data-toggle="modal" data-target="#exampleModalScrollable{{$val->id}}" style="color:white;"> Details </button>
                              </td>
                          </tr>
                          @endif
                      @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
      </div>
    </div>
   
</section>

  @if($list)
  @foreach($list as $val)
    <div class="modal fade" id="exampleModalScrollable{{ $val->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" >
      <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background: #a331a3;">
            <h3 class="" id="exampleModalLabel" style="text-align: center;color: white;">
            トレーニング詳細
            </h3>
            
          </div>
          <div class="modal-body">
            @php 
            $exerciseData =  \App\Model\Training::where('trainer_schedule_id',$val->trainer_schedule_id)->first();
            @endphp
            @if($exerciseData)

              <!-- edit mode form-->

                    @foreach($exerciseData->getExerciseData as $key=>$value)
                    @php 
                        $coursesData = getCourseData($value->course_id);
                        $set1= $value->set_1;
                        $sd1=explode("_",$set1);

                        $set2= $value->set_2;
                        $sd2=explode("_",$set2);

                        $set3= $value->set_3;
                        $sd3=explode("_",$set3);

                        // dd($sd1[1]);

                    @endphp
                    <div class="container performance" id="performance{{$key > 0 ? $key : ''}}">
                      <div class="row" >
                        <div class="col-sm-4">
                        <label class="col-sm-2 col-form-label">メイン </label>
                            <select class="form-control main" style="width: 100%;" name="main[]" disabled="disabled" readonly>
                                @if($main)
                                  @foreach($main as $val)
                                    <option id="{{ $val->main}}" {{$val->main ==  $coursesData->main ? 'selected' : '' }}>{{ $val->main}}</option>
                                  @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-4">
                        <label class="col-sm-2 col-form-label">コース</label>
                            <select class="form-control course" style="width: 100%;" name="course[]" required="required" disabled="disabled" readonly>
                                @foreach(getCourseDataMain($coursesData->main) as $v)
                                   <option value="{{$v->id}}" {{ $value->course_id == $v->id ? 'selected' : ''}}>{{ $v->course_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                        <label class="col-sm-2 col-form-label">備品</label>
                            <select class="form-control equipment" style="width: 100%;" name="equipment[]" disabled="disabled" readonly>
                                   <option value="{{$v->equipment_id}}" >{{ getEquipment($coursesData->equipment_id)->name }}</option>
                            </select>
                        </div>
                        
                      </div>

                     

                      <div class="row justify-content-center">
                          <div class="col-sm-8  m-1 ">
                           <label class=" col-form-label">Set 1</label>
                            <input name="set1_kg[]" class="set1_kg kg p-1 m-1" value="{{ $sd1[0]}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required" disabled="disabled" readonly /><span>KG</span>
                            <input name="set1_times[]" class="set1_times times kg p-1 m-1" value="{{ $sd1[1]}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required" disabled="disabled" readonly /><span>回</span>

                          </div>
                          <div class="col-sm-8 m-1">
                           <label class=" col-form-label">Set 2</label>
                            <input name="set2_kg[]" class="set2_kg set1  kg p-1 m-1" value="{{ $sd2[0]}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required" disabled="disabled" readonly/><span>KG</span>
                            <input name="set2_times[]" class="set2_times times kg p-1 m-1" value="{{ $sd2[1]}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  required="required" disabled="disabled" readonly /><span>回</span>
                          </div>
                          <div class="col-sm-8 m-1">
                           <label class=" col-form-label">Set 3</label>
                            <input name="set3_kg[]" class="set3_kg kg p-1 m-1"  value="{{ $sd3[0]}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required" disabled="disabled" readonly/><span>KG</span>
                            <input name="set3_times[]" class="set3_times times kg p-1 m-1"  value="{{ $sd3[1]}}"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required" disabled="disabled" readonly/><span>回</span>
                          </div>
                          <div class="col-sm-8 m-1">
                              <button type="button" class="btn btn-secondary float-right m-2 add_button" onclick="showExplanation(`{{ $coursesData->summary}}`,`{{ $coursesData->sub}}`,`{{ $coursesData->way}}`,`{{ $coursesData->motion}}`)" > 説明 </button>
                           </div>

                      </div>


                    </div>
                    @endforeach
                    <div class="form-group  row justify-content-center">
                      <div class="col-sm-10">
                      <label class="col-form-label">コメントの入力</label>      
                         <p> {{ $exerciseData->comment }}</p>
                      </div>
                  </div>
                  <div class="form-group  row justify-content-center">
                      <div class="col-sm-10">
                      <label class="col-form-label">フィードバック</label>                 
                         <p> {{ $exerciseData->trainer_feedback }}</p>
                      </div>
                  </div>
                  

            @endif
            <!-- // end edit mode -->
          </div>

        </div>
      </div>
      </div>
    @endforeach
    @endif 

@section('footer_css_js')
<script src='{{ asset('asset_v2/js/sweetalert2@10.js')}}'></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<!-- for a specific version -->
<script
  src="https://cdn.jsdelivr.net/npm/zebra_datepicker@1.9.13/dist/zebra_datepicker.min.js"></script>
  <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/zebra_datepicker@latest/dist/css/bootstrap/zebra_datepicker.min.css">
<script>

  </script>

 <style>
      .Zebra_DatePicker .dp_body .dp_current{
        background:#a50ca4 !important;
        color:white;
      }
  </style>
  <script>
              $('.datepicker').Zebra_DatePicker({
                   direction: ['2021-01-01', false],
                    format: 'Y-m',

        });
 

  function showExplanation(text,sub,way,motion){
        Swal.fire({
           icon: '',
           title: '説明',
           html: " <br> <b> サマリ:</b> "+text+" <br> <br> サブ: "+sub
          + " <br> <br> <b>方法:</b> "+way
          + " <br> <br> <b>モーション:</b> "+motion,
           showConfirmButton:false
         })
  }
  </script>

@endsection 