<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Online Training</title>
    <link rel="icon" href="img/favicon.png')}}">

    <link rel="stylesheet" href="{{asset('asset_v2/css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{asset('asset_v2/css/animate.css')}}">

    <link rel="stylesheet" href="{{asset('asset_v2/css/owl.carousel.min.css')}}">

    <link rel="stylesheet" href="{{asset('asset_v2/css/themify-icons.css')}}">

    <link rel="stylesheet" href="{{asset('asset_v2/css/flaticon.css')}}">

    <link rel="stylesheet" href="{{asset('asset_v2/css/magnific-popup.css')}}">

    <link rel="stylesheet" href="{{asset('asset_v2/css/all.css')}}">

    <link rel="stylesheet" href="{{asset('asset_v2/css/style.css')}}">
</head>

<body>

    <header class="main_menu home_menu">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        {{-- <a class="navbar-brand" href="{{route('toppage')}}"> <img src="{{asset('asset_v2/img/logo.png')}}" alt="logo"> </a> --}}
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse main-menu-item justify-content-end" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li class="nav-item ">
                                    <a class="nav-link" href="{{ route('toppage')}}"><i class="fas fa-home " style="font-size: 21px"></i> 
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href=" {{ route('trainerList') }}">トレーナー</a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link" href="{{ route('review') }}">カスタマーレビュー</a>
                                </li>

                                 <li class="nav-item ">
                                    <a class="nav-link" href="#">料金</a>
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link" href="#service">サービス機能</a>
                                </li>
                                
                                

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="blog.html"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                       <i class="fas fa-user-plus"></i>  登録
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{route('traineeSignup')}}">
                                            {{-- Trainee registration --}}
                                                研修生登録
                                            </a>
                                            <a class="dropdown-item" href="{{route('trainerSignup')}}">
                                                {{-- Trainer registration --}}
                                                トレーナー登録
                                            </a>
                                    </div>
                                </li>
                                
                                 <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="blog.html"  role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                       <i class="fas fa-lock"></i> ログイン
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('trainerLogin') }}">
                                            {{-- TRAINER LOGIN --}}
                                            トレーナーログイン

                                             </a>
                                            <a class="dropdown-item" href="{{ route('traineeLogin') }}">
                                            {{-- TRAINEE LOGIN --}}
                                            研修生ログイン
                                            </a>
                                    </div>
                                </li>
                                
                            
                            </ul>
                        </div>
                       {{--  <div class="menu_btn">
                            <a href="#" class="btn_2 d-none d-sm-block">Get started</a>
                        </div> --}}
                    </nav>
                </div>
            </div>
        </div>
    </header>



    @yield('content')



    <footer class="footer-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-sm-6 col-md-4">
                    <div class="single-footer-widget footer_1">
                        <h4>About Us</h4>
                        <p>Heaven fruitful doesn't over for these theheaven fruitful doe over days
                            appear creeping seasons sad behold beari ath of it fly signs bearing
                            be one blessed.</p>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-md-4">
                    <div class="single-footer-widget footer_2">
                        <h4>Important Link</h4>
                        <div class="contact_info">
                            <ul>
                                <li><a href="#">link 1</a></li>
                                <li><a href="#">link 1</a></li>
                                <li><a href="#">link 1</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-md-4">
                    <div class="single-footer-widget footer_2">
                        <h4>Contact us</h4>
                        <div class="contact_info">
                            <p><span> Address :</span> Hath of it fly signs bear be one blessed after </p>
                            <p><span> Phone :</span> +2 36 265 (8060)</p>
                            <p><span> Email : testinfo@gmail.com</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-md-6">
                    <div class="single-footer-widget footer_3">
                        <h4>Newsletter</h4>
                        <p>Heaven fruitful doesn't over lesser in days. Appear creeping seas</p>
                        <form action="#">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder='Email Address' onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'">
                                    <div class="input-group-append">
                                        <button class="btn" type="button"><i class="fas fa-paper-plane"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="copyright_part_text">
                <div class="row">
                    <div class="col-lg-8">
                        <p class="footer-text m-0">
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved | Company name

                        </p>
                    </div>
                    <div class="col-lg-4">
                        <div class="copyright_social_icon text-right">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="ti-dribbble"></i></a>
                            <a href="#"><i class="fab fa-behance"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>



    <script src="{{asset('asset_v2/js/jquery-1.12.1.min.js')}}"></script>

    <script src="{{asset('asset_v2/js/popper.min.js')}}"></script>

    <script src="{{asset('asset_v2/js/bootstrap.min.js')}}"></script>

    <script src="{{asset('asset_v2/js/jquery.magnific-popup.js')}}"></script>

    <script src="{{asset('asset_v2/js/swiper.min.js')}}"></script>

    <script src="{{asset('asset_v2/js/masonry.pkgd.js')}}"></script>

    <script src="{{asset('asset_v2/js/owl.carousel.min.js')}}"></script>

    <script src="{{asset('asset_v2/js/slick.min.js')}}"></script>
    <script src="{{asset('asset_v2/js/gijgo.min.js')}}"></script>
    {{-- <script src="{{asset('asset_v2/js/jquery.nice-select.min.js')}}"></script> --}}

    <script src="{{asset('asset_v2/js/custom.js')}}"></script>
    <script>
        $(document).ready(function() {
            $(".alert").delay(4000).slideUp(200, function() {
                $(this).alert('close');
            });
    });

    </script>
</body>

</html>