@extends('auth/master')
@section('title','trainer view')
@section('content')

    
       @include('pages.trainee.dashboard')

    <div class="row mb-5">
        <div class="offset-sm-2 col-sm-8">
     
        </div>   
    </div>
          <div class="row pb-5">
            <div class="col-sm middle">

                    <form action="{{route('traineeCalendar.view')}}" method="get" id="dateform">
                      {{ csrf_field() }}
                      <input type="hidden" name="trainer_id" value="{{ $trainerData->id }}">
                      <button type="submit" class="btn border-round" >トレーナーを選択 </button> 
                    <a class="btn border-round" href="{{ route('traineeCalendar.view')}}">
戻る </a>
                  </form>


            </div>
          </div>
        <div class="row pb-5">
        
            <div class="col-sm middle">
                <img class="img-fluid"  src="{{asset('asset/images/mini-banner-1.png')}}">
                <h4 class="mx-auto _introduction_">前書き</h4>
                <textarea name="intro" class="form-control" id="" rows="5">{{ $trainerData->intro}}</textarea>
            </div>

        </div>



@endsection