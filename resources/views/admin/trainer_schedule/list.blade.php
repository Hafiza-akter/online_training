@extends('admin/master')
@section('title','Schedule Management')
@section('pageName','Schedule Management')

@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Schedule Management</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>User</th>
                                <th>Trainer</th>
                                <th>Course</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($trainerSchedule as $schedule )
                           
                            <tr>
                                <td>{{$schedule->date}}</td>
                                <td>{{$schedule->time}}</td>
                                <td>{{$schedule->user_id ? $schedule->getUser->name : ''}}</td>
                                <td>{{$schedule->getTrainer->first_name}}</td>
                                <?php 
                                   $course_name= getCourseName($schedule->id);
                                ?>
                                <td>{{$course_name}}</td>
                                <td>
                                <a href="#" class="pl-3 pr-3"><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                         
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.row -->

</div><!-- /.container-fluid -->
@endsection