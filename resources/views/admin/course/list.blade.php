@extends('admin/master')
@section('title','コース一覧')
@section('pageName','course list')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    <div class="row">

                        <div class="col-sm-6">
                            <h3 class="card-title">コース一覧</h3>
                        </div>
                        <div class="col-sm-6 text-right"><a href="{{route('course.add')}}"><i class="fas fa-plus"></i> 追加</a></div>

                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    @if(Session::has('message'))
                    <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#sl</th>
                                <th>コース名</th>
                                <th>コースタイプ</th>
                                <th>設備</th>
                                <th>Set 1</th>
                                <th>Set 2</th>
                                <th>Set 3</th>
                                <!-- <th>Certification</th> -->
                                <th>サマリ</th>
                                <th>画像</th>
                                <th>ステータス</th>
                                <th>詳細</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1 @endphp
                            @foreach($courseList as $course)
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
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$course->course_name}}</td>
                                <td>{{$course->course_type}}</td>
                                <td>{{$course->getEquipment->name}}</td>
                                <td>{{$kg1." KG, ".$times1." Times"}}</td>
                                <td>{{$kg2." KG, ".$times2." Times"}}</td>
                                <td>{{$kg3." KG, ".$times3." Times"}}</td>
                                <td>{{$course->summary}}</td>
                                <td>
                                    <?php if ($course->image_path != '') { ?>
                                        <img src="{{asset('images').'/'.$course->image_path}}" style="width:50px">
                                    <?php } else { ?>

                                        N/A
                                    <?php } ?>
                                </td>

                                <td>
                                    <?php
                                    if ($course->status == 1) { ?>
                                        <input type="button" readonly class="btn btn-primary" value=" Active ">
                                    <?php } else { ?>
                                        <input type="button" readonly class="btn btn-warning" value="Inactive">
                                    <?php  } ?>
                                </td>
                                <td>
                                    <a href="{{route('course.edit',$course->id)}}" class="pl-3 pr-3"><i class="fas fa-edit"></i></a>
                                    <a href="{{route('course.view',$course->id)}}" class="pl-3 pr-3"><i class="fas fa-eye"></i></a>
                                </td>

                            </tr>
                            @endforeach


                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#sl</th>
                                <th>コース名</th>
                                <th>コースタイプ</th>
                                <th>設備</th>
                                <th>Set 1</th>
                                <th>Set 2</th>
                                <th>Set 3</th>
                                <!-- <th>Certification</th> -->
                                <th>サマリ</th>
                                <th>画像</th>
                                <th>ステータス</th>
                                <th>詳細</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.row -->

    </div><!-- /.container-fluid -->


    @endsection