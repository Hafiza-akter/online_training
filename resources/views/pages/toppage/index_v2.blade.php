@extends('master')

@section('content')
<section class="banner_part">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-9">
                    <div class="banner_text text-center">
                        <div class="banner_text_iner">
                            <!-- <h2>Join <span>now</span> </h2> -->
                            {{-- <p>get in shape today</p> --}}
                        <h2>
                            <span></span>
                            <span>
                             メディカルジムオンライン
                         </span>
                         </h2>
                        @if(Session::get('user_type') === 'trainer' || Session::get('user_type') === 'trainee')

                        @else
                        <p class="pb-3">
                            <a href="{{route('trainerSignup')}}" class="btn_2" style="border-radius: 1px !important;border: 2px solid #c604c6;font-size: 18px;">トレーナー  登録</a> <!-- Trainer registraion-->
                            <a href="{{route('traineeSignup')}}" class="btn_2" style="border-radius: 1px !important;background: none;border:2px solid #c604c6;font-size: 18px;">ユーザー 登録</a> <!-- Trainee registraion-->
                        </p>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
    <section class="review_part gray_bg section_padding">
        <div class="container-fluid">
               <div class="row justify-content-center">
                <div class="col-md-12 col-xl-12">
                    <div class="section_tittle">
                        <h2>こんなことでお悩みではないでしょうか？</h2>
                    </div>
                </div>
            </div>
            <div class="row ">
                
                <div class="col-lg-10 offset-lg-2">
                    <div class="extends_member_text">


              
                        <ul>
                           
                            <li><span class="btn-secondary ti-check success p-1"></span> ダイエットをしたいけど何をしていいかわからない </li> <br>
                            <li><span class="btn-secondary ti-check success p-1"></span> 今までダイエットをしてきたけど、うまくいかなかった </li><br>
                            <li><span class="btn-secondary ti-check success p-1"></span> ジムに行くのは感染リスクが心配 </li><br>
                            <li><span class="btn-secondary ti-check success p-1"></span> スポーツクラブでマスクをしながら運動するのがしんどい </li><br>
                            <li><span class="btn-secondary ti-check success p-1"></span> 好きな時間にトレーニングがしたい </li><br>
                            <li><span class="btn-secondary ti-check success p-1"></span> 健康診断の結果が気になった </li><br>
                            <li><span class="btn-secondary ti-check success p-1"></span> 自己流でトレーニングしてもうまくいかない </li><br>
                            <li><span class="btn-secondary ti-check success p-1"></span> 誰にも知られずにトレーニングをしたい </li><br>
                            <li><span class="btn-secondary ti-check success p-1"></span> ダイエットをしてもリバウンドしてしまう </li><br>
                            <li><span class="btn-secondary ti-check success p-1"></span> 従来のパーソナルトレーニングは高くて手が出ない </li><br>
                        </ul>
                        {{-- <a href="#" class="btn_2">続きを読む</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about_us section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-xl-6">
                    <div class="section_tittle">
                        <h2>サービスの特徴</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="col-lg-4">
                    <div class="our_feature">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="single_feature_item">
                                    <div class="feature_item_icon">
                                        <span class="flaticon-footwear"></span>
                                    </div>
                                    <h3><a href="#">自宅で安心してトレーニング </a></h3>
                                    <p> 
                                        自宅でのトレーニングであれば、他の人の目を気にする必要も、マスクをする必要もありません。感染リスクの少ない自宅で、安心してトレーニングをしませんか？
                                    </p>
                                </div>
                                <div class="single_feature_item">
                                    <div class="feature_item_icon">
                                        <span> <img src="{{asset('asset_v2/img/icon/icon.svg')}}" alt="icon"> </span>
                                    </div>
                                    <h3><a href="#">ダイエットの成果を予測</a></h3>
                                    <p>
                                        これから行うトレーニングの頻度によって、減少していく体重の推移をコンピュータが計算。自分の将来の姿をイメージしながらトレーニングをすることで、高いモチベーションを維持できます。
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="about_img">
                        <img src="{{asset('asset_v2/img/about_bg.png')}}" alt="#">
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="our_feature">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="single_feature_item">
                                    <div class="feature_item_icon">
                                        <span class="flaticon-gym-1"></span>
                                    </div>
                                    <h3> <a href="#">自宅にいながらジムレベルのトレーニング！</a></h3>
                                    <p>
                                        可変式ダンベルを使ったフリーウエイトトレーニングとプロのトレーナーのサポートで、自宅でもジムレベルの質のトレーニングができます。
                                    </p>
                                </div>
                                <div class="single_feature_item">
                                    <div class="feature_item_icon">
                                        <span class="flaticon-strong"></span>
                                    </div>
                                    <h3><a href="#">追加料金なし！</a></h3>
                                    <p>
                                        必要なのは道具(可変式ダンベル・ベンチ)とセッションフィーのみ。入会金やその他費用はいただきません。
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="overlay_icon">
            <img src="{{asset('asset_v2/img/animate_icon/icon_1.png')}}" class="amitated_icon_1" alt="animate_icon">
            <img src="{{asset('asset_v2/img/animate_icon/icon_2.png')}}" class="amitated_icon_2" alt="animate_icon">
            <img src="{{asset('asset_v2/img/animate_icon/icon_3.png')}}" class="amitated_icon_3" alt="animate_icon">
            <img src="{{asset('asset_v2/img/animate_icon/icon_4.png')}}" class="amitated_icon_4" alt="animate_icon">
            <img src="{{asset('asset_v2/img/animate_icon/icon_5.png')}}" class="amitated_icon_5" alt="animate_icon">
        </div>
    </section>


    <section class="extends_part section_padding" id="service">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-lg-5">
                    <div class="extends_img">
                        <img src="{{asset('asset_v2/img/excuses_video_bg.png')}}" alt="">
                        <div class="extends_video">
                            <div class="intro_video_iner text-center d-flex align-items-center">
                                <div class="intro_video_icon">
                                    <a id="play-video_1" class="video-play-button popup-youtube" href="https://www.youtube.com/watch?v=pBFQdxA-apI">
                                        <span class="ti-control-play"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-2">
                    <div class="extends_member_text">
                        <h2>サービスについて  <br>
                            </h2>

              
                        <ul>
                            <li>
                                <span class="ti-pencil-alt"></span>
                                全てのコースに含まれるサービス
                                <br><br>
                                 <span class="fas fa-square p-1"></span> カウンセリング <br>
                                 <span class="fas fa-square p-1"></span> メニュー作成 <br>
                                 <span class="fas fa-square p-1"></span>  セッション <br>
                                 <span class="fas fa-square p-1"></span> 体重推移の記録 <br>
                                <span class="fas fa-square p-1"></span>入会金・初期費用：0円<br>
                                <span class="fas fa-square p-1"></span>週1回コース：24000円/月<br>
                                <span class="fas fa-square p-1"></span>週2回コース：48000円/月<br>
                                <span class="fas fa-square p-1"></span>週3回コース：72000円/月
                            </li>
                            
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


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
     <section class="team_member_section section_padding" style="padding: 260px 0 130px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-xl-12">
                    <div class="section_tittle">
                        <h2>トレーナーがそろってきたら追加？</h2>
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
                            <h3><a href="#">田中直樹</a></h3>
                            <p>パーソナルトレーナー</p>
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
                            <h3><a href="#">丸山健二</a></h3>
                            <p>パーソナルトレーナー</p>
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
                            <h3><a href="#">林隆二</a></h3>
                            <p>パーソナルトレーナー</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="review_part gray_bg section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-xl-12">
                    <div class="section_tittle">
                        <h2>β版でコメント集めてみてから追加？</h2>
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
                                        <h4>東京都在住 A.Yさん <span>20代　女性</span></h4>
                                        <div class="star_icon">
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_2.svg')}}" alt=""> </a>
                                        </div>
                                        <p>(ここにお客様の声が入ります)テストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテスト
                                        テストテストテストテストテストテストテストテストテストテストテストテスト</p>
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
                                        <h4>鳥取県在住 T.Nさん <span>30代　女性</span></h4>
                                        <div class="star_icon">
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_2.svg')}}" alt=""> </a>
                                        </div>
                                        <p>(ここにお客様の声が入ります)テストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテスト
                                        テストテストテストテストテストテストテストテストテストテストテストテスト</p>
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
                                        <h4>北海道在住 M.Kさん <span>20代　男性</span></h4>
                                        <div class="star_icon">
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_1.svg')}}" alt=""> </a>
                                            <a href="#"> <img src="{{asset('asset_v2/img/icon/star_2.svg')}}" alt=""> </a>
                                        </div>
                                        <p>(ここにお客様の声が入ります)テストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテストテスト
                                        テストテストテストテストテストテストテストテストテストテストテストテスト</p>
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
    
   


    <section class="sibscribe-area section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    
                     <div class="section_tittle">
                        <h2>お問い合わせ</h2>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-7">
                    {{-- <form class="sibscribe-form">
                        <input type="email" class="form-control" id="exampleInputEmail11" placeholder='Enter Email Address' onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Email Address'">
                        <a class="btn_2 sibscribe-btm">Subscribe</a>
                    </form> --}}

                    <form action="{{route('inquery.submit')}}" method="post">
                            {{ csrf_field() }}
                        <div class="mt-10">
                        <input style="border:1px solid #a509a436;" type="text" name="name" placeholder="お名前" onfocus="this.placeholder = ''" onblur="this.placeholder = 'お名前'" required="" class="single-input">
                        </div>
                        <div class="mt-10">
                        <input style="border:1px solid #a509a436;" type="email" name="email" placeholder="メールアドレス" onfocus="this.placeholder = ''" onblur="this.placeholder = 'メールアドレス'" required="" class="single-input">
                        </div>
                        <div class="mt-10">
                        <input style="border:1px solid #a509a436;" type="text" name="title" placeholder="お問い合わせタイトル" onfocus="this.placeholder = ''" onblur="this.placeholder = 'お問い合わせタイトル'" required="" class="single-input" >
                        </div>


                        <div class="mt-10">
                        <textarea style="border:1px solid #a509a436;" class="single-textarea" placeholder="こちらにお問い合わせ内容を記載ください。" onfocus="this.placeholder = ''" onblur="this.placeholder = 'こちらにお問い合わせ内容を記載ください。'" required="" name="message"></textarea>
                        </div>

                        <button type="submit" class="btn_2 sibscribe-btm mt-10" style="color:white;">送信</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @endsection
    @section('footer_css_js')
    <script src='{{ asset('asset_v2/js/sweetalert2@10.js')}}'></script>
     @if(Session::has('swal'))
    <script type="text/javascript">
          Swal.fire({
            icon: 'success',
            title: 'メッセージありがとうございます。すぐにご連絡いたします',
            showConfirmButton:false
          })
    </script>
    @endif
    @endsection
