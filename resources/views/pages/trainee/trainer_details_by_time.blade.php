@extends('master_dashboard')
@section('title','trainee trainerlist')
@section('header_css_js')

    
       {{-- @include('pages.trainee.dashboard') --}}
<section class="review_part gray_bg section_padding">

  <div class="offset-md-2 col-md-10">
    <div class="row mb-5">
        <div class="offset-sm-2 col-sm-8">
     
        </div>   
    </div>
          <div class="row pb-5">
            <div class="col-sm middle">

                    <form action="{{route('trainerSubmitBytime')}}" method="post" id="dateform" style="display: inline-block;">
                      {{ csrf_field() }}

                      <input type="hidden" name="trainer_id" value="{{ $trainerData->id }}">
                      <input type="hidden" name="date" value="{{ $date }}">
                      <input type="hidden" name="time" value="{{ $time }}">

                      <button type="submit" class="btn border-round btn-success" >トレーナーを選択 </button> 
                
                  </form>
                   <form action="{{route('trainerlistviatime')}}" method="post" id="dateform" style="display: inline-block;">
                      {{ csrf_field() }}

                      <input type="hidden" name="trainer_id" value="{{ $trainerData->id }}">
                      <input type="hidden" name="selected_date" value="{{ $date }}">
                      <input type="hidden" name="start_time" value="{{ $time }}">

                      <button type="submit" class="btn border-round btn-warning" >戻る</button> 
                    
                  </form>


            </div>
          </div>
        <div class="row pb-5">
        
            <div class="col-sm middle">
                @if($trainerData->photo_path != NULL)
                    <img class="img-fluid"  src="{{asset('images').'/'.$trainerData->photo_path}}" width="300">
                @else 
                  <img src="{{asset('images/user-thumb.jpg')}}"  width="200" width="200">

                @endif       
                <h4 class="mx-auto _introduction_">トレーナー紹介</h4>
                <p >{{ $trainerData->intro}}</p>

            </div>

        </div>


</div>
</section>
@endsection