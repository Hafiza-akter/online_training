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

               
                    <a class="btn border-round btn-warning" href="{{ url()->previous()}}">戻る </a>


            </div>
          </div>
        <div class="row pb-5">
        
            <div class="col-sm middle">
                @if($user->photo_path != NULL)
                    <img class="img-fluid"  src="{{asset('images').'/'.$user->photo_path}}" width="200">
                @else 
                  <img src="{{asset('images/user-thumb.jpg')}}"  width="200" width="200">

                @endif       
                <h4 class="mx-auto _introduction_">トレーナー紹介</h4>
                <p  id="" >{{ $user->intro}}</p>
            </div>

        </div>


</div>
</section>
@endsection