{{-- @extends('master_page') --}}
@extends('master_dashboard')
@section('title','trainee personal settings')
@section('header_css_js')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@endsection
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
         @if(Session::has('success'))
        <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}</p>
        @endif



    </div>



<div class="offset-sm-2 col-sm-8 mb-4">

    


    <div class="card card-info">
      

   {{--  @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
      <li class="nav-item ">
        <a class="nav-link active" id="updateprofile-tab" data-toggle="pill" href="#updateprofile" role="tab" aria-controls="updateprofile" aria-selected="true"></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="changepassword-tab" data-toggle="pill" href="#changepassword" role="tab" aria-controls="changepassword" aria-selected="false">Change Password</a>
      </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="updateprofile" role="tabpanel" aria-labelledby="updateprofile-tab">
              <form action="{{route('trainee.p-settings.submit')}}" method="post">
                   
                {{ csrf_field() }}
                    <input type="hidden" name="email"  value="{{ $user->email}}">
                    <input type="hidden" name="user_id"  value="{{ $user->id}}">   
                    <input type="hidden" name="action_type"  value="info_update">   
                    <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-4">
                          <label class="col-form-label name">お名前</label>
                        </div>
                        <div class="col-8">
                          <input type="text" name="name" class="form-control" value="{{ $user->name}}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                          <label class="col-form-label sex">性別</label>
                        </div>
                         <div class="col-8">
                            <select class="form-control" name="sex">
                                {{-- 1 male, 0 女性  --}}
                                <option value=""> 性別をお選びください</option> 
                                <option value="1" {{ $user->sex == 1 ? 'selected' : ''}} > 男性</option> 
                                <option value="0" {{ $user->sex == 0 ? 'selected' : ''}}> 女性</option>


                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                          <label class="col-form-label birthday">誕生日</label>
                        </div>
                          <div class="col-8">
                          <input type="text" name="birthday" class="form-control datepicker" value="{{ date('Y-m-d',strtotime($user->dob)) }}" readonly="readonly">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                          <label class="col-form-label height">身長</label>
                        </div>
                          <div class="col-8">
                          <input type="number" name="height" class="form-control" value="{{ $user->length}}">
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-4">
                          <label class="col-form-label phonetic">ふりがな</label>
                        </div>
                        <div class="col-8">
                          <input type="text" name="phonetic" class="form-control" value="{{ $user->phonetic}}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                          <label class="col-form-label _email_address_">メールアドレス</label>
                        </div>
                        <div class="col-8">
                            <input type="email" name="email1" class="form-control" required="required" value="{{ $user->email}}">
                        </div>
                    </div>

                   

                    <div class="row mb-3">
                        <div class="col-4">
                          <label class="col-form-label _address_">住所</label>
                        </div>
                        <div class="col-8">
                          <input type="text" name="address" class="form-control" value="{{ $user->address}}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                          <label class="col-form-label _phone_number_">電話番号</label>
                        </div>
                        <div class="col-8">
                          <input type="text" name="phone" class="form-control" value="{{ $user->phone}}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                          <label class="col-form-label _current_weight_">現在の体重(kg)</label>
                        </div>
                        <div class="col-8">
                          <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" name="weight" class="form-control "  value="{{ $user->weight}}">
                        </div>
                    </div>

                  {{--   <div class="row mb-3">
                        <div class="col-4">
                            <label class="col-form-label _body_fat_percentage_">体脂肪率</label>
                        </div>
                        <div class="col-8">
                            <input type="text" name="fat" class="form-control" value="{{ $user->fat}}">
                        </div>
                    </div> --}}

                    <div class="row pt-3 pb-3">
                        <h4 class="mx-auto">トレーニング機器</h4>
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
                        <button type="submit" class="mx-auto btn btn-secondary text-white btn-lg gradient ">次へ</button>
                    </div>
                </div>
      
        </form>
      </div>

      <div class="tab-pane fade" id="changepassword" role="tabpanel" aria-labelledby="changepassword-tab">
        <form action="{{route('trainee.p-settings.submit')}}" method="post">
                   
            {{ csrf_field() }}
            <input type="hidden" name="email" class="form-control" value="{{ $user->email}}">
            <input type="hidden" name="user_id" class="form-control" value="{{ $user->id}}">   
            <input type="hidden" name="action_type" class="form-control" value="password_update">   
            <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label">以前のパスワード <span style="color:red">*</span></label>
                </div>
                <div class="col-8">
                  <input type="password" name="oldpassword" class="form-control" value="" required="required">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label">パスワード <span style="color:red">*</span></label>
                </div>
                <div class="col-8">
                  <input type="password" name="password" class="form-control" value="" required="required">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-4">
                  <label class="col-form-label _confirm_password_">パスワード(確認) <span style="color:red">*</span></label>
                </div>
                <div class="col-8">
                  <input type="password" name="password_confirmation" class="form-control" value="" required="required">
                </div>
            </div>

        </div>
        <div class="card-footer">
            <div class="row pt-3 pb-3">
                <button type="submit" class="mx-auto btn btn-secondary text-white btn-lg gradient ">次へ</button>
            </div>
        </div>
      
        </form>
      </div>
    </div>




  </div>
</div>
</section>




@endsection
@section('footer_css_js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<!-- for a specific version -->
<script
  src="https://cdn.jsdelivr.net/npm/zebra_datepicker@1.9.13/dist/zebra_datepicker.min.js"></script>
  <link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/zebra_datepicker@latest/dist/css/bootstrap/zebra_datepicker.min.css">
<script>
    $(document).ready(function() {

        $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
            $(".alert-success").slideUp(500);
        });
            // $('input.datepicker').Zebra_DatePicker();
        $('.datepicker').Zebra_DatePicker({
            direction: [false,['1900-01-01']]
        });
//         $('.datepicker').datepicker({
//             format: "yyyy-mm-dd",
//             autoclose: !0,
//             yearRange: "-150Y:-10Y",
// minDate: "-150Y",
// maxDate: "-10Y",

//         });

    });
//     // Restricts input for the given textbox to the given inputFilter.
// function setInputFilter(textbox, inputFilter) {
//   ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
//     textbox.addEventListener(event, function() {
//       if (inputFilter(this.value)) {
//         this.oldValue = this.value;
//         this.oldSelectionStart = this.selectionStart;
//         this.oldSelectionEnd = this.selectionEnd;
//       } else if (this.hasOwnProperty("oldValue")) {
//         this.value = this.oldValue;
//         this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
//       } else {
//         this.value = "";
//       }
//     });
//   });
// }



// setInputFilter(document.getElementById("uintTextBox"), function(value) {
//   return /^\d*$/.test(value); });
// // setInputFilter(document.getElementById("intLimitTextBox"), function(value) {
// //   return /^\d*$/.test(value) && (value === "" || parseInt(value) <= 500); });
// setInputFilter(document.getElementsByClassName("floatTextBox"), function(value) {
//   return /^\d*[.]?\d*$/.test(value); });


</script>
@endsection 