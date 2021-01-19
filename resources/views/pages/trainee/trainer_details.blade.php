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

                    <form action="{{route('traineeCalendar.view')}}" method="get" id="dateform">
                      {{ csrf_field() }}
                      <input type="hidden" name="trainer_id" value="{{ $trainerData->id }}">
                      <button type="submit" class="btn border-round btn-success" >トレーナーを選択 </button> 
                    <a class="btn border-round btn-warning" href="{{ route('traineeCalendar.view')}}">
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


</div>
</section>
@endsection