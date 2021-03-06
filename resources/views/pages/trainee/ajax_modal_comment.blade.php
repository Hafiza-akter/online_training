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
        <form action="{{route('training_feedback')}}" method="post" id="performance_form">
            <!-- edit mode form-->

              <input type="hidden" name="schedule_id" value="{{ $schedule->id}}">
              <input type="hidden" name="trainer_id" value="{{ $schedule->trainer_id}}">
            {{ csrf_field() }}
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
             <div class=" row justify-content-center">
          <button type="button" class="btn btn-secondary m-1" data-dismiss="modal">Close</button>
          <button type="submit" class="nav-link active__ m-1" style="color: white;">Submit</button>
        </div>
          </form>


        </div>
        @endforeach
        
@else 
 <h3> No data found </h3>      
@endif
