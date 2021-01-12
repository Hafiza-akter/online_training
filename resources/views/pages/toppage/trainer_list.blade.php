@extends('master')

@section('content')
    {{-- <section class="our_offer">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8 col-xl-5">
                    <div class="section_tittle">
                        <p>best Courses</p>
                        <h2>Why you Join with us</h2>
                        <span>Stars fowl deep she greater bearing to seed dont is let you're appear first thing saying
                            it years abundantly fowl tree you shall also</span>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-lg-12">
                    <div class="single_offer_part">
                        <div class="single_offer">
                            <img src="{{asset('asset_v2/img/offer_img_1.png')}}" alt="offer_img_1">
                            <div class="hover_text">
                                <h2>Fitness Training</h2>
                                <p>Fly replenish dominion evening make veriety of </p>
                                <a href="#" class="offer_btn"><span class="flaticon-slim-right"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="single_offer_part">
                        <div class="single_offer">
                            <img src="{{asset('asset_v2/img/offer_img_2.png')}}" alt="offer_img_1">
                            <div class="hover_text">
                                <h2>Fitness Training</h2>
                                <p>Fly replenish dominion evening make veriety of </p>
                                <a href="#" class="offer_btn"><span class="flaticon-slim-right"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="single_offer_part">
                        <div class="single_offer">
                            <img src="{{asset('asset_v2/img/offer_img_3.png')}}" alt="offer_img_1">
                            <div class="hover_text">
                                <h2>Fitness Training</h2>
                                <p>Fly replenish dominion evening make veriety of </p>
                                <a href="#" class="offer_btn"><span class="flaticon-slim-right"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="single_offer_part">
                        <div class="single_offer">
                            <img src="{{asset('asset_v2/img/offer_img_4.png')}}" alt="offer_img_1">
                            <div class="hover_text">
                                <h2>Fitness Training</h2>
                                <p>Fly replenish dominion evening make veriety of </p>
                                <a href="#" class="offer_btn"><span class="flaticon-slim-right"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
     <section class="review_part gray_bg team_member_section section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-xl-6">
                    <div class="section_tittle">
                        <h2>Meet with trainers</h2>
                    </div>
                </div>
            </div>
            <div class="row d-flex align-items-center">
                <div class="col-sm-6 col-lg-4">
                    <div class="single_blog_item">
                        <div class="single_blog_img">
                            <img src="{{asset('asset_v2/img/team/team_1.png')}}" alt="">
                            <div class="social_icon">
                                <ul>
                                    <li><a href="#"><i class="ti-facebook"></i></a></li>
                                    <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
                                    <li><a href="#"><i class="ti-instagram"></i></a></li>
                                    <li><a href="#"><i class="ti-skype"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="single_blog_text">
                            <h3><a href="{{ route('trainerdetails')  }}">Anderew Eletch</a></h3>
                            <p>Personal trainer</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="single_blog_item">
                        <div class="single_blog_img">
                            <img src="{{asset('asset_v2/img/team/team_2.png')}}" alt="">
                            <div class="social_icon">
                                <ul>
                                    <li><a href="#"><i class="ti-facebook"></i></a></li>
                                    <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
                                    <li><a href="#"><i class="ti-instagram"></i></a></li>
                                    <li><a href="#"><i class="ti-skype"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="single_blog_text">
                            <h3><a href="{{ route('trainerdetails')  }}">Mathew Edene</a></h3>
                            <p>Personal trainer</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="single_blog_item">
                        <div class="single_blog_img">
                                <img src="{{asset('asset_v2/img/team/team_3.png')}}" alt="">
                            <div class="social_icon">
                                <ul>
                                    <li><a href="#"><i class="ti-facebook"></i></a></li>
                                    <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
                                    <li><a href="#"><i class="ti-instagram"></i></a></li>
                                    <li><a href="#"><i class="ti-skype"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="single_blog_text">
                            <h3><a href="{{ route('trainerdetails')  }}">Anderew Eletch</a></h3>
                            <p>Personal trainer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    {{-- <section class="calculate_part section_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-xl-5">
                    <div class="section_tittle">
                        <h2>Calculate your bmi</h2>
                        <p>Firmament their creepeth bearing every have bearing without fly tree one Deep is
                            void days bearing in night after own of</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <div class="regervation_part_iner">
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input type="email" class="form-control" id="inputEmail4" placeholder='Height/cm' onfocus="this.placeholder = ''" onblur="this.placeholder = 'Height/cm'">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="email" class="form-control" id="emailtype" placeholder='Weight/cm' onfocus="this.placeholder = ''" onblur="this.placeholder = 'Weight/cm'">
                                </div>
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" id="pnone" placeholder='Age' onfocus="this.placeholder = ''" onblur="this.placeholder = 'Age'">
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="single_check_box">
                                        <div class="input-group-prepend">
                                            <p>
                                                <input type="radio" id="test1" name="radio-group" checked>
                                                <label for="test1">Male</label>
                                            </p>
                                            <p>
                                                <input type="radio" id="test2" name="radio-group">
                                                <label for="test2">Female</label>
                                            </p>
                                            <p>
                                                <input type="radio" id="test3" name="radio-group">
                                                <label for="test3">Other</label>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="regerv_btn">
                                <a href="#" class="btn_2">Book A Table</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    @endsection