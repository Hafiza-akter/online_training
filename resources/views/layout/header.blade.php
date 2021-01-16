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


                                <?php if (!Session::get('user')) { ?>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="blog.html" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-user-plus"></i> 登録
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
                                        <a class="nav-link dropdown-toggle" href="blog.html" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

                                <?php } else { ?>
                                    <li>
                                        <a class="nav-link user-profile" data-toggle="dropdown" href="#">
                                            <i class="far fa-user-circle user-profile" style="font-size: 20px;"></i>
                                            <!-- <img src="{{asset('asset_v2/images/thumb.png')}}" /> -->
                                            <!-- <span class="badge badge-warning navbar-badge">15</span> -->
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
                                            <a href="#" class="dropdown-item item-down">
                                                <i class="fas fa-edit mr-2"></i> Edit Profile
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a href="{{ route('traineeLogout')}}" class="dropdown-item item-down">
                                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                            </a>
                                    </li>
                                <?php } ?>
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