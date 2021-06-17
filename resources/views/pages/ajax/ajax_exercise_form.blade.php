@if(isset($data) && count($data) >0)
    @foreach($data as $key=>$val)
    @php 
      $set1= $val->set_1;
      $sd1=explode("_",$set1);
    @endphp
    <div class="col-sm-4 " data-course_id="{{$val->id}}">
        <label class="col-form-label">コース</label>
        <p>{{ $val->course_name ?? ''}}</p>
    </div>
     <div class="col-sm-4 ">
        <label class="col-form-label">メイン</label>
        <p>{{ $val->body_part ?? ''}}</p>
    </div>
     <div class="col-sm-4 ">
        <label class="col-form-label">備品</label>
        <p>{{ $val->equipment_name ?? ''}}</p>
    </div>

    @endforeach
@else 
    <div class="col-sm-12 ">
        No data found
    </div>
@endif
    