@extends('admin/master')
@section('title','ユーザー編集')
@section('pageName','Edit user')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="card-title">ユーザー編集</h3>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{route('user.list')}}" class="text-right"><i class="fa fas fa-list"></i> list</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    
                    @if(Session::has('message'))
                    <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
                    @endif
                    <form role="form" method="post" action="{{route('user.edit.submit')}}">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-sm">
                                <div class="card card-primary">

                                    <!-- form start -->
                                    <form role="form">
                                        <div class="card-body">
                                            @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @endif
                                            <div class="form-group">
                                                <label for="exampleInputEmail1"> 名前</label>
                                                <input value="{{$user->name}}" type="text" class="form-control" name="name" placeholder="Enter ...">
                                            </div>
                                            <input value="{{$user->id}}" type="hidden" name="id">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">フリガナ</label>
                                                <input value="{{$user->phonetic}}" type="text" class="form-control" name="phonetic" placeholder="Enter ...">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">メールアドレス</label>
                                                <input require value="{{$user->email}}" type="email" class="form-control" name="email" placeholder="Enter ...">
                                            </div>
                                           
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">住所</label>
                                                <input value="{{$user->address}}" type="text" class="form-control" name="address" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">身長</label>
                                                <input value="{{$user->length}}" type="text" class="form-control" name="length" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">性別</label><br>
                                                <select class="custom-select mr-sm-2" name="sex">
                                                    <option value="male" {{ ($user->sex == 'male')? 'selected' :''}}>Male</option>
                                                    <option value="female" {{ ($user->sex == 'female')? 'selected' :''}}>Female</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">体重</label>
                                                <input value="{{$user->weight}}" type="text" class="form-control" name="weight" placeholder="Enter ...">
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">ステータス</label><br>
                                                <input type="checkbox" {{ ($user->status ==1)? 'checked' :''}} name="status" class="form-control" data-toggle="toggle" data-on="Active" data-off="Inactive">
                                                <!-- <input type="checkbox" id="toggle-two"> -->
                                            </div>
                                        </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">送信</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <!-- /.row -->

</div><!-- /.container-fluid -->
@endsection