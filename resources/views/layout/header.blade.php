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
        <div class="row mt-1 menu-back">
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
                        <!-- <a href="#" class="more-btn" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="mx-auto d-block" src="asset/images/doticon2.png">More</a>
                        <div class="dropdown">
                            <div class="dropdown-menu "  aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div> -->
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
        </div>