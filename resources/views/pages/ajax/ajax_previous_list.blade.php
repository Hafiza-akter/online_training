<div class="table-responsive">
  <table class="table table-striped">
    <tbody>
@if(isset($data) && count($data) >0)
    @foreach($data as $key=>$val)
    @php 
      $set1= $val->set_1;
      $sd1=explode("_",$set1);

     
      $courseInfo=getCourseData($val->course_id);
    @endphp
      <tr id="{{ "prev_".$val->id ."_".$val->course_id}}" data-course_id="{{ $val->course_id}}" data-exercise_id="{{ $val->id}}" class="text-left">
        <td>
          <span class='fa-box{{ "prev_".$val->id ."_".$val->course_id}}'></span> 
          <span class="course_name">{{ $courseInfo->course_name ?? ''}} </span><br>
          ダンベルカール: <span class="comment_name">{{$val->exercise_comment}}</span>
        </td>
        <td>  備品: <span class="equp">{{ getEquipment($courseInfo->equipment_id)->name ?? '' }}</span>
        @if(isset($set1))
         <span class="kg">{{ $sd1[0]}}</span> kg <span class="times">{{ $sd1[1]}}</span> 回   <span class="effi">{{ $val->efficiency}} </span>%
        @endif
           </td>
      </tr>
    @endforeach
@else 
      <tr>
        <td>No data found </td>
        
      </tr>
@endif
    </tbody>
  </table>
</div>