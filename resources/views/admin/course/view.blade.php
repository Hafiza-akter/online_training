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
                            <h3 class="card-title">Course Details <?php
                                                                    if ($course->status == 1) { ?>
                                    <span class="span-info ml-2">Active</span>
                                <?php } else { ?>
                                    <span class="span-warning ml-2">Inactive</span>
                                <?php } ?>
                            </h3>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{route('course.list')}}" class="text-right"><i class="fa fas fa-list"></i> list</a>
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
                                            <label for="exampleInputEmail1">Course Name</label>
                                            <input type="text" class="form-control" value="{{$course->course_name}}" name="course_name" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Course Type</label><br>
                                            <input type="text" class="form-control" value="{{$course->course_type}}" name="course_name" readonly>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Equipment</label>
                                            <input type="text" class="form-control" name="set_1" value="{{$course->getEquipment->name}}" readonly>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Set 1</label>
                                            <input type="number" class="form-control" name="set_1" value="{{$course->set_1}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Set 2</label>
                                            <input type="number" class="form-control" name="set_2" value="{{$course->set_2}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Set 3</label>
                                            <input type="number" class="form-control" name="set_3" value="{{$course->set_3}}" readonly>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Summary</label>
                                            <input type="text" class="form-control" name="summary" value="{{$course->summary}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Reference URL</label>
                                            <input type="text" class="form-control" name="reference_url" value="{{$course->reference_url}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Mets</label>
                                            <input type="text" class="form-control" value="{{$course->mets}}" name="mets" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Main</label>
                                            <input type="text" class="form-control" value="{{$course->main}}" name="main" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Sub</label>
                                            <input type="text" class="form-control" name="sub" value="{{$course->sub}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Motion</label>
                                            <input type="text" class="form-control" name="motion" value="{{$course->motion}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Way</label>
                                            <input type="text" class="form-control" name="way" value="{{$course->way}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Session Time</label>
                                            <input type="number" class="form-control" name="session_time" value="{{$course->session_time}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Status</label>
                                            <?php
                                            if ($course->status == 1) { ?>
                                                <span class="span-info ml-2">Active</span>
                                            <?php } else { ?>
                                                <span class="span-warning ml-2">Inactive</span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Image</label>
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