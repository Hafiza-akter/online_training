@extends('master')

@section('content')
<section class="banner_part">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-9">
                    <div class="text-left">
                        <div class="title_text">
                            <h1 class="m_title" style="font-size: 3.5em;color:white;" >メディカルジムオンライン </h1>
                            <br>
                            <h2 class="semi_title" style="font-size: 2em;color:white;font-weight: bold;"> ”自宅で”通うジムサービス </h2>
                            <h2 class="semi_title" style="font-size: 2em;color:white;font-weight: bold;"> １人じゃないから継続できる。</h2>
                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
    <section class="review_part white_bg ">
        <div class="container-fluid ">
            <div class="row justify-content-center mt-30">
                <div class="col-md-8 col-xl-8 mt-30 mb-30">
                        <h2 style="text-align:center;font-size:2em;color:black;" class="section_title">「メディカルジムオンライン」についてのお知らせ</h2>
                </div>
            </div>
            <div class="row justify-content-center ">
                <div class="col-md-8 col-xl-8">
                    <div class="">
                        <p style="font-size:1.3em;color:#c30f23;font-weight: bold;" class="p_semi_bold">
                            現在サービスは利用できませんが、サービス開始前のテストユーザーとトレーナーを募集中です。
                            時期によって無償対応や割引がございますが抽選によります。また、正式開始時にはメールでご連
                            絡致します。ご希望の方は下のボタンよりご登録ください。
                        </p>
                        <p style="text-align: center;margin-top: 60px;">
                            <a href="{{route('traineeSignup')}}" class="btn_new_2 btn_new_2_d " style="width: 40%;padding: 14px 54px 14px 54px;">
                                ユーザー登録はこちら
                            </a>
                        </p>
                        
                        <p style="text-align: center;margin-top: 32px;">
                            <a href="{{route('trainerSignup')}}" style=" color: #c31023;font-size: 20px;font-weight: bolder;border-bottom: 1px solid;">トレーナー登録はこちら</a> 
                        </p>
                    </div>

                </div>
            </div>
            
        </div>
    </section>

    <section class="review_part white_bg mt-60">
        <div class="left_half_top"></div>
        <div class="left_half_bottom"></div>
        <div class="right_triangle"></div>
        <div class="container-fluid">
            <div class="row justify-content-center mb-5 mt-3">
                <div class="col-md-8 col-xl-8 mt-3">
                    <h1 style="font-size:4em;color: #c30f23;font-weight: bold;text-align: center;" class="pb-4">
                    <span style="border-bottom: 4px solid #c30f23; ">01</span>
                </h1>
                <h2 style="text-align:center;font-size:2em;color:black;" class="section_title">今までの「悩み」を徹底解消。</h2>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-9 offset-lg-3">
                    <div class="extends_member_text">

                        <p style="color: #056fb8;font-size:1.7em;" class="p_2_text">こんなお悩みありませんか？</p>
                        <ul style="font-size: 1.3em;color:#231916;" class="p_2_text">
                            <li class="mb-3">
                            <img src="{{ asset('asset_v2/img/toppage/icon_check.png')}}" height="25" style="margin-top: -3px">
                                 ダイエットをしたいけど何をしていいかわからない。
                             </li>

                            <li class="mb-3">
                                <img src="{{ asset('asset_v2/img/toppage/icon_check.png')}}" height="25" style="margin-top: -3px">
                             今までダイエットをしてきたけど、うまくいかなかった。</li>
                            <li class="mb-3">
                                <img src="{{ asset('asset_v2/img/toppage/icon_check.png')}}" height="25" style="margin-top: -3px">
                             ジムに行くのは感染リスクが心配。</li>
                            <li class="mb-3">
                                <img src="{{ asset('asset_v2/img/toppage/icon_check.png')}}" height="25" style="margin-top: -3px">
                             スポーツクラブでマスクをしながら運動するのがしんどい。 </li>
                            <li class="mb-3">
                                <img src="{{ asset('asset_v2/img/toppage/icon_check.png')}}" height="25" style="margin-top: -3px">
                             好きな時間にトレーニングがしたい。 </li>
                            <li class="mb-3">
                                <img src="{{ asset('asset_v2/img/toppage/icon_check.png')}}" height="25" style="margin-top: -3px">
                             健康診断の結果が気になった。</li>
                            <li class="mb-3">
                                <img src="{{ asset('asset_v2/img/toppage/icon_check.png')}}" height="25" style="margin-top: -3px">
                             自己流でトレーニングしてもうまくいかない。 </li>
                            <li class="mb-3">
                                <img src="{{ asset('asset_v2/img/toppage/icon_check.png')}}" height="25" style="margin-top: -3px">
                             誰にも知られずにトレーニングをしたい。 </li>
                            <li class="mb-3">
                                <img src="{{ asset('asset_v2/img/toppage/icon_check.png')}}" height="25" style="margin-top: -3px">
                             ダイエットをしてもリバウンドしてしまう。</li>
                            <li class="mb-3">
                                <img src="{{ asset('asset_v2/img/toppage/icon_check.png')}}" height="25" style="margin-top: -3px">
                             従来のパーソナルトレーニングは高くて手が出ない。</li>
                        </ul>
                     </div>
                </div>
            </div>
             
        </div>
    </section>

    <section class="review_part white_bg ">
      {{--   <div class="right_triangle_gray"></div>
        <div class="right_triangle_red"></div>
 --}}
        <div class="container-fluid">

            <div class="row justify-content-center mb-5 ">
                <div class="col-md-8 col-xl-8 mt-60">
                    <h1 style="font-size:4em;color: #c30f23;font-weight: bold;text-align: center;" class="pb-4 mt-60">
                    <span style="border-bottom: 4px solid #c30f23; ">02</span>
                </h1>
                <h2 style="text-align:center;font-size:2em;color:black;" class="section_title">「悩み」を解消する４つの特徴</h2>
                </div>
            </div>

            <div class="row justify-content-center mb-5 ">
                <div class="col-md-8 col-xl-8  row justify-content-center  mt-60">
                    <img src="{{ asset('asset_v2/img/toppage/skew_1.png')}}" height="330">
                </div>
            </div>

             <div class="row justify-content-center mb-5 ">
                <div class="col-md-4 col-xl-4 mt-60">
                    <h1 style="font-size:4em;color: #000;font-weight: bold;" class="">
                     <span>Point 1</span>
                    </h1>

                    <ul style="font-size: 1.8em;color:#231916;font-weight: 100;border-bottom:3px solid #080403;margin-bottom: 20px;">
                        <li class="mb-3">
                            <img src="{{ asset('asset_v2/img/toppage/home_ok.png')}}" class="img-fluid" >
                            <h2 class="point_1 point_1_heading_1" >自宅で安心して</h2>
                            <h2 class="point_1 point_1_heading_2">トレーニング</h2>
                        </li>
                    </ul>
                     <p class="p_text">
                        自宅でのトレーニングであれば、他の人の目を気にする必要も、マスクをする必要もありません。感染リスクの少ない自宅で、安心してトレーニングをしませんか？
                    </p>
                </div>
                <div class="col-md-1 col-xl-1 ">
                </div>
                <div class="col-md-4 col-xl-4 mt-60">
                    <h1 style="font-size:4em;color: #000;font-weight: bold;" class="">
                     <span>Point 2</span>
                    </h1>

                    <ul style="font-size: 1.8em;color:#231916;font-weight: 100;border-bottom:3px solid #080403;margin-bottom: 20px;">
                        <li class="mb-3">
                            <img src="{{ asset('asset_v2/img/toppage/dumble.png')}}" class="img-fluid" >
                            <h2 class="point_1 point_2_heading_1" >自宅に居ながら</h2>
                            <h2 class="point_1 point_2_heading_2">ジムレベルの</h2>
                            <h2 class="point_1 point_2_heading_3">トレーニング</h2>
                        </li>
                    </ul>
                     <p class="p_text">
                            可変式ダンベルを使ったフリーウエイトトレーニングとプロのトレーナーのサポートで、自宅でもジムレベルの質のトレーニングができます。
                    </p>
                </div>                
            </div>


             <div class="row justify-content-center mb-5 ">
                <div class="col-md-8 col-xl-8  row justify-content-center  mt-60">
                    <img src="{{ asset('asset_v2/img/toppage/skew_2.png')}}" height="330">
                </div>
            </div>
            <div class="row justify-content-center mb-5 ">

                <div class="col-md-4 col-xl-4 mt-60">
                    <h1 style="font-size:4em;color: #000;font-weight: bold;" class="">
                     <span>Point 3</span>
                    </h1>

                    <ul style="font-size: 1.8em;color:#231916;font-weight: 100;border-bottom:3px solid #080403;margin-bottom: 20px;">
                        <li class="mb-3">
                            <img src="{{ asset('asset_v2/img/toppage/graph_2.png')}}" class="img-fluid" >
                            <h2 class="point_1 point_1_heading_1" >ダイエットの</h2>
                            <h2 class="point_1 point_1_heading_2">成果を予測！</h2>
                        </li>
                    </ul>
                     <p class="p_text">
                        これから行うトレーニングの頻度によって、減少していく体重の推移をコンピュータが計算。自分の将来の姿をイメージしながらトレーニングをすることで、高いモチベーションを維持できます。                    </p>
                </div>

                <div class="col-md-1 col-xl-1 ">
                </div>
                <div class="col-md-4 col-xl-4 mt-60">
                    <h1 style="font-size:4em;color: #000;font-weight: bold;" class="">
                     <span>Point 4</span>
                    </h1>

                    <ul style="font-size: 1.8em;color:#231916;font-weight: 100;border-bottom:3px solid #080403;margin-bottom: 20px;">
                        <li class="mb-3">
                            <img src="{{ asset('asset_v2/img/toppage/piggy_2.png')}}" class="img-fluid" >
                            <h2 class="point_1 point_2_heading_4" >追加料金なし！</h2>
                            
                        </li>
                    </ul>
                     <p class="p_text">
                        必要なのは道具(可変式ダンベル・ベンチ)とセッションフィーのみ。入会金やその他費用はいただきません。                    
                    </p>
                </div> 
            </div>

        </div>
    </section>



    <section class="review_part white_bg ">
         <div class="left_half_top_gray"></div>
        <div class="left_half_bottom_gray"></div>
        <div class="right_triangle_3_red"></div>
        <div class="container-fluid">
            <div class="row justify-content-center mb-5">
                <div class="col-md-8 col-xl-8 mt-3">
                    <h1 style="font-size:4em;color: #c30f23;font-weight: bold;text-align: center;" class="pb-4">
                    <span style="border-bottom: 4px solid #c30f23; ">03</span>
                </h1>
                <h2 style="text-align:center;font-size:2em;color:black;" class="section_title">今までの「悩み」を徹底解消。</h2>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-9 offset-lg-3">
                    <div class="extends_member_text">

                        <p style="color: #c30f23;font-size:1.7em;" class="p_2_text">すべてのコースに含まれるサービス</p>
                        <ul style="font-size: 1.3em;color:#231916;" class="p_2_text">
                            <li class="mb-3">
                                 <i class="fal fa-square"></i> カウンセリング
                             </li>

                            <li class="mb-3">
                                 <i class="fal fa-square"></i> メニュー作成
                             </li>
                              <li class="mb-3">
                                 <i class="fal fa-square"></i> セッション
                             </li>

                              <li class="mb-3">
                                 <i class="fal fa-square"></i> 体重推移の記録
                             </li>
                             <li class="mb-3">
                                 <i class="fal fa-square"></i> 入会金・初期費用：0円
                             </li>
                              <li class="mb-3">
                                 <i class="fal fa-square"></i> 週1回コース：24000円/月
                             </li>
                              <li class="mb-3">
                                 <i class="fal fa-square"></i> 週2回コース：48000円/月
                             </li>
                               <li class="mb-3">
                                 <i class="fal fa-square"></i> 週3回コース：72000円/月
                             </li>
                             
                        </ul>
                     </div>
                </div>
            </div>
             
        </div>
        <br></br>
    </section>


