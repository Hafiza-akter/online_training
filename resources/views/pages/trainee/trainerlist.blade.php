@extends('master_dashboard')
@section('title','trainee trainerlist')
@section('header_css_js')

      {{-- @include('pages.trainee.dashboard') --}}

<section class="review_part gray_bg section_padding">
    <div class="container my-4">

     <div class="row justify-content-center">
        <div class="col-md-8 col-xl-6">
            <div class="section_tittle">
                <h3>トレーナーリスト</h3>
            </div>
        </div>
    </div>
  <div class="offset-md-2 col-md-10">
    <div class="row mb-5">
        <div class="offset-sm-3 col-sm-10">
        <div class="container h-100">
            <div class="justify-content-center h-100">
                <div class="searchbar">
                {{-- <input class="search_input" type="text" name="" placeholder="Search..."> --}}
                {{-- <a href="#" class="search_icon"><i class="fas fa-search"></i></a> --}}
                </div>
            </div>
            </div>
        </div>   
    </div>

        @if(!empty($trainerList))
            <div class="row pb-5">
                    @foreach($trainerList as $val)
                        <a href="{{ route('trainerDetails',$val->id)}}">
                        <div class="col-sm middle">
                            @if($val->photo_path != NULL)
                                <img class="img-fluid"  src="{{asset('images').'/'.$val->photo_path}}" width="300">
                            @else 
                                 <img src="{{asset('images/user-thumb.jpg')}}"  width="200" width="200">

                            @endif 
                            <h2 class="text-center pt-3"> {{ $val->first_name}}</h2>
                        </div>
                        </a>
                    @endforeach

            </div>
        @else 
                    <h2> No data found</h2>

        @endif

    </div>

</div>
</section>
@endsection