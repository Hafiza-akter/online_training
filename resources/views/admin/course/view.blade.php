@extends('admin/master')
@section('title','View course')
@section('pageName','View course')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="card-title">コース詳細 <?php
                                                                    if ($course->status == 1) { ?>
                                    <span class="span-info ml-2">アクティブ</span>
                                <?php } else { ?>
                                    <span class="span-warning ml-2">非アクティブ</span>
                                <?php } ?>
                            </h3>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{route('course.list')}}" class="text-right"><i class="fa fas fa-list"></i> リスト</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <div class="card card-primary">
                            
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">コース名</label>
                                            <input type="text" class="form-control" value="{{$course->course_name}}" name="course_name" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">コースタイプ</label><br>
                                            <input type="text" class="form-control" value="{{$course->course_type}}" name="course_name" readonly>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">備品</label>
                                            <input type="text" class="form-control" name="set_1" value="{{$course->getEquipment->name}}" readonly>

                                        </div>
                                    </div>
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
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Set 1</label>
 
                                        <input type="text"  name="set_1_kg" readonly="readonly" class="kg p-1 m-1" value="{{ $kg1}}" /><span>KG</span>
                                        <input  type="text" name="set_1_times" readonly="readonly" class="times kg p-1 m-1" value="{{ $times1}}"  /><span>回</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Set 2</label>
                                        {{-- <input  type="number" class="form-control" name="set_2" placeholder="Enter ..."> --}}
                                        <input type="text"  name="set_2_kg" class="kg p-1 m-1"  value="{{ $kg2}}" /><span>KG</span>
                                        <input  type="text" name="set_2_times" readonly="readonly" class="times kg p-1 m-1" value="{{ $times2}}"  /><span>回</span>
                                    </div>
                                    </div>
                                    <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Set 3</label>
                                        {{-- <input  type="number" class="form-control" name="set_3" placeholder="Enter ..."> --}}
                                        <input type="text"  name="set_3_kg" class="kg p-1 m-1" value="{{ $kg3}}" /><span>KG</span>
                                        <input  type="text" name="set_3_times" readonly="readonly" class="times kg p-1 m-1"  value="{{ $times3}}" /><span>回</span>
                                    </div>
                                    </div>

                                </div>
                            
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">サマリ</label>
                                            <input type="text" class="form-control" name="summary" value="{{$course->summary}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">参照URL</label>
                                            <input type="text" class="form-control" name="reference_url" value="{{$course->reference_url}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">メッツ</label>
                                            <input type="text" class="form-control" value="{{$course->mets}}" name="mets" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">メイン</label>
                                            <input type="text" class="form-control" value="{{$course->main}}" name="main" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">サブ</label>
                                            <input type="text" class="form-control" name="sub" value="{{$course->sub}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">モーション</label>
                                            <input type="text" class="form-control" name="motion" value="{{$course->motion}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">方法</label>
                                            <input type="text" class="form-control" name="way" value="{{$course->way}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">セッション時間</label>
                                            <input type="number" class="form-control" name="session_time" value="{{$course->session_time}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">ステータス</label>
                                            <?php
                                            if ($course->status == 1) { ?>
                                                <span class="span-info ml-2">アクティブ</span>
                                            <?php } else { ?>
                                                <span class="span-warning ml-2">非アクティブ</span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">画像</label>
                                            <?php if($course->image_path != ''){ ?>
                                                <img style="width:100px" src="{{asset('images').'/'.$course->image_path}}" />
                                           <?php }else{?>
                                               
                                               N/A
                                               <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
    <!-- /.row -->

</div><!-- /.container-fluid -->
@endsection