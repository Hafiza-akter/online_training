<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('asset/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('asset/css/custom.css')}}">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />


    <title>index</title>
</head>

<body>
    <div class="container">

        <div class="row pt-3 h-menu">
            <div class="col-sm">
                <a href="{{route('traineeSignup')}}"><button type="button" class="btn btn-outline-secondary btn-lg btn-block">サインアップ </br> (研修生) </button></a>
            </div>
            <div class="col-sm">
                <a href="{{route('traineeLogin')}}"><button type="button" class="btn btn-outline-secondary btn-lg btn-block"> ログインする </br> (研修生) </button></a>
            </div>
            <div class="col-sm">
                <a href="{{route('trainerSignup')}}"><button type="button" class="btn btn-outline-secondary btn-lg btn-block">サインアップ </br> (トレーナー) </button></a>
            </div>
            <div class="col-sm">
                <a href="{{route('trainerLogin')}}"> <button type="button" class="btn btn-outline-secondary btn-lg btn-block">ログインする </br> (トレーナー) </button></a>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-sm">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="#">Online-Training</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">顧客の<span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">顧客の</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">顧客の</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">顧客の</a>
                            </li>
                            <!-- <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    More
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">顧客の反応</a>
                                    <a class="dropdown-item" href="#">顧客の反応</a>
                                    <a class="dropdown-item" href="#">顧客の反応</a>
                                </div>
                            </li> -->
                           
                        </ul>
                        <div class="my-2 my-lg-0">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    More
                                </a>
                                <div class="dropdown-menu more-btn" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#">顧客の反応</a>
                                    <a class="dropdown-item" href="#">顧客の反応</a>
                                    <a class="dropdown-item" href="#">顧客の反応</a>
                                </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- <div class="row mt-1 menu-back">
                <div class="col-sm">
                  <button type="button" class="btn btn-light btn-lg btn-block sec-menu">トレーナー </button>
                </div>
                <div class="col-sm">
                  <button type="button" class="btn btn-light btn-lg btn-block sec-menu"> 顧客の反応 </button>
                </div>
                <div class="col-sm">
                  <button type="button" class="btn btn-light btn-lg btn-block sec-menu">費用 </button>
                </div>
                <div class="col-sm">
                  <button type="button" class="btn btn-light btn-lg btn-block sec-menu">サービス機能 </button>
                </div>
                <div class="col-sm ">
                        
                        <div class="col-sm-12 middle">
                            <img class="mx-auto d-block" src="{{asset('asset/images/doticon2.png')}}">
                        <div class="dropdown more">
                            <a class="middle more-btn" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                More
                            </a>
                          
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                              <a class="dropdown-item" href="#">デモメニュー</a>
                              <a class="dropdown-item" href="#">デモメニュー</a>
                              <a class="dropdown-item" href="#">デモメニュー</a>
                            </div>
                          </div>
                        </div>
                        
                </div>
        </div> -->
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
                <img class="img-fluid" src="{{asset('asset/images/mini-banner-1.png')}}">
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
            <div class="col-sm-8 sm-auto light-ash pt-2 pb-3 mb-5 review-box"></div>
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
            <div class="col-sm">
                <div class="col-sm-8 offset-sm-2 light-ash rate-plan"></div>
            </div>
            <div class="col-sm">
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
            <div class="col-sm p-5 m-4">
                <div class="col-sm-12 light-ash service-feature"></div>
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
    </div> <!-- container end-->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="{{asset('asset/bootstrap/js/bootstrap.min.js')}}"></script>
</body>

</html>