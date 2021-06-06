@extends('master_dashboard')
@section('title','trainee trainerlist')
@section('header_css_js')
<style>
.imgd{

    background: #fff;
    margin: 10px;
    padding: 6px;
    -moz-box-shadow:2px 21px 21px 10px rgba(0,0,0,0.08); 
    -webkit-box-shadow: 2px 21px 21px 10px rgba(0,0,0,0.08); 
    box-shadow: 2px 21px 21px 10px rgba(0,0,0,0.08);
}
.btn-border{
    border: 1px solid #000;
}
</style>

@endsection
@section('content')

      {{-- @include('pages.trainee.dashboard') --}}

<section class="review_part gray_bg section_padding">
      <div class="container col-md-12  my-4">

        <div class="card m-1" >
            <!-- Card header --> 
            <div class="card-body ">
            <form action="{{route('trainerlist')}}" method="post" id="dateform">
                          {{ csrf_field() }}
                         
            <div class="row mb-3 text-left">
               
                    <div class="col-5">
                        <label class="col-form-label interface" style="font-size: 20px;font-weight: bold;"> - 性別 - </label>
                        <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" style="transform: scale(1.5)" type="radio" id="inlineCheckbox_3" name="sex" value="male" {{ isset($request) && $request->sex == 'male' ? 'checked' :''}} >
                            <label class="form-check-label" for="inlineCheckbox_3">男性</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" style="transform: scale(1.5)" type="radio" id="inlineCheckbox_4" name="sex" value="female" {{ isset($request) && $request->sex == 'female' ? 'checked' :''}} >
                            <label class="form-check-label" for="inlineCheckbox_4">女性</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" style="transform: scale(1.5)" type="radio" id="inlineCheckbox_5" name="sex" value="both" {{ isset($request) && $request->sex == 'both' ? 'checked' :''}}>
                            <label class="form-check-label" for="inlineCheckbox_5">どちらでも良い</label>
                        </div>                
                    </div>

                    <div class="col-5">
                        <label class="col-form-label interface" style="font-size: 20px;font-weight: bold;"> - 指導分野 - </label>
                        <br>
                        @php 
                            $instructions = \App\Model\TrainerSetupData::where('type','instruction')->where('status',1)->get()
                        @endphp
                        @if($instructions)
                        @foreach($instructions as $key=>$val)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" style="transform: scale(1.5)" type="checkbox" id="inlineCheckboxss_{{ $key }}" name="instructions[]" value="{{ $val->name}}" {{ isset($request->instructions) && in_array($val->name,$request->instructions ) ? 'checked' :''}}>
                            <label class="form-check-label" for="inlineCheckboxss_{{ $key }}"> {{$val->name }}</label>
                        </div>
                        @endforeach
                        @endif
                            
                    </div>
                    <div class="col-md-2">
                        <input type="hidden" name="favourite" id="favourite">
                        <a href="#" class="btn btn-md  btn-outline {{ isset($request) && $request->favourite == 1 ? 'btn-primary' : 'btn-border' }}" id="button_clicked"> 私のお気に入り </a>
                    </div>
                        
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                            <button type="submit" class="btn btn-md btn-secondary"> トレーナーを検索する</button>

                    </div>
                </div>
               </form>
            </div>
             
        </div>

    </div>

    <div class="container  my-4 p-4" >

        <div class="col-md-12 col-sm-12 mb-4" style="overflow: overlay;margin:0px !important;"  id="meran" >

            <div class="row   text-center " id="{{ isset($request) && $request->favourite == 1 ? 'sortable' : '' }}">
                
                @foreach($trainerList as $key=>$val)
                    <div class=" col-md-4 col-lg-3 col-xl-3 ui-state-default" id="{{ $val->id}}">
                        <div class="card m-2">
                            <a href="{{ route('trainerDetails',$val->id)}} ">
                          <div class="card-body cd" >

                            @if(isset($request) && $request->favourite == 1 )
                                <i class="fas fa-box{{ $val->id }} fa-2x"  id="icon_fav"  style="position:absolute;color:red;top:5px;left:5px;font-size: 20px;">{{$key+1}} </i>
                            @endif

                             @if(is_favourite(Session::get('user.id'),$val->id))
                                <i class="fas fa-heart fa-2x"  id="icon_fav"  style="position:absolute;color:red;top:5px;right:5px;font-size: 20px;"></i>
                              @endif
                             @if($val->photo_path != NULL)
                            <img class=""  src="{{asset('images').'/'.$val->photo_path}}"  style="width:200px;height: 200px">
                        @else 
                             <img class="" src="{{asset('images/user-thumb.jpg')}}"   style="width:200px;height: 200px">

                        @endif 
                            <h5 class="card-title">{{ $val->first_name ?? '  ' }}</h5>
                            <h5 class="card-title">【 指導分野 】</h5>
                            @php 
                                $arr=unserialize($val->instructions);
                                $string="";
                                if(!empty($arr)){
                                  $string = implode('<span class="p-2"> / </span>',$arr);
                                }
                            @endphp
                              <h4 style="color:#c30f23">{!! $string ?? '&nbsp;' !!}</h4>
                           
                          </div>
                      </a>
                        </div>

                                     
                    </div>
            @endforeach
            </div>

        </div>
    </div>

</section>
@endsection
@section('footer_css_js')
  {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> --}}
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
{{-- <script src="jquery.ui.touch-punch.min.js"></script> --}}
<script src="{{ asset('asset_v2/js/jquery.ui.touch-punch.min.js')}}"></script>


<script>
    
    $( function() {

    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();

        $( "#sortable" ).sortable({
             // axis: "x",
             // revert:true,
             cursor: "move",
        containmentWith: "#meran",
        dropOnEmpty: true,
      
        update: function(event, ui) {
          var itemOrder = $('#sortable').sortable("toArray");
          for (var i = 0; i < itemOrder.length; i++) {
            $(".fa-box"+itemOrder[i]).html('');
            $(".fa-box"+itemOrder[i]).html(i+1);
            console.log("Position: " + i + " ID: " + itemOrder[i]);
          }

          $.ajax({
              type: "POST",
              url: '{{ route('favouritesorting')}}',
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },

              data: { 'order_list': itemOrder,'user_id':{{Session::get('user.id')}}  },
              cache: false,
              success: function(res) {
             
                     // wait(3000);

                     // location.reload();

                 
              },
              error:function(request, status, error) {
                    alert('エラーが発生しました。');
                  console.log("ajax call went wrong:" + request.responseText);
              }
           });

            
        }
      });
        // $('#sortable').draggable();
        // $("#sortable").disableSelection();

    });

     $("#button_clicked").click(function(){
        if($(this).hasClass('btn-primary')){
            $('#favourite').val('');
            $('#dateform').submit();
            $(this).removeClass('btn-primary');
            $(this).addClass('btn-border');
        }else{
            $(this).removeClass('btn-border');
            $(this).addClass('btn-primary');
            $('#favourite').val(1);
            $('#dateform').submit();
        }
     });

</script>
@endsection