<section class="calculate_part section_padding">
    <div class="container-fluid">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8 col-xl-8 ">

            <br><br>
            <h1 class="h1_click pb-4" >

                <span style="">登録はこちら</span>
            </h1>
            <p class=" p_bold" style="color:#fff">※現在サービスは利用できませんが、サービス開始前のテストユーザーとトレーナーを募集中です。</p>
            
            <br><br>
             <p style="text-align: center;margin-top: 60px;">
                <a href="{{route('trainerSignup')}}" class="btn_new_3 btn_new_3_d " style="width: 40%;padding: 14px 54px 14px 54px;">
                    トレーナー登録はこちら
                </a>
            </p>

            <p style="text-align: center;margin-top: 60px;">
                <a href="{{route('traineeSignup')}}" class="btn_new_3 btn_new_3_d " style="width: 40%;padding: 14px 54px 14px 54px;">
                    ユーザー登録はこちら
                </a>
            </p>

            </div>

        </div>
    </div>
</section>

    

    

    <section class="section_padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    
                     <div class="section_tittle">
                                    <h2 style="font-size:2em;color:#c30f23;" class="section_title">お問い合わせ</h2>
                                    <h1 class="h1_click pb-4" style="color: #c30f23;font-weight: bold;"  >CONTACT</h1>
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
                        <div class="mt-10 mb-30">
                            <label>お名前</label>
                        <input style="border:1px solid #efefef;background:#efefef" type="text" name="name" required="" class="single-input">
                        </div>
                        <div class="mt-10 mb-30">
                            <label>メールアドレス</label>
                        <input style="border:1px solid #efefef;background:#efefef" type="email" name="email" required="" class="single-input">
                        </div>
                        <div class="mt-10 mb-30">
                            <label>電話番号</label>
                        <input style="border:1px solid #efefef;background:#efefef" type="text" name="title"  required="" class="single-input" >
                        </div>


                        <div class="mt-10 mb-30">
                            <label>お問い合わせ内容</label>
                        <textarea style="border:1px solid #efefef;background:#efefef" class="single-textarea" required="" name="message"></textarea>
                        </div>

                        <button type="submit" class="btn_2 sibscribe-btm mt-10 btn-block" style="border:none !important;background:#383735;border-radius:0px;">送信する</button>
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
            title: 'メッセージありがとうございます。担当者よりご連絡いたします',
            showConfirmButton:false
          })
    </script>
    @endif
    @endsection
