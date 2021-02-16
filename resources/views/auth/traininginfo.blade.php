{{-- @extends('master_page') --}}
@extends('master_dashboard')
@section('title','user physical data')
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
        <div class="container">

            <div class="row justify-content-center">
               
                <div class="col-md-8 col-xl-6">
                    <div class="section_tittle">
                       <h2>研修情報登録</h2>
                    </div>
                </div>
            </div>
           
        </div>
        <div class="overlay_icon">
            <img src="http://training.local:8080/public/asset_v2/img/animate_icon/icon_1.png" class="amitated_icon_1" alt="animate_icon">
            <img src="http://training.local:8080/public/asset_v2/img/animate_icon/icon_2.png" class="amitated_icon_2" alt="animate_icon">
            <img src="http://training.local:8080/public/asset_v2/img/animate_icon/icon_3.png" class="amitated_icon_3" alt="animate_icon">
            <img src="http://training.local:8080/public/asset_v2/img/animate_icon/icon_4.png" class="amitated_icon_4" alt="animate_icon">
            <img src="http://training.local:8080/public/asset_v2/img/animate_icon/icon_5.png" class="amitated_icon_5" alt="animate_icon">
        </div>

        <div class="offset-sm-2 col-sm-8 mb-4">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <!-- /.card-header -->
    <!-- form start -->
    @if(Session::has('success'))
    <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}</p>
    @endif



</div>



<div class="offset-sm-2 col-sm-8 mb-4">
    <div class="card card-info">
      

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{route('traininginfo.submit')}}" method="post">
                   
        {{ csrf_field() }}
            <input type="hidden" name="email" class="form-control" value="{{ $user->email}}">
            <input type="hidden" name="user_id" class="form-control" value="{{ $user->id}}">   
            <div class="card-body">
            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label _phone_number_">電話番号 <span style="color:red">*</span></label>
                </div>
                <div class="col-8">
                  <input type="text" name="phone" class="form-control" value="{{ $user->phone}}">
                </div>
            </div>



            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label _address_">住所 <span style="color:red">*</span></label>
                </div>
                <div class="col-8">
                  <input type="text" name="address" class="form-control" value="{{ $user->address}}">
                </div>
            </div>

            <div class="row mb-3">
                <h3 class="mx-auto">所有機器</h3>
            </div>


            @if($equipment)
                @foreach($equipment as $key=>$val)
                <div class="row mb-3">
                    <div class="col-4">
                        <input type="hidden" name="equipment[{{$key}}][id]" value="{{$val->id }}">
                        <label class="col-form-label _barbell_">{{$val->name }}</label>
                    </div>
                    <div class="col-8">
                        <select class="form-control" name="equipment[{{$key}}][is_available]">
                            <option value="0" > いいえ</option>
                            <option value="1" {{ checkEquipment($user->id,$val->id) ? 'selected="selected' : ''}} > はい</option>


                        </select>
                    </div>
                </div>
                @endforeach
            @endif 

        </div>
        <div class="card-footer">
            <div class="row pt-3 pb-3">
                <button type="submit" class="mx-auto btn btn-secondary text-white btn-lg gradient ">決定</button>
            </div>
        </div>
      
    </form>
  </div>
</div>
</section>




@endsection
@section('footer_css_js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script>
    $(document).ready(function() {

        $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
            $(".alert-success").slideUp(500);
        });

        $('.datepicker').datepicker();

    });

</script>
@endsection 