<div class="table-responsive">
  <table class="table table-striped">
    <tbody>
@if(isset($data) && count($data) >0)
    @foreach($data as $key=>$val)
    @php 
      $set1= $val->set_1;
      $sd1=explode("_",$set1);

      $set2= $val->set_2;
      $sd2=explode("_",$set2);

      $set3= $val->set_3;
      $sd3=explode("_",$set3);
      $courseInfo=getCourseData($val->course_id);
    @endphp
      <tr data-course_id="{{ $val->course_id}}" data-exercise_id="{{ $val->id}}" class="text-left">
        <td>
          {{ $courseInfo->course_name ?? ''}} <br>
          ダンベルカール: {{$val->trainer_feedback}}
        </td>
        <td>備品: {{ getEquipment($courseInfo->equipment_id)->name ?? '' }}
        @if(isset($set1))
         {{ $sd1[0]}}kg {{ $sd1[0]}}回
        @endif
       {{--  @if(isset($set2))
         Set:2 {{ $sd2[0]}}kg {{ $sd2[0]}}回
        @endif
        @if(isset($set3))
         Set:3 {{ $sd3[0]}}kg {{ $sd3[0]}}回
        @endif --}}
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