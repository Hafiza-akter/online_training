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
            <label class="col-form-label">体の部分 </label>
                <select class="form-control main" style="width: 100%;" name="main[]" disabled="disabled" readonly>
                    @if($body_part)
                      @foreach($body_part as $val)
                        <option id="{{ $val->body_part}}" {{$val->body_part ==  $coursesData->body_part ? 'selected' : '' }}>{{ $val->body_part}}</option>
                      @endforeach
                    @endif
                </select>
            </div>
            <div class="col-sm-4">
            <label class="col-form-label">Course</label>
                <select class="form-control course" style="width: 100%;" name="course[]" required="required" disabled="disabled" readonly>
                    @foreach(getCourseDataMain($coursesData->body_part) as $v)
                       <option value="{{$v->id}}" {{ $value->course_id == $v->id ? 'selected' : ''}}>{{ $v->course_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4">
            <label class="col-form-label">Equipment</label>
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
                  <button type="button" class="btn btn-secondary float-right m-2 add_button" onclick="showExplanation(`{{ $coursesData->summary}}`)" > Explanation </button>
               </div>

          </div>


        </div>
        @endforeach
        
@else 
 <h3> No data found </h3>      
@endif
