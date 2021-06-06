{{-- @extends('master_page') --}}
@extends('master_dashboard')
@section('title','trainee personal settings')
@section('header_css_js')
<link rel="stylesheet" href="{{asset('asset_v2/css/range_slider.css')}}">
<style>
 .irs-min{
  display: none;
 }

/* Rating Star Widgets Style */
.rating-stars ul {
  list-style-type:none;
  padding:0;
  
  -moz-user-select:none;
  -webkit-user-select:none;
}
.rating-stars ul > li.star {
  display:inline-block;
  
}

/* Idle State of the stars */
.rating-stars ul > li.star > i.fa {
  font-size:1em; /* Change the size of the stars */
  color:#ccc; /* Color on idle state */
}

/* Hover state of the stars */
.rating-stars ul > li.star.hover > i.fa {
  color:#FFCC36;
}

/* Selected state of the stars */
.rating-stars ul > li.star.selected > i.fa {
  color:#FF912C;
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

        @if(is_favourite(Session::get('user.id'),$schedule->trainer_id))
          <i class="fas fa-heart fa-2x"  id="icon_fav"  style="color:red"></i>
        @endif

          @if(getTrainerName($schedule->id)->icon_image != NULL)
          <img class="rounded-circle" src="{{ url('storage/icons/'.getTrainerName($schedule->id)->icon_image)}}" style="display: block"/>
          @else 
          <img src="{{asset('images/default.png')}}"  width="200" width="200" style="display: block">
          @endif 
        
          <p style="text-align: center;font-color:#000;font-size:16px;font-weight: bold;">  {{ $trainer_name }} 様     </p>
          
          @if(!is_favourite(Session::get('user.id'),$trainer_id))

              <form action="{{route('favouritetrainer')}}" method="post" >
                  {{ csrf_field() }}
                  <input type="hidden" name="user_id" value="{{ Session::get('user.id') }}">
                  <input type="hidden" name="trainer_id" value="{{ $schedule->trainer_id }}">
                  <button type="submit" class="btn border-round btn-primary btn-block" >お気に入りに追加   </button> 
              </form>


            @else 

            <form action="{{route('removeFavourite')}}" method="post" >
                  {{ csrf_field() }}
                  <input type="hidden" name="user_id" value="{{ Session::get('user.id') }}">
                  <input type="hidden" name="trainer_id" value="{{ $schedule->trainer_id }}">
                  <button type="submit" class="btn border-round btn-primary btn-block " > お気に入りリストから削除 </button> 
              </form>

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
            
            @if(isset($ratingsInput))
              @foreach($ratingsInput as $val)
                <div class="row mb-3">
                  <div class="col-3">
                    <label class="col-form-label float-right " style="font-size:1.3em;margin-top:10px;font-weight: bold"> {{ $val->name }} </label>
                  </div>

                  <div class="col-8">
                        <input type="text" class="js-range-slider" id="{{$val->id}}" name="ratings_{{ $val->id}}" value=""
                        data-min="0"
                        data-max="5"
                        data-from="{{ $ratings ? (evaluationValue($ratings->id,$val->id)->input_ratings_value ?? 0) : 0 }}"
                        />

                       {{--  <input type="range" name="ageInputName" id="ageInputId" value="" min="1" max="5" oninput="ageOutputId.value = ageInputId.value">
                        <output name="ageOutputName" id="ageOutputId"></output> --}}

       
                  </div>
                </div>
              @endforeach
            @endif


            <div class="row " style="text-align: center;font-size:1.7em;">
                <div class="col">

                    <!-- Rating Stars Box -->
                    <div class='rating-stars text-center'>
                      <ul class='stars'>
                        <li class='star'  data-value='1'>
                          <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star'  data-value='2'>
                          <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star' data-value='3'>
                          <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star'  data-value='4'>
                          <i class='fa fa-star fa-fw'></i>
                        </li>
                        <li class='star'  data-value='5'>
                          <i class='fa fa-star fa-fw'></i>
                        </li>
                      </ul>
                    </div>
                  <span style="font-size: 18px;"> ズバリ評価は</span>
                          &nbsp;
                    
                       
                    {{-- <div class="stars-outer">
                      <div class="stars-inner"></div>
                    </div> --}}

                </div>
            </div>
            <div class="row " style="text-align: center;font-size:1.7em;">
                <div class="col">

                  <span style="font-size: 18px;"> 星</span>
                       <input type="text" id="total" name="total" value="{{ $ratings->star_ratings ?? 0}}" style="text-align:center; width:50px" readonly disabled="true" />
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

   /* default ratings value */
   if(parseInt($("#total").val()) > 0){
        var stars = $('li.star');

      for (i = 0; i < parseInt($("#total").val()); i++) {
        $(stars[i]).addClass('selected');
      }
   }   
  /* 1. Visualizing things on Hover - See next part for action on click */
  $('.stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  
  /* 2. Action to perform on click */
  $('.stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('.stars li.selected').last().data('value'), 10);
    $("#total").val(ratingValue);

    // responseMessage(msg);
    
  });
  
  
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
      };

      $(".js-range-slider").ionRangeSlider({
        min: 0,
        max: 5,
        from: 0,
        skin:'big',
        onStart: function (data) {
            if(data.from == 0){
              $(".irs-single").hide();
            }
            updateArray(data.input.attr('id'),$("input[name^="+data.input.attr('name')+"]").val());
          
        },
    
        onChange: function (data) {
            // console.log($("#"+data.input.attr('id')).val());

            if ($("#"+data.input.attr('id')).val() > 0){
                  $("#"+data.input.attr('id')).siblings('span').find('.irs-single').show();
            }else{
                  $("#"+data.input.attr('id')).siblings('span').find('.irs-single').hide();
            }
            // Called every time handle position is changed
            updateArray(data.input.attr('id'),$("input[name^="+data.input.attr('name')+"]").val());


        },
    
        onFinish: function (data) {
            // Called then action is done and mouse is released

            updateArray(data.input.attr('id'),$("input[name^="+data.input.attr('name')+"]").val());

            //   let total = Object.values(ratingsArray).reduce((t, n) => parseInt(t) + parseInt(n))
            //   setRatings(total);
            // console.log('On finish '+total);
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

                data: { 'data': ratingsArray,'star_ratings':$("#total").val(),'user_id':{{ $user_id}},'trainer_id':{{ $trainer_id}},'schedule_id': {{ $schedule->id}}  },
                cache: false,
                success: function(res) {
                      $('#loading').hide();
                      window.location.href = "{{ route('traineeCalendar.view') }}";


                },
                error:function(request, status, error) {
                      $('#loading').hide();

                   alert('エラーが発生しました。');
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
              alert('エラーが発生しました。');
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
            alert('エラーが発生しました。');
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