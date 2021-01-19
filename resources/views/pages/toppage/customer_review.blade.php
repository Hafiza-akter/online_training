@extends('master')

@section('content')


    <section class="review_part gray_bg section_padding">
        <div class="container">
            <div class="row justify-content-center">

                

                <div class="col-md-8 col-xl-6">
                    <div class="section_tittle">
                        {{-- <h2>顧客の反応</h2> --}}

                        <div class="section_tittle">
                    <h2>お客様の声</h2>
                    <span>当サービスをご利用いただいたお客様の声をご紹介します。</span>
                </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="client_review_part owl-carousel">
                        <div class="client_review_single media">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <div class="client_img align-self-center">
                                        <img src="{{asset('asset_v2/img/client/client_1.png')}}" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="client_review_text media-body">
                                        <h4>Mosan Cameron <span>Executive of fedex</span></h4>
                                        <div class="star_icon">
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_2.svg')}}" alt=""> </a>
                                        </div>
                                        <p>Bring and. She'd upon evening good land under subdue sixth subdue god
                                            over spirit fishe the live on above may fish divided itself living
                                            very lesser herb his can't shall his fowl bring. And She'd upon evening
                                            good land under subdue sixth very</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="client_review_single media">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <div class="client_img align-self-center">
                                        <img src="{{asset('asset_v2/img/client/client_1.png')}}" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="client_review_text media-body">
                                        <h4>Mosan Cameron <span>Executive of fedex</span></h4>
                                        <div class="star_icon">
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_2.svg')}}" alt=""> </a>
                                        </div>
                                        <p>Bring and. She'd upon evening good land under subdue sixth subdue god over
                                            spirit
                                            fishe the live on above may fish divided itself living very lesser herb his
                                            can't
                                            shall his fowl bring. And She'd upon evening good land under subdue sixth
                                            very</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="client_review_single media">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <div class="client_img">
                                        <img src="{{asset('asset_v2/img/client/client_1.png')}}" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="client_review_text media-body">
                                        <h4>Mosan Cameron <span>Executive of fedex</span></h4>
                                        <div class="star_icon">
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_2.svg')}}" alt=""> </a>
                                        </div>
                                        <p>Bring and. She'd upon evening good land under subdue sixth subdue god over
                                            spirit fishe
                                            the live on above may fish divided itself living very lesser herb his can't
                                            shall his
                                            fowl bring. And She'd upon evening good land under subdue sixth very</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="overlay_icon">
            <img src="{{asset('asset_v2/img/animate_icon/icon_6.png')}}" class="amitated_icon_6" alt="animate_icon">
        </div>
    </section>


    @endsection