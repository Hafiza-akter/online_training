{{-- @extends('master_page') --}}
@extends('master_dashboard')
@section('title','user dashboard')
@section('content')
<style>
     .login_button{
        border-radius: 1px !important;
        font-size: 18px;
        width:400px;
        color: #a506a4;
        border: 2px solid #bb07bb;
        }
.gradient{
    background-image:linear-gradient(to left, purple 0%, #c300c3 50%, #7e007e 100%);color: #fff !important;
}
</style>


<section class="about_us section_padding">
        <div class="container  section_padding">

            <div class="row justify-content-center">
               
                <div class="col-md-12 col-xl-12">
                    <div class="section_tittle">
                        {{-- Training start immediately --}}
                       <a href="{{ route('physicaldata')}}" class="btn_2" style="border-radius: 1px !important;border: 2px solid #c604c6;font-size: 18px;">すぐにトレーニングを開始</a>
                    </div>
                </div>

                <div class="col-md-12 col-xl-12">
                    <div class="section_tittle">
                        {{-- Take a peek at what it looks like --}}
                       <a href="" class="btn_2" style="border-radius: 1px !important;border: 2px solid #c604c6;font-size: 18px;">それがどのように見えるかを覗いてみてください</a>
                    </div>
                </div>

            </div>
           
        </div>
        <div class="overlay_icon">
            <img src="{{ asset('asset_v2/img/animate_icon/icon_1.png')}}" class="amitated_icon_1" alt="animate_icon">
            <img src="{{ asset('asset_v2/img/animate_icon/icon_2.png')}}" class="amitated_icon_2" alt="animate_icon">
            <img src="{{ asset('asset_v2/img/animate_icon/icon_4.png')}}" class="amitated_icon_4" alt="animate_icon">
            <img src="{{ asset('asset_v2/img/animate_icon/icon_5.png')}}" class="amitated_icon_5" alt="animate_icon">
        </div>

   

</section>




@endsection
@section('footer_css_js')
<script>
    $(document).ready(function() {

        $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
            $(".alert-success").slideUp(500);
        });

        $('.datepicker').datepicker();

    });

</script>
@endsection 