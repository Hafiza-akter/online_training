@extends('auth/master')
@section('title','trainer view')
@section('content')

      @include('pages.trainee.dashboard')

    <div class="row mb-5">
        <div class="offset-sm-2 col-sm-8">
        <div class="container h-100">
            <div class="justify-content-center h-100">
                <div class="searchbar">
                <input class="search_input" type="text" name="" placeholder="Search...">
                <a href="#" class="search_icon"><i class="fas fa-search"></i></a>
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
                        <img class="img-fluid"  src="{{asset('asset/images/mini-banner-1.png')}}">
                        <h2 class="text-center pt-3"> {{ $val->first_name}}</h2>
                    </div>
                    </a>
                @endforeach

        </div>
    @endif



@endsection