@extends('admin/master')
@section('title','スケジュール管理')
@section('pageName','Schedule Management')

@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">スケジュール管理</h3>
                </div>
                <div class="card-header">
                    <form class="form-inline" method="post" action="{{route('admin.schedule.management.search.submit')}}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label>Date:</label>
                            <input type="date" id="myDate" name="date" value="{{(session()->get('date'))? session()->get('date'):''}}" class="form-control mr-5">
                        </div>
                        <div class="form-group">
                            <label class="ml-5">Time:</label>
                            <input type="time" id="time" name="time" value="{{(session()->get('time'))? session()->get('time'):''}}" class="form-control ">

                        </div>
                        <button type="submit" class="ml-3 btn btn-sm btn-info "> <i class="fas fa fa-angle-right"></i> Go</button>
                        <a href="{{route('admin.schedule.management.view')}}" class="ml-3 btn btn-sm btn-info "><i class="fas fa-list"></i> List All</a>
                    </form>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl.</th>
                                <th>日付</th>
                                <th>時間</th>
                                <th>ユーザー名</th>
                                <th>トレーナー名</th>
                                <th>コース名</th>
                                <th>詳細</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                            @foreach($trainerSchedule as $schedule )

                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$schedule->date}}</td>
                                <td>{{$schedule->time}}</td>
                                <td>{{$schedule->user_id ? $schedule->getUser->name : ''}}</td>
                                <td>{{$schedule->getTrainer->first_name}}</td>
                                <?php
                                $course_name = getCourseName($schedule->id);
                                ?>
                                <td>{{$course_name}}</td>
                                <td>
                                    <a href="{{route('admin.schedule.management.edit',$schedule->id)}}" class="pl-3 pr-3"><i class="fas fa-edit"></i></a>
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
<script>
 $('#timehghjg').timepicker({
            timeFormat: 'hh:mm:ss tt',
            showSecond:true,
            ampm: true
    }); 
</script>
@endsection