@extends('auth/master')
@section('title','trainer view')
@section('content')
    <div class="row pb-5">
      <h2 class="mx-auto">オンライントレーニング</h2>
    </div>
    <div class="row pb-3">
      <div class="col-sm border-round">
        <a class="btn">ログイン </a>       
      </div>
      <div class="col-sm border-round">
        <a class="btn">ログイン </a>       
      </div>
      <div class="col-sm border-round">
        <a class="btn">ログイン </a>       
      </div>
      <div class="col-sm border-round">
        <a class="btn">ログイン </a>       
      </div>
    </div>
    <div class="row mb-5">
      <div class="offset-sm-4 col-sm-4 border-round">
        <a class="btn">ログイン </a> 
     </div>
    </div>
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

    <div class="row pb-5">
        <div class="col-sm middle">
            <img class="img-fluid"  src="{{asset('asset/images/mini-banner-1.png')}}">
            <h2 class="text-center pt-3">インする</h2>
        </div>
        <div class="col-sm middle">
            <img class="img-fluid" src="{{asset('asset/images/mini-banner-2.png')}}">
            <h2 class="text-center pt-3">インする</h2>
        </div>
    </div>
    <div class="row pb-5">
        <div class="col-sm" >
            <div class="col-sm-8 offset-sm-2 light-ash trainer_details"></div>
            <h2 class="text-center pt-3">インする</h2>

        </div>            
        <div class="col-sm"> 
            <div class="col-sm-8 offset-sm-2 light-ash trainer_details"></div>
            <h2 class="text-center pt-3">インする</h2>
        </div>
    </div>
    <div class="row pb-3">
        <div class="col-sm" >
            <div class="col-sm-8 offset-sm-2 light-ash trainer_details"></div>
            <h2 class="text-center pt-3">インする</h2>
        </div>
        <div class="col-sm"> 
            <div class="col-sm-8 offset-sm-2 light-ash trainer_details"></div>
            <h2 class="text-center pt-3">インする</h2>
        </div>
    </div>

@endsection