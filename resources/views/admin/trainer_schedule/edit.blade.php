@extends('admin/master')
@section('title','Edit Schedule')
@section('pageName','Edit Schedule')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="card-title">Edit Schedule</h3>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{route('admin.schedule.management.view')}}" class="text-right"><i class="fa fas fa-list"></i> list</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <?php $dd = substr($schedule->date, 0, 10); ?>
                <div class="card-body">

                    @if(Session::has('message'))
                    <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
                    @endif
                    <form role="form" method="post" action="{{route('admin.schedule.management.edit.submit')}}">
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
                                            @if(Session::has('message'))
                                            <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
                                            @endif
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
                                                <label>Date:</label>
                                                <input type="date" id="myDate" name="date" value="{{$dd}}" class="form-control">

                                            </div>
                                            <div class="form-group">
                                                <label>Date:</label>
                                                <input type="time" id="myTime" value="{{$schedule->time}}" name="time" class="form-control">

                                            </div>
                                            <div class="form-group">
                                                <label>User:</label>
                                                <select name="user" class="form-control">
                                                    @foreach($users as $user)
                                                    <option {{($user->id == $schedule->user_id ) ? 'selected': ''}} value="{{$user->id}}">{{$user->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Trainer:</label>
                                                <select name="trainer" class="form-control">
                                                    @foreach($trainers as $trainer)
                                                    <option {{($trainer->id == $schedule->trainer_id ) ? 'selected': ''}} value="{{$trainer->id}}">{{$trainer->first_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Course:</label>
                                                <select name="course[]" class="form-control select2" multiple="multiple">
                                                    <option value="">Select Course</option>
                                                    @foreach($courses as $course)
                                                    <option {{(in_array($course->id, $prev_courses) ) ? 'selected': ''}} value="{{$course->id}}">{{$course->course_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <input value="{{$schedule->id}}" type="hidden" name="id">



                                        </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">Submit</button>
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