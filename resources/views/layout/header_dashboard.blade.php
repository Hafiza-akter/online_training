  <header class="main_menu dashboard_menu">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        
                        <div class="collapse navbar-collapse main-menu-item justify-content-end" id="navbarSupportedContent">

                            <ul class="navbar-nav">
                                <li class="nav-item ">
                                        {{-- schedule --}}

                                    <a class="nav-link" href="{{ route('toppage')}}"><i class="fas fa-home " style="font-size: 21px"></i>
                                    </a>
                                </li>
                                <li class="nav-item  {{ !empty($isActive) &&  $isActive == 'schedule' ? 'active__' : ''}}">
                                    {{-- schedule --}}
                                    <a class="nav-link" href="{{ route('trainerCalendar.view') }}">スケジュール</a>
                                </li>
                                
                                <li class="nav-item ">
                                        {{-- progress --}}
                                    <a class="nav-link" href="#">進捗</a>
                                </li>

                                <li class="nav-item ">
                                         {{-- Personal Settings --}}
                                    <a class="nav-link" href="#">個人設定 </a>
                                </li>
                                 <li class="nav-item ">
                                         {{-- Lgout  --}}
                                   <a class="btn" href="{{ route('traineeLogout')}}"> <i class="fas fa-sign-out-alt"></i></span>  </a>

                                </li>


                                  {{--   <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="blog.html" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-lock"></i> ログイン
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('trainerLogin') }}">
                                                トレーナーログイン

                                            </a>
                                            <a class="dropdown-item" href="{{ route('traineeLogin') }}">
                                                ユーザーログイン
                                            </a>
                                        </div>
                                    </li> --}}
                            </ul>
                        </div>

                    </nav>
                </div>
            </div>
        </div>
    </header>