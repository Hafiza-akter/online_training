@extends('auth/master')
@section('title','trainer signup')
@section('content')
<div class="row pb-5">
      <h2 class="mx-auto">オンラー<br>(ニングマ)</h2>
    </div>
    
    <div class="offset-sm-2 col-sm-8 mb-4">
         <form action="{{route('traineeSignup.submit')}}" method="post">
    {{ csrf_field() }}
      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label">ニングマ</label>
        </div>
        <div class="col-8">
          <input type="text" name="name" class="form-control">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label">ニングマ</label>
        </div>
        <div class="col-8">
          <input type="text" name="phonetic" class="form-control">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label">ニングマ</label>
        </div>
        <div class="col-8">
          <input type="email" name="email" class="form-control">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label">ニングマ</label>
        </div>
        <div class="col-8">
          <input type="password" name="password" class="form-control">
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label">ニングマ</label>
        </div>
        <div class="col-8">
          <input type="text" name="address" class="form-control">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label">ニングマ</label>
        </div>
        <div class="col-8">
          <input type="text" name="phone" class="form-control">
        </div>
      </div>

    
      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label">ニングマ</label>
        </div>
        <div class="col-8">
          <input type="text" name="weight" class="form-control">
        </div>
      </div>
      <div class="row pt-3 pb-3">
        <h2 class="mx-auto">ングマ</h2>
      </div>
    

       <!-- <div class="row pt-3 pb-3">
        <h2 class="mx-auto">ングマ</h2>
      </div>
      <div class="row pt-3 pb-3">
        <textarea name="" class="form-control text-center" id="" placeholder="オンラニングマオンラニングマ" rows="5"></textarea>
      </div> -->
      
     <!-- <div class="row pt-3 pb-3">
        <h2 class="mx-auto">オオマ</h2>
      </div>

      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label">ニングマ</label>
        </div>
        <div class="col-8">
          <input type="text" name="" class="form-control">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label">ニングマ</label>
        </div>
        <div class="col-8">
          <input type="text" name="" class="form-control">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label">ニングマ</label>
        </div>
        <div class="col-8">
          <input type="text" name="" class="form-control">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-4">
          <label class="col-form-label">ニングマ</label>
        </div>
        <div class="col-8">
          <input type="text" name="" class="form-control">
        </div>
      </div> -->

      <div class="row pt-3 pb-3">
      <button type="submit" class="mx-auto btn btn-secondary text-white btn-lg">オンラグマ</button>
      </div>
      
         </form>

    </div>


    <div class="row"></div>
  </div>

@endsection