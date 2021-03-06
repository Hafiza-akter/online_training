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
                                <th>Instrument</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($trainerSchedule as $schedule )
                           
                            <tr>
                                <td>{{$schedule->date}}</td>
                                <td>{{$schedule->time}}</td>
                                <td>{{$schedule->getUser->name}}</td>
                                <td>{{$schedule->getTrainer->first_name}}</td>
                                <td>1.8</td>
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