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
      $trainer_name = getTrainerName($schedule->id)->first_name;
      $trainer_id = getTrainerName($schedule->id)->id;
      $user_id = getUserName($schedule->id)->id;

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

     <div class="row justify-content-center">
       <div id="uploaded_image" style="border:1px solid #eee;padding:10px">

        @if($schedule->is_favourite == 1)
          <i class="fas fa-heart fa-2x"  id="icon_fav"  style="color:red"></i>
        @endif

          @if(getTrainerName($schedule->id)->icon_image != NULL)
          <img class="rounded-circle" src="{{ url('storage/icons/'.getTrainerName($schedule->id)->icon_image)}}" style="display: block"/>
          @else 
          <img src="{{asset('images/default.png')}}"  width="200" width="200" style="display: block">
          @endif 
        
          <p style="text-align: center;font-color:#000;font-size:16px;font-weight: bold;">  {{ $trainer_name }} 様     </p>
          
          @if($schedule->is_favourite == 1)
                    <p style="text-align: center;font-color:#000;font-size:16px;font-weight: bold;" class="btn-primary remove_fav mb-3"  > お気に入りリストから削除 </p>
            @else 
                    <p style="text-align: center;font-color:#000;font-size:16px;font-weight: bold;" class="btn-primary add_fav mb-3"> お気に入りに追加 </p>.
          @endif
      
      </div> 
      
  </div>



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
                      <input type="text" class="js-range-slider" name="smile" value=""
                      data-min="0"
                      data-max="5"
                      data-from="{{ $ratings->smile ?? 0}}"
                      />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-3">
                  <label class="col-form-label float-right" style="font-size:1.3em;margin-top:10px;font-weight: bold"> 熱血 </label>
                </div>
                <div class="col-8">
                  <input type="text" class="js-range-slider" name="passion" value=""
                      data-min="0"
                      data-max="5"
                      data-from="{{ $ratings->passion?? 0}}" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-3">
                  <label class="col-form-label float-right" style="font-size:1.3em;margin-top:10px;font-weight: bold">経験</label>
                </div>
                <div class="col-8">
                  <input type="text" class="js-range-slider" name="experience" value="" 
                      data-min="0"
                      data-max="5"
                      data-from="{{ $ratings->experience?? 0}}"
                    />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-3">
                  <label class="col-form-label float-right" style="font-size:1.3em;margin-top:10px;font-weight: bold">マッスル</label>
                </div>
                <div class="col-8">
                  <input type="text" class="js-range-slider" name="muscle" value="" 
                      data-min="0"
                      data-max="5"
                      data-from="{{ $ratings->muscle?? 0}}"
                  />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">
                  <label class="col-form-label float-right" style="font-size:1.3em;margin-top:10px;font-weight: bold"> 指導力 </label>
                </div>
                <div class="col-8">
                  <input type="text" class="js-range-slider" name="leadership" value="" 
                      data-min="0"
                      data-max="5"
                      data-from="{{ $ratings->leadership?? 0}}"
                  />
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-3">
                  <label class="col-form-label float-right" style="font-size:1.3em;margin-top:10px;font-weight: bold">コミュニケーション</label>
                </div>
                <div class="col-8">
                  <input type="text" class="js-range-slider" name="communication" value="" 
                      data-min="0"
                      data-max="5"
                      data-from="{{ $ratings->communication?? 0}}"
                   />
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
                <button type="submit" class="mx-auto btn btn-secondary text-white btn-lg gradient submit" >更新</button>
               
            </div>

            <div id="loading" class="row pt-3 pb-3 justify-content-center" style="display: none;">
                   評価の提出... <i class="fas fa-spinner fa-spin fa-2x "></i>
            </div>
        </div>
  
    </div>
  </div>
</div>
</section>

<!-- Modal -->




@endsection
@section('footer_css_js')
<script src='{{ asset('asset_v2/js/sweetalert2@10.js')}}'></script>

<script src="{{asset('asset_v2/js/range_slider.js')}}"></script>

<script>
    $(document).ready(function() {
      function wait(ms){
   var start = new Date().getTime();
   var end = start;
   while(end < start + ms) {
     end = new Date().getTime();
  }
}
      function setRatings(val){
          let starPercentage = (val /30) * 100;
          let total = (val*5)/30;
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



    $('.submit').click(function(event){
        $('#loading').show();
       

            $.ajax({
                type: "POST",
                url: '{{ route('userRatingsSubmit')}}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

                data: { 'data': ratingsArray,'user_id':{{ $user_id}},'trainer_id':{{ $trainer_id}},'schedule_id': {{ $schedule->id}}  },
                cache: false,
                success: function(res) {
                      $('#loading').hide();
                     location.reload();

                },
                error:function(request, status, error) {
                      $('#loading').hide();

                   alert('something went wrong');
                    console.log("ajax call went wrong:" + request.responseText);
                }
            });

    });
      
// $('.remov_fav').click(function(){
//         $("#icon_fav").hide();
//           $(".add_fav").show();
//           $(".remov_fav").hide();
//     });

$('.add_fav').click(function(){
    $.ajax({
        type: "POST",
        url: '{{ route('favouritetrainer')}}',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

        data: { 'schedule_id': {{ $schedule->id}}  },
        cache: false,
        success: function(res) {
        
               location.reload();

           
        },
        error:function(request, status, error) {
              alert('something went wrong');
            console.log("ajax call went wrong:" + request.responseText);
        }
     });
})

$('.remove_fav').click(function(){
    $.ajax({
      type: "POST",
      url: '{{ route('removeFavourite')}}',
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },

      data: { 'schedule_id': {{ $schedule->id}}  },
      cache: false,
      success: function(res) {
     
             // wait(3000);

             location.reload();

         
      },
      error:function(request, status, error) {
            alert('something went wrong');
          console.log("ajax call went wrong:" + request.responseText);
      }
   });
})

    
    
      $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
          $(".alert-success").slideUp(500);
      });


    });
   


</script>
@endsection 