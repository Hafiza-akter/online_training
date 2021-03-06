<header class="main_menu dashboard_menu">
<div class="container">
    <div class="row align-items-center">
        <div class="col-lg-12">
            <nav class="navbar navbar-expand-lg navbar-light">
                @if(Session::get('user_type') == 'trainee' )
                <a class="navbar-brand " href="#" style="color: #fff0ff;font-size: 24px;font-weight: bolder;"> 
                    @if(\App\Model\Trainee::find(Session::get('user.id'))->name != NULL)
                        {{ \App\Model\Trainee::find(Session::get('user.id'))->name }} 様
                    @else 
                    メディカルジムオンライン 
                    @endif

                </a>
                @endif

                @if(Session::get('user_type') == 'trainer' )
                <a class="navbar-brand " href="#" style="color: #fff0ff;font-size: 28px;font-weight: bolder;"> 
                    @if(\App\Model\Trainer::find(Session::get('user.id'))->first_name != NULL)
                        {{ \App\Model\Trainer::find(Session::get('user.id'))->first_name }}  様
                    @else 
                    トレーナー管理画面
                    @endif
                </a>
                @endif


                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse main-menu-item justify-content-end" id="navbarSupportedContent">

                    <ul class="navbar-nav">
                        @if(Session::get('user_type') == 'trainee' )
           
                            <li class="nav-item  {{ !empty($isActive) &&  $isActive == 'schedule' ? 'active__' : ''}}">
                                {{-- schedule --}}
                                <a class="nav-link" href="{{ route('traineeCalendar.view') }}">スケジュール</a>
                            </li>
                            <li class="nav-item ">
                                    {{-- plan purchase --}}
                                <a class="nav-link {{ !empty($isActive) &&  $isActive == 'purchase' ? 'active__' : ''}}" href="{{ route('purchaseplan')}}">プラン購入</a>
                            </li>
                            <li class="nav-item ">
                                    {{-- progress --}}
                                <a class="nav-link {{ !empty($isActive) &&  ($isActive == 'progress' || $isActive == 'dailydata') ? 'active__' : ''}}" href="{{ route('progress')}}">達成状況</a>
                            </li>
                            <li class="nav-item ">
                                    {{-- training history --}}
                                <a class="nav-link {{ !empty($isActive) &&  ($isActive == 'traininglist' || $isActive == 'traininglist') ? 'active__' : ''}}" href="{{ route('traineelist')}}">トレーニング</a>
                            </li>
                            
                            <li class="nav-item ">
                                     {{-- Personal Settings --}}
                                <a class="nav-link {{ !empty($isActive) &&  $isActive == 'p-settings' ? 'active__' : ''}}" href="{{ route('trainee.p-settings') }}">個人設定 </a>
                            </li>

                            <li class="nav-item ">
                                     {{-- Personal Settings --}}
                                <a class="nav-link {{ !empty($isActive) &&  $isActive == 'inquiry' ? 'active__' : ''}}" href="{{ route('inquiry') }}">問い合わせ</a>
                            </li>
                            <li class="nav-item ">
                                     {{-- Lgout  --}}
                               <a class="btn" href="{{ route('traineeLogout')}}"> <i class="fas fa-sign-out-alt"></i></span>  </a>

                            </li>

                        @endif 

                        @if(Session::get('user_type') == 'trainer' )
                            
                            <li class="nav-item  {{ !empty($isActive) &&  $isActive == 'schedule' ? 'active__' : ''}}">
                                {{-- schedule --}}
                                <a class="nav-link" href="{{ route('calendar.view','month') }}">スケジュール</a>
                            </li>
                            
                            <li class="nav-item ">
                                    {{-- progress --}}
                                <a class="nav-link {{ !empty($isActive) &&  $isActive == 'traininglist' ? 'active__' : ''}}" href="{{ route('traininglist')}}">達成状況</a>
                            </li>

                            <li class="nav-item ">
                                     {{-- Personal Settings --}}
                                <a class="nav-link {{ !empty($isActive) &&  $isActive == 'p-settings' ? 'active__' : ''}}" href="{{ route('trainer.p-settings') }}">個人設定 </a>
                            </li>
                            <li class="nav-item ">
                                     {{-- Personal Settings --}}
                                <a class="nav-link {{ !empty($isActive) &&  $isActive == 'inquiry' ? 'active__' : ''}}" href="{{ route('inquiry') }}">問い合わせ</a>
                            </li>

                             <li class="nav-item ">
                                     {{-- Lgout  --}}
                               <a class="btn" href="{{ route('trainerLogout')}}"> <i class="fas fa-sign-out-alt"></i></span>  </a>

                            </li>

                        @endif

                          {{--   <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="blog.html" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-lock"></i> ログイン
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('trainerLogin') }}">
                                        トレーナーログイン

                                    </a>
                                    <a class="dropdown-item" href="{{ route('traineeLogin') }}">
                                        研修生ログイン
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