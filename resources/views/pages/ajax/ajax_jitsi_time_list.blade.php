<div class="tmn_list">
  <div class="row justify-content-left">
    <button class="btn btn-sm btn-primary" onclick="show_calendar_jitsi()">Back</button>
  </div>
   <div class="row justify-content-center pt-3">
      <div class="container disalbed_container">
        <div class="spinner-border text-primary ld">
          <span class="sr-only">Loading...</span>
        </div>
          <div class="response_"></div>
          @if(isset($data))
            <h3>{{ $date }}</h3>
            <input type="hidden" id="initial_date" value="{{ $date}}">
            <div class="row col-md-12 text-center">
            @foreach($data as $key=>$value)


                <div id="time_{{ $value['id']}}" class="col-md-3  text-white m-2 p-2 pointer {{ $value['is_occupied'] == 1 ? 'tred disabledDiv' : 'bg-primary'}}" onclick="submitAjax('{{$date}}','{{$value['trainer_id']}}','{{$value['time']}}','{{ $user_id}}',this)">
                   {{ Carbon\Carbon::parse($value['time'])->format('H:i'). " ~ ".Carbon\Carbon::parse($value['time'])->addHour()->format('H:i') }}
                </div>
              

          @endforeach
          </div>
          @endif
       
    </div>
  </div>
</div>