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
                                <a class="nav-link" href="{{ route('trainersList') }}">トレーナー</a>
                            </li>
                            
                            <li class="nav-item ">
                                <a class="nav-link" href="{{ route('review') }}">カスタマーレビュー</a>
                            </li>

                            <li class="nav-item ">
                                <a class="nav-link" href="#">残高 </a>
                            </li>

                            <li class="nav-item ">
                                <a class="nav-link" href="#service">進捗 </a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="#service">個人設定 </a>
                            </li>


                                <li class="nav-item ">
                                    <a class="nav-link" href="{{ route('traineeSignup')}}" >
                                        <i class="fas fa-user-plus"></i> {{-- Trainee registration --}}
                                            ユーザー登録
                                    </a>
                                    
                                </li>

                                <li class="nav-item ">
                                    <a class="nav-link" href="{{ route('traineeLogin')}}" >
                                        <i class="fas fa-lock"></i>  ユーザーログイン
                                    </a>
                                </li>
                        </ul>
                    </div>
                    {{-- <div class="menu_btn">
                        <a href="#" class="btn_2 d-none d-sm-block">Get started</a>
                    </div> --}}
                </nav>
            </div>
        </div>
    </div>
</header>