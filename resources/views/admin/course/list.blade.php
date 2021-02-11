@extends('admin/master')
@section('title','course List')
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
                            <h3 class="card-title">Course List</h3>
                        </div>
                        <div class="col-sm-6 text-right"><a href="{{route('course.add')}}"><i class="fas fa-plus"></i> Add</a></div>

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
                                <th>Course Name</th>
                                <th>Course Type</th>
                                <th>Equipment</th>
                                <th>Set 1</th>
                                <th>Set 2</th>
                                <th>Set 3</th>
                                <!-- <th>Certification</th> -->
                                <th>Summary</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1 @endphp
                            @foreach($courseList as $course)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$course->course_name}}</td>
                                <td>{{$course->course_type}}</td>
                                <td>{{$course->getEquipment->name}}</td>
                                <td>{{$course->set_1}}</td>
                                <td>{{$course->set_2}}</td>
                                <td>{{$course->set_3}}</td>
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
                                <th>Course Name</th>
                                <th>Course Type</th>
                                <th>Equipment</th>
                                <th>Set 1</th>
                                <th>Set 2</th>
                                <th>Set 3</th>
                                <!-- <th>Certification</th> -->
                                <th>Summary</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
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