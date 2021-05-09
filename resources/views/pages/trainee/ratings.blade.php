{{-- @extends('master_page') --}}
@extends('master_dashboard')
@section('title','trainee personal settings')
@section('header_css_js')
<link rel="stylesheet" href="{{asset('asset_v2/css/range_slider.css')}}">
<style>
  .stars-outer {
  display: inline-block;
  position: relative;
  font-family: FontAwesome;
}

.stars-outer::before {
  content: "\f006 \f006 \f006 \f006 \f006";
}

.stars-inner {
  position: absolute;
  top: 0;
  left: 0;
  white-space: nowrap;
  overflow: hidden;
  width: 0;
}

.stars-inner::before {
  content: "\f005 \f005 \f005 \f005 \f005";
  color: #f8ce0b;
}

</style>
@php 
    // $param=encryptionValue(['user_id' => $user->id]);
@endphp
@endsection
@section('content')
<style>
</style>


<section class="about_us section_padding">


    <div class="offset-sm-2 col-sm-8 mb-4">
      
        @if(Session::has('message'))
        <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
        @endif
         @if(Session::has('success'))
        <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('success') }}</p>
        @endif



    </div>

      <div class="row justify-content-center">
                <div class="col-md-8 col-xl-8  mb-30">
                        <h2 style="text-align:center;font-size:2em;color:black;" class="section_title">今回のトレーナーの感想をお願いします</h2>
                </div>
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

    <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-3">
                  <label class="col-form-label float-right " style="font-size:1.3em;margin-top:10px;font-weight: bold"> 笑顔 </label>
                </div>
                <div class="col-8">
                      <input type="text" class="js-range-slider" name="smile" value="" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-3">
                  <label class="col-form-label float-right" style="font-size:1.3em;margin-top:10px;font-weight: bold"> 熱血 </label>
                </div>
                <div class="col-8">
                  <input type="text" class="js-range-slider" name="passion" value="" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-3">
                  <label class="col-form-label float-right" style="font-size:1.3em;margin-top:10px;font-weight: bold">経験</label>
                </div>
                <div class="col-8">
                  <input type="text" class="js-range-slider" name="experience" value="" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-3">
                  <label class="col-form-label float-right" style="font-size:1.3em;margin-top:10px;font-weight: bold">マッスル</label>
                </div>
                <div class="col-8">
                  <input type="text" class="js-range-slider" name="muscle" value="" />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">
                  <label class="col-form-label float-right" style="font-size:1.3em;margin-top:10px;font-weight: bold"> 指導力 </label>
                </div>
                <div class="col-8">
                  <input type="text" class="js-range-slider" name="leadership" value="" />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">
                  <label class="col-form-label float-right" style="font-size:1.3em;margin-top:10px;font-weight: bold">コミュニケーション</label>
                </div>
                <div class="col-8">
                  <input type="text" class="js-range-slider" name="communication" value="" />
                </div>
            </div>

            <div class="row " style="text-align: center;font-size:1.7em;">
                <div class="col">

                    <div class="stars-outer">
                      <div class="stars-inner"></div>
                    </div>  &nbsp;

                  <span style="font-size: 18px;"> ズバリ評価は</span>
                          &nbsp;
                    <div class="stars-outer">
                      <div class="stars-inner"></div>
                    </div>

                </div>
            </div>
            <div class="row " style="text-align: center;font-size:1.7em;">
                <div class="col">

                

                  <span style="font-size: 18px;"> 星</span>
                       <input type="text" id="total" name="total" value="5" style="text-align:center; width:50px" readonly disabled="true" />
                  <span style="font-size: 18px;"> 個!</span>


                </div>
                
                
            </div>


        </div>

        <div class="card-footer">
            <div class="row pt-3 pb-3">
                <button type="submit" class="mx-auto btn btn-secondary text-white btn-lg gradient ">更新</button>
            </div>
        </div>
  
    </div>
  </div>
</div>
</section>

<!-- Modal -->




@endsection
@section('footer_css_js')

<script src="{{asset('asset_v2/js/range_slider.js')}}"></script>

<script>
    $(document).ready(function() {

      function setRatings(val){
          let starPercentage = (val /60) * 100;
          let total = (val*5)/60;
          let starPercentageRounded = `${Math.round(starPercentage / 10) * 10}%`;
          $(".stars-inner").css("width", starPercentageRounded);
          $("#total").val(total.toFixed(1));

      }

      function updateArray(key,val){
        ratingsArray[key] = val;

      }





      var ratingsArray = {
        'smile':5,
        'passion':5,
        'experience':5,
        'muscle':5,
        'leadership':5,
        'communication':5
      };

      $(".js-range-slider").ionRangeSlider({
        min: 0,
        max: 10,
        from: 5,
        onStart: function (data) {
            // Called right after range slider instance initialised
    
            updateArray(data.input.attr('name'),$("input[name^="+data.input.attr('name')+"]").val());
          
            let total = Object.values(ratingsArray).reduce((t, n) => parseInt(t) + parseInt(n))
            setRatings(total);
            console.log('On start '+total);
        },
    
        onChange: function (data) {
            // Called every time handle position is changed
    
            updateArray(data.input.attr('name'),$("input[name^="+data.input.attr('name')+"]").val());

            let total = Object.values(ratingsArray).reduce((t, n) => parseInt(t) + parseInt(n))
            setRatings(total);
            console.log('On change '+total);

        },
    
        onFinish: function (data) {
            // Called then action is done and mouse is released
    
              updateArray(data.input.attr('name'),$("input[name^="+data.input.attr('name')+"]").val());

              let total = Object.values(ratingsArray).reduce((t, n) => parseInt(t) + parseInt(n))
              setRatings(total);
            console.log('On finish '+total);
        },
        onUpdate: function (data) {
            // Called then slider is changed using Update public method
    
          console.log.log('update'); 

        }
    });


    


      const ratings = {
        smile: 2.8,
        passion: 3.3,
        experience: 1.9,
        muscle: 4.3,
        leadership: 4.74,
        communication: 4.74,
      };

      // total number of stars
      const starTotal = 10;
      const starPercentage = (25 /50) * 100;
      const starPercentageRounded = `${Math.round(starPercentage / 10) * 10}%`;
      document.querySelector(
          `.stars-inner`
        ).style.width = starPercentageRounded;

      // for (const rating in ratings) {
      //   const starPercentage = (ratings[rating] / starTotal) * 100;
      //   const starPercentageRounded = `${Math.round(starPercentage / 10) * 10}%`;
      //   document.querySelector(
      //     `.${rating} .stars-inner`
      //   ).style.width = starPercentageRounded;
      // }


      $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
          $(".alert-success").slideUp(500);
      });


    });
    $(function () {
    $('#photo_path').change(function () {
        var val = $(this).val().toLowerCase(),
            regex = new RegExp("(.*?)\.(jpg|jpeg|png)$");
        if (!(regex.test(val))) {
            $(this).val('');
            alert(' Image file is not valid !!');
        }
    });



});



</script>
@endsection 