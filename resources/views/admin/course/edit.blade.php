@extends('admin/master')
@section('title','edit course')
@section('pageName','edit course')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="card-title">コース編集</h3>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{route('course.list')}}" class="text-right"><i class="fa fas fa-list"></i> リスト</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    
                    @if(Session::has('message'))
                    <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
                    @endif
                    <form role="form" method="post" action="{{route('course.edit.submit')}}" enctype="multipart/form-data">
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
                                                <label for="exampleInputEmail1">コース名</label>
                                                <input  type="text" class="form-control" value="{{$course->course_name}}" name="course_name" placeholder="Enter ...">
                                            </div>
                                            <input  type="hidden"  value="{{$course->id}}" name="course_id">

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">コースタイプ</label><br>
                                                <select class="custom-select mr-sm-2" name="course_type">
                                                    <option value="weight_loss" >体重減少</option>
                                                    <option value="weight_gain">体重増加</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">備品</label>
                                                <select class="custom-select mr-sm-2" name="equipment_id">
                                                @foreach($equipmentList as $equipment)
                                                    <option value="{{$equipment->id}}" >{{$equipment->name}}</option>
                                                @endforeach
                                                </select> 
                                                
                                             </div>
                                             <div class="form-group">
                                                <label for="exampleInputEmail1">画像</label>
                                                <input type="file"  name="image" accept="image/jpeg,image/png" class="form-control">
                                             </div>
                                             {{-- <div class="form-group">
                                                <label for="exampleInputEmail1">Set 1</label>
                                                <input  type="number" class="form-control" name="set_1" value="{{$course->set_1}}" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Set 2</label>
                                                <input  type="number" class="form-control" name="set_2" value="{{$course->set_2}}" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Set 3</label>
                                                <input  type="number" class="form-control" name="set_3" value="{{$course->set_3}}" placeholder="Enter ...">
                                            </div> --}}
                                            @php 
                                                $course1=$course->set_1;
                                                $kg1='';
                                                $times1='';
                                                if($course1 != null){
                                                    $arr1 = explode("_",$course1);
                                                    $kg1=$arr1[0];
                                                    $times1=$arr1[1];
                                                }
                                                $course2=$course->set_2;
                                                $kg2='';
                                                $times2='';
                                                if($course2 != null){
                                                    $arr2 = explode("_",$course2);
                                                    $kg2=$arr2[0];
                                                    $times2=$arr2[1];
                                                }
                                                $course3=$course->set_3;
                                                $kg3='';
                                                $times3='';
                                                if($course3 != null){
                                                    $arr2 = explode("_",$course3);
                                                    $kg3=$arr2[0];
                                                    $times3=$arr2[1];
                                                }
                                            @endphp
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Set 1</label>
                                                {{-- <input  type="number" class="form-control" name="set_1" placeholder="Enter ..."> --}}
                                                
                                                <input type="text"  name="set_1_kg" class="kg p-1 m-1" value="{{ $kg1}}" /><span>KG</span>
                                                <input  type="text" name="set_1_times" class="times kg p-1 m-1" value="{{ $times1}}"  /><span>回</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Set 2</label>
                                                {{-- <input  type="number" class="form-control" name="set_2" placeholder="Enter ..."> --}}
                                                <input type="text"  name="set_2_kg" class="kg p-1 m-1"  value="{{ $kg2}}" /><span>KG</span>
                                                <input  type="text" name="set_2_times" class="times kg p-1 m-1" value="{{ $times2}}"  /><span>回</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Set 3</label>
                                                {{-- <input  type="number" class="form-control" name="set_3" placeholder="Enter ..."> --}}
                                                <input type="text"  name="set_3_kg" class="kg p-1 m-1" value="{{ $kg3}}" /><span>KG</span>
                                                <input  type="text" name="set_3_times" class="times kg p-1 m-1"  value="{{ $times3}}" /><span>回</span>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">サマリ</label>
                                                <input  type="text" class="form-control" name="summary" value="{{$course->summary}}" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">参照URL</label>
                                                <input  type="text" class="form-control" name="reference_url" value="{{$course->reference_url}}" placeholder="Enter ...">
                                            </div>
 
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">メッツ</label>
                                                <input  type="text" class="form-control" value="{{$course->mets}}"  name="mets" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">メイン</label>
                                                <input  type="text" class="form-control" value="{{$course->main}}"  name="main" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">サブ</label>
                                                <input  type="text" class="form-control" name="sub" value="{{$course->sub}}"  placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">モーション</label>
                                                <input  type="text" class="form-control" name="motion" value="{{$course->motion}}"  placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">方法</label>
                                                <input  type="text" class="form-control" name="way" value="{{$course->way}}"  placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">ステータス</label><br>
                                                <input type="checkbox" {{( $course->status  ==1)? 'checked' :''}} name="status" class="form-control" data-toggle="toggle" data-on="Active" data-off="Inactive">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">セッション時間</label>
                                                <input  type="number" class="form-control" name="session_time" value="{{$course->session_time}}"  placeholder="Enter ...">
                                            </div>
                                        </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">送信する</button>
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