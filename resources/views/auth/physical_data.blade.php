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
                       <h2>物理情報登録</h2>
                    </div>
                </div>
            </div>
           
        </div>
        <div class="overlay_icon">
            <img src="{{ asset('asset_v2/img/animate_icon/icon_1.png')}}" class="amitated_icon_1" alt="animate_icon">
            <img src="{{ asset('asset_v2/img/animate_icon/icon_2.png')}}" class="amitated_icon_2" alt="animate_icon">
            <img src="{{ asset('asset_v2/img/animate_icon/icon_3.png')}}" class="amitated_icon_3" alt="animate_icon">
            <img src="{{ asset('asset_v2/img/animate_icon/icon_4.png')}}" class="amitated_icon_4" alt="animate_icon">
            <img src="{{ asset('asset_v2/img/animate_icon/icon_5.png')}}" class="amitated_icon_5" alt="animate_icon">
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
    @if(Session::has('message'))
    <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
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

    <form action="{{route('physicaldata.submit')}}" method="post">
                   
        {{ csrf_field() }}
            <input type="hidden" name="email" class="form-control" value="{{ $user->email}}">
            <input type="hidden" name="user_id" class="form-control" value="{{ $user->id}}">   
            <div class="card-body">

            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label birthday">誕生日 <span style="color:red">*</span></label>
                </div>
                  <div class="col-8">
                  <input type="text" name="birthday" required="required" class="form-control datepicker" value="{{ $user->dob}}" readonly="readonly">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label sex">性別 <span style="color:red">*</span></label>
                </div>
                 <div class="col-8">
                    <select class="form-control" name="sex"  required="required">
                        <option value=""> 性別をお選びください</option> 
                        <option value="male" {{ $user->sex == 'male' ? 'selected' : ''}}> 男性</option> 
                        <option value="female" {{ $user->sex == 'female' ? 'selected' : ''}}> 女性</option>

                    </select>
                </div>
            </div>

            
            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label height">身長(cm) <span style="color:red">*</span></label>
                </div>
                  <div class="col-8">
                  <input  type="number"  min="0" step="0.01"  oninput="this.value = Math.abs(this.value)" required="required" name="height" class="form-control" value="{{ $user->length > 0 ? $user->length : ''}}">
                </div>
            </div>



           {{--  <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label _address_">住所</label>
                </div>
                <div class="col-8">
                  <input type="text" name="address" class="form-control" value="{{ old('address')}}">
                </div>
            </div> --}}

            {{-- <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label _phone_number_">電話番号</label>
                </div>
                <div class="col-8">
                  <input type="text" name="phone" class="form-control" value="{{ old('phone')}}">
                </div>
            </div> --}}

            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label _current_weight_">体重(kg) <span style="color:red">*</span></label>
                </div>
                <div class="col-8">
                  <input type="number"  step="0.01" name="weight"  required="required" class="form-control" value="{{ $user->weight}}"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                </div>
            </div>

         {{--    <div class="row mb-3">
                <div class="col-4">
                    <label class="col-form-label _body_fat_percentage_">体脂肪率 <span style="color:red">*</span></label>
                </div>
                <div class="col-8">
                    <input  type="number"  step="0.01" name="fat" class="form-control"  required="required" value="{{ old('fat')}}">
                </div>
            </div> --}}
             <div class="row mb-3">
                <div class="col-4">
                    <label class="col-form-label _pal_">身体活動レベル <span style="color:red">*</span> </label>
                </div>
                <div class="col-8">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="pal" id="exampleRadios1" value="low" {{ $user->pal == 1.5 ? 'checked' : ''}} required="required">
                      <label class="form-check-label" for="exampleRadios1">
                         低 ( 生活の大部分が座位で、静的な活動が中心の場合 )

                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="pal" id="exampleRadios2" value="medium" {{ $user->pal == 1.75 ? 'checked' : ''}} required="required">
                      <label class="form-check-label" for="exampleRadios2">
                        中 ( 座位中心の仕事だが、職場内での移動や立位での作業・接客等、あるいは通勤・買物・家事、軽いスポーツ等のいずれかを含む場合 )
                      </label>
                    </div>
                    <div class="form-check disabled">
                      <input class="form-check-input" type="radio" name="pal" id="exampleRadios3" value="high" {{ $user->pal == 2 ? 'checked' : ''}} required="required">
                      <label class="form-check-label" for="exampleRadios3">
                        

                                            高 ( 移動や立位の多い仕事への従事者。あるいは、スポーツなど余暇における活発な運動習慣をもっている場合 )
                      </label>
                    </div>
                </div>
            </div>




            {{-- @if($equipment)
                @foreach($equipment as $key=>$val)
                <div class="row mb-3">
                    <div class="col-4">
                        <input type="hidden" name="equipment[{{$key}}][id]" value="{{$val->id }}">
                        <label class="col-form-label _barbell_">{{$val->name }}</label>
                    </div>
                    <div class="col-8">
                        <select class="form-control" name="equipment[{{$key}}][is_available]">
                            <option value="1"> はい</option>
                            <option value="0"> いいえ</option>


                        </select>
                    </div>
                </div>
                @endforeach
            @endif  --}}

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
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<script>
    $(document).ready(function() {

        $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
            $(".alert-success").slideUp(500);
        });


    });
    $(function() {
  $('input[name="birthday"]').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1940,
    maxYear: 2010
  }, function(start, end, label) {

  });
});

</script>
@endsection 