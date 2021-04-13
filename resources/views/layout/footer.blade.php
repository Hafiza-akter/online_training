<footer class="footer-area">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-sm-6 col-md-4">
{{--                    <div class="single-footer-widget footer_1">
                        <h4>About Us</h4>
                        <p>Heaven fruitful doesn't over for these theheaven fruitful doe over days
                            appear creeping seasons sad behold beari ath of it fly signs bearing
                            be one blessed.</p>
                    </div>--}}
                </div>
                <div class="col-xl-3 col-sm-6 col-md-4">
{{--                   <div class="single-footer-widget footer_2">
                        <h4>Important Link</h4>
                        <div class="contact_info">
                            <ul>
                                <li><a href="#">link 1</a></li>
                                <li><a href="#">link 1</a></li>
                                <li><a href="#">link 1</a></li>
                            </ul>
                        </div>
                    </div>--}}
                </div>
                <div class="col-xl-3 col-sm-6 col-md-4">
                    <div class="single-footer-widget footer_2">
                        <h4>Contact us</h4>
                        <div class="contact_info">
{{--                           <p><span> Address :</span> Hath of it fly signs bear be one blessed after </p>--}}
                            <p><span> Phone :</span>0859-21-7787</p>
                            <p><span> Email : info@rzero.jp</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-md-6">
                    <div class="single-footer-widget footer_3">
                        @if(Session::get('user_type') === 'trainer' || Session::get('user_type') === 'trainee')
                        @else
                         <a class="btn_2" style="border-radius: 1px !important;border: 2px solid #c604c6;font-size: 18px;" href="{{route('trainerLogin')}}">
                            {{-- click here for trainers --}}
                            トレーナーはこちら
                        </a>

                        @endif
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