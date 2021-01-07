@extends('master_page')

@section('content')
<div class="row black-background">

    <div class="row">
        <div class="col-sm-12 pt-2 pb-3">
            <h1 class="mx-auto text-white btn-one mt-1 pt-1 pb-1 heading-btn">オンライントレーニングマッチング</h1>
        </div>
        <div class="col-sm-12 middle">
            <img class="img-fluid mx-auto" src="{{asset('asset/images/banner-1.png')}}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 pt-2 pb-3">
        <h1 class="mx-auto btn-one mt-1 pt-1 pb-1">トレーナー紹介</h1>
    </div>
</div>

<div class="row">
    <div class="col-sm middle">
        <img class="img-fluid"  src="{{asset('asset/images/mini-banner-1.png')}}">
    </div>
    <div class="col-sm middle">
        <img class="img-fluid" src="{{asset('asset/images/mini-banner-2.png')}}">
    </div>
</div>

<div class="row">
    <div class="col-sm-12 pt-4 pb-3">
        <h1 class="mx-auto btn-one mt-1 pt-1 pb-1">顧客の反応 </h1>
    </div>
</div>

<div class="row">
    <div class="col-sm-8 sm-auto light-ash pt-2 pb-3 mb-5 review-box" ></div>
</div>

<div class="row">
    <div class="offset-sm-4 col-sm-8 light-ash pt-2 pb-3 review-box"></div>
</div>

<div class="row">
    <div class="col-sm-12 pt-4 pb-3">
        <h1 class="mx-auto btn-one mt-1 pt-1 pb-1">料金プラン</h1>
    </div>
</div>

<div class="row">
    <div class="col-sm" >
            <div class="col-sm-8 offset-sm-2 light-ash rate-plan" ></div>
    </div>
    <div class="col-sm" >
        <div class="col-sm-8 offset-sm-2 light-ash rate-plan"></div>
    </div>
    <div class="col-sm"> 
        <div class="col-sm-8 offset-sm-2 light-ash rate-plan"></div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 pt-4 pb-3">
        <h1 class="mx-auto btn-one mt-1 pt-1 pb-1">サービス機能</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm p-5 m-4" >
        <div class="col-sm-12 light-ash service-feature" ></div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 pt-4 pb-3 middle black-background">
        <ul class="list-group pt-5 pb-2">
            <li class="list-group-item no-border text-white black-background">私たちに関しては </li>
            <li class="list-group-item no-border text-white black-background">個人情報保護方針</li>
            <li class="list-group-item no-border text-white black-background">利用規約</li>
          </ul>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 pt-4 pb-3 rside black-background">
         <button type="button" class="btn btn-light">ログインする </br> (マネージャー)</button>
    </div>
</div>
@endsection