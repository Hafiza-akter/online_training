@extends('master_dashboard')
@section('title','trainee trainerlist')
@section('header_css_js')
<script src="{{ asset('asset_v2/js/sweetalert.min.js')}}"></script>
<style>

.performance{
    border: 1px solid #f8f8;
    padding: 14px;
    margin-bottom: 2px; 
}

</style>
@endsection
      {{-- @include('pages.trainee.dashboard') --}}
@section('content')

<section class="review_part gray_bg section_padding" style="margin-top:-74px">
{{--     <div class="row justify-content-center">
        <div class="col-md-8 col-xl-6">
            <div class="section_tittle">
                <h3>トレーニングページ</h3>
            </div>
        </div>
    </div> --}}

</section>

    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle"  data-backdrop="static" data-keyboard="false" >
      <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header" style="background: #a331a3;">
            <h3 class="" id="exampleModalLabel" style="text-align: center;color: white;">
            トレーニングデータ
            </h3>
            
          </div>
          <div class="modal-body">
            @if(!$exerciseData || count($exerciseData->getExerciseData) == 0)
              <div class="offset-md-1 col-md-10">
                <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-danger') }} alert-dismiss">No training data found</p>
              </div>
            <form action="{{route('training_performance')}}" method="post" id="performance_form">
              {{ csrf_field() }}
              <!-- insert mode form-->
                <input type="hidden" name="schedule_id" value="{{ $schedule->id}}">
                <input type="hidden" name="trainer_id" value="{{ $schedule->trainer_id}}">

                    <div class="container performance" id="performance">
                      <div class="row" >
                        <div class="col-sm-4">
                        <label class=" col-form-label">メイン</label>
                            <select class="form-control main" style="width: 100%;" name="main[]" >
                                <option value="">--select--</option>
                                @if($main)
                                  @foreach($main as $val)
                                    <option id="{{ $val->main}}">{{ $val->main}}</option>
                                  @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-4">
                        <label class=" col-form-label">コース</label>
                            <select class="form-control course" style="width: 100%;" name="course[]" required="required">
                                <option value="">--select--</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                        <label class=" col-form-label">備品</label>
                            <select class="form-control equipment" style="width: 100%;" name="equipment[]" >
                                <option value="">--select--</option>
                            </select>
                        </div>
                        
                      </div>
                      <div class="row justify-content-center">
                          <div class="col-sm-8  m-1 ">
                           <label class=" col-form-label">Set 1</label>
                            <input name="set1_kg[]" class="set1_kg kg p-1 m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>KG</span>
                            <input name="set1_times[]" class="set1_times times kg p-1 m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required" /><span>回</span>

                          </div>
                          <div class="col-sm-8 m-1">
                           <label class=" col-form-label">Set 2</label>
                            <input name="set2_kg[]" class="set2_kg set1  kg p-1 m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>KG</span>
                            <input name="set2_times[]" class="set2_times times kg p-1 m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  required="required"/><span>回</span>
                          </div>
                          <div class="col-sm-8 m-1">
                           <label class=" col-form-label">Set 3</label>
                            <input name="set3_kg[]" class="set3_kg kg p-1 m-1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>KG</span>
                            <input name="set3_times[]" class="set3_times times kg p-1 m-1"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>回</span>
                          </div>
                      </div>
                    </div>

                      <div class="col-sm-8 m-1">
                            <button type="button" class="btn btn-secondary float-right m-2 add_button" > <i class="fas fa-plus"></i> </button>
                      </div>

                      <br> <br>
                      <div class="  row justify-content-center">
                        <div class="col-md-12">
                        <label class="col-form-label">コメントの入力</label>
                            @if(Session::get('user_type') == 'trainee'){
                            <textarea class="form-control customEditor"  name="user_feedback" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $exerciseData ? $exerciseData->comment : ''}}</textarea>
                            @else 
                             <textarea class="form-control customEditor"  name="user_feedback" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $exerciseData ? $exerciseData->trainer_feedback: ''}}</textarea>
                            @endif
                        </div>
                    </div>
                      <div class=" row justify-content-center m-1 p-1">
                        {{-- <button type="button" class="btn btn-secondary m-1" data-dismiss="modal">Close</button> --}}
                      <a href="#" class="nav-link active__ m-1 " id="submit_performance" style="color: white;">送信する</a>
                      </div>
            </form>
            @endif

            @if($exerciseData &&  count($exerciseData->getExerciseData) > 0)
            <form action="{{route('success')}}" method="post" id="performance_form">
              {{ csrf_field() }}
              <!-- edit mode form-->

                <input type="hidden" name="schedule_id" value="{{ $schedule->id}}">
                <input type="hidden" name="trainer_id" value="{{ $schedule->trainer_id}}">
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
                        <label class=" col-form-label">メイン </label>
                            <select class="form-control main" style="width: 100%;" name="main[]" >
                                @if($main)
                                  @foreach($main as $val)
                                    <option id="{{ $val->main}}" {{$val->main ==  $coursesData->main ? 'selected' : '' }}>{{ $val->main}}</option>
                                  @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-4">
                        <label class=" col-form-label">コース</label>
                            <select class="form-control course" style="width: 100%;" name="course[]" required="required">
                                @foreach(getCourseDataMain($coursesData->main) as $v)
                                   <option value="{{$v->id}}" {{ $value->course_id == $v->id ? 'selected' : ''}}>{{ $v->course_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                        <label class=" col-form-label">備品</label>
                            <select class="form-control equipment" style="width: 100%;" name="equipment[]" >
                                   <option value="{{$v->equipment_id}}" >{{ getEquipment($coursesData->equipment_id)->name }}</option>
                            </select>
                        </div>
                        
                      </div>

                     

                      <div class="row justify-content-center">
                          <div class="col-sm-8  m-1 ">
                           <label class=" col-form-label">Set 1</label>
                            <input name="set1_kg[]" class="set1_kg kg p-1 m-1" value="{{ $sd1[0]}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>KG</span>
                            <input name="set1_times[]" class="set1_times times kg p-1 m-1" value="{{ $sd1[1]}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required" /><span>回</span>

                          </div>
                          <div class="col-sm-8 m-1">
                           <label class=" col-form-label">Set 2</label>
                            <input name="set2_kg[]" class="set2_kg set1  kg p-1 m-1" value="{{ $sd2[0]}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>KG</span>
                            <input name="set2_times[]" class="set2_times times kg p-1 m-1" value="{{ $sd2[1]}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  required="required"/><span>回</span>
                          </div>
                          <div class="col-sm-8 m-1">
                           <label class=" col-form-label">Set 3</label>
                            <input name="set3_kg[]" class="set3_kg kg p-1 m-1"  value="{{ $sd3[0]}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>KG</span>
                            <input name="set3_times[]" class="set3_times times kg p-1 m-1"  value="{{ $sd3[1]}}"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required="required"/><span>回</span>
                          </div>

                          
                      </div>

                      @if($key > 0)
                      <input type="button" value="削除" class="m-1 remove btn btn-danger"/>
                      @endif
                    </div>
                    @endforeach

                        <button type="button" class="btn btn-secondary float-right m-2 add_button" > <i class="fas fa-plus"></i> </button>
                    <br>
                    <div class="form-group  row justify-content-center">
                        <div class="col-sm-10">
                        <label class="col-form-label">コメントの入力</label>
                            @if(Session::get('user_type') == 'trainee'){
                            <textarea class="form-control customEditor"  name="user_feedback" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $exerciseData ? $exerciseData->comment : ''}}</textarea>
                            @else 
                             <textarea class="form-control customEditor"  name="user_feedback" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $exerciseData ? $exerciseData->trainer_feedback: ''}}</textarea>
                            @endif
                        </div>
                    </div>
              <div class=" row justify-content-center m-1 p-1">
                <a href="#" class="nav-link active__ m-1 " id="submit_performance" style="color: white;">送信する</a>
              
              </div>
            </form>
            @endif
            <!-- // end edit mode -->
          </div>

        </div>
      </div>
      </div>
     <input type="hidden" value="{{ $exerciseData ? count($exerciseData->getExerciseData) : 1}}" id="counter">
  

    

  
