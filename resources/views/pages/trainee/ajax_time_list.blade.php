 <div class="row justify-content-center">
      <div class="container">


        <div class="parent">

          <div class="div1 timeboxd">
              @php 
                $i=2;
                $k=2;
              @endphp
          </div>

          @if(isset($data))
          @php 
            $data = array_slice($data,0,4,true);
          @endphp
          @foreach($data as $key=>$val)
            <div class="div{{ $i}} text-center imgd">
              <input type="hidden" value="{{ 'trainer_id:'.$val['trainer_id'] }}">
                
               @if($val['imagesurl'] != NULL)

                  <img  style="width:200px" src="{{asset('images').'/'.$val['imagesurl']}}" style="height: 200;width: 200" />
                @else 

                  <img src="{{asset('images/user-thumb.jpg')}}" style="height: 200;width: 200">
                @endif
               <p class="tname">{{ $val['name']}}</p>
            </div>
          @php 
            $i++;
          @endphp  
          @endforeach  
          @endif

        </div>


        @for($i=0;$i<24;$i++)
        <div class="parent">
            <div class="div1 timeboxd "> 
              <span class="badge"> {{ $i}} </span>
            </div>
            
            @if(isset($data))
            @foreach($data as $key=>$value)

              @php 
                $time = Carbon\Carbon::parse($i.':00:00')->format('H:i:s');
                $time_array =  timeslot($value['trainer_id'],$date,$time);

                
                // echo(json_encode($time_array));
              @endphp

            <div data-trainer="{{$value['trainer_id']}}" data-time="{{$time}}" class="div{{ $key+2 }} boxd {{ $time_array == 'not_found' ?  '' : (isset($time_array->is_occupied) && $time_array->is_occupied == 1 ? 'red' : 'blue') }} "> 
                 {{-- <p style="color:white">{{ 'trainer_id:'.$value['trainer_id'] }}</p> --}}
                @if($time_array != 'not_found')
                 {{-- {{ array_key_exists_r($key,$time_array) }} --}}
                      {{ Carbon\Carbon::parse($time_array->time)->format('H:i'). " ~ ".Carbon\Carbon::parse($time_array->time)->addHour()->format('H:i') }}
                @endif

                   

             
            </div>


            @php 
              $k++;
            @endphp  
            @endforeach
            @endif

        </div>
        @endfor

        

     
  </div>
</div>