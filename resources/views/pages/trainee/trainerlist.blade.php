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
                        <a href="#" class="btn btn-md  btn-outline {{ isset($request) && $request->favourite == 1 ? 'btn-primary' : 'btn-border' }}" onclick="$('#favourite').val(1);$('#dateform').submit();"> 私のお気に入り </a>
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

        <div class="row text-center">
            @foreach($trainerList as $val)
                <div class="col-md-4">
                    <div class="card m-2">
                        <a href="{{ route('trainerDetails',$val->id)}} ">
                      <div class="card-body">
                         @if($val->photo_path != NULL)
                        <img class=""  src="{{asset('images').'/'.$val->photo_path}}"  style="width:250px;height: 200px">
                    @else 
                         <img class="" src="{{asset('images/user-thumb.jpg')}}"   style="width:250px;height: 200px">

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

</section>
@endsection
@section('footer_css_js')

<script>

</script>
@endsection
