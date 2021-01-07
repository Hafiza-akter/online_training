 <div class="row pb-5">
 	{{-- schedule --}}
  <h2 class="mx-auto">トレーナーページ </h2> 
</div>
<div class="row pb-3">
  <div class="col-sm border-round">
  	 	{{-- schedule --}}
    <a class="btn" href="{{ route('trainerCalendar.view')}}">スケジュール</a>       
  </div>
  <div class="col-sm border-round">
    <a class="btn">進捗 </a>       
  </div>
  <div class="col-sm border-round">
    <a class="btn">個人設定</a>       
  </div>

</div>
<div class="row mb-5">
  <div class="offset-sm-4 col-sm-4 border-round">
    <a class="btn">スケジュール</a>  

    <a class="btn" href="{{ route('trainerLogout')}}"> <i class="fas fa-sign-out-alt"></i></span> 
    </a>
  </div>
</div>