@endsection
@section('footer_css_js')
<script src='{{ asset('asset_v2/js/sweetalert2@10.js')}}'></script>

<script>
  

      // for upazila
  $(document).on('change', '.main', function() {


  // $('.main').on('change', function() {
    // console.log($(this option:selected).text());
    var main =  $(this).find('option:selected').text();
    // console.log(main);
    var id = $(this).parent().closest('.performance').attr('id');
    // console.log(id);
    $.ajax
      ({
        type: "POST",
        url: '{{ route('getcourse')}}',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { 'main': main },
        cache: false,
        success: function (data) {
          // console.log(data.location);
          console.log(id);
          console.log($(this).find('.course'));

          // console.log($('.course','#'.id));

          $('.course','#'+id).empty();
          $('.equipment','#'+id).empty();
           $('.set1_kg','#'+id).empty();
          $('.set1_times','#'+id).empty();

          $('.set2_kg','#'+id).empty();
          $('.set2_times','#'+id).empty();

          $('.set3_kg','#'+id).empty();
          $('.set3_times','#'+id).empty();

          $('.equipment','#'+id).empty();
          

          // $('#equipment').append($('<option>', { value: '', text: '--select--' }));
          $('.course','#'+id).append($('<option>', { value: '', text: '--select--' }));
          $('.equipment','#'+id).append($('<option>', { value: '', text: '--select--' }));
          $.each(data, function (i, item) {
            // console.log(item.upazila_name);
            $('.course','#'+id).append($('<option>', { value: item.id, text: item.course_name }));
            $('.equipment','#'+id).append($('<option>', { value: item.equipment_id, text: item.equipment_name }));
          });
        },
        dataType: "json"
      });
  });

  $(document).on('change', '.course', function() {
    // console.log($("#course option:selected").value());
    var course = $(this).find('option:selected').val();
    console.log(course);
    var id = $(this).parent().closest('.performance').attr('id');
    $.ajax
      ({
        type: "POST",
        url: '{{ route('getcoursedetails')}}',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { 'course': course },
        cache: false,
        success: function (data) {
          // console.log(data.location);
          // console.log(data);
          $('.set1_kg','#'+id).empty();
          $('.set1_times','#'+id).empty();

          $('.set2_kg','#'+id).empty();
          $('.set2_times','#'+id).empty();

          $('.set3_kg','#'+id).empty();
          $('.set3_times','#'+id).empty();

          $('.equipment','#'+id).empty();
          $('.equipment','#'+id).append($('<option>', { value: '', text: '--select--' }));
          
          $.each(data, function (i, item) {
            // console.log(item.upazila_name);
            let s1= item.set_1.split("_");$('.set1_kg','#'+id).val(s1[0]);$('.set1_times','#'+id).val(s1[1]);
            let s2= item.set_2.split("_");$('.set2_kg','#'+id).val(s2[0]);$('.set2_times','#'+id).val(s2[1]);
            let s3= item.set_3.split("_");$('.set3_kg','#'+id).val(s3[0]);$('.set3_times','#'+id).val(s3[1]);
            $('.equipment','#'+id).append($('<option>', { value: item.equipment_id, text: item.equipment_name }));
          });
        },
        dataType: "json"
      });
  });
  $(document).ready(function(){
    $('#exampleModalScrollable').modal('show');

    var cloneCount = parseInt($('#counter').val());
    // let r= $('<input type="button" value="削除" class="m-1 remove btn btn-danger"/>');

   $(".add_button").click(function(){
      let r= $('<input type="button" value="削除" class="m-1 remove btn btn-danger"/>');
      let id = 'performance'+ cloneCount++;
      $("#performance").clone().attr('id',id).insertAfter($('[id^=performance]:last'));
        $("#"+id).append(r);
   }); 

 // Remove element

  $("#submit_performance").click(function(){
        
         var form = $("#performance_form");
          var url = form.attr('action');
          
          $.ajax({
                 type: "POST",
                 url: url,
                  headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                 data: form.serialize(), // serializes the form's elements.
                 success: function(data)
                 {
                     Swal.fire({
                        icon: 'success',
                        title: 'Course data set successfully ',
                        showConfirmButton:true
                      })
                      window.location.href ="{{ route('traininglist') }}";
                 }
          });

        //  var lngtxt=(form.find('input[name="course[]"]').val()).length;
        // console.log(lngtxt);
        // if (lngtxt==0){
        //     alert('please enter value');
        //     return false;
        // }else{
        //     //submit
        // }
    
   }); 

});
  $(document).on("click", ".remove", function() {
       $(this).parent().remove(); 
});

  function showExplanation(text){
        Swal.fire({
           icon: '',
           title: '説明',
           text: text,
           showConfirmButton:false
         })
  }
  </script>

@endsection 