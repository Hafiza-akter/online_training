@extends('admin/master')
@section('title','Training History')
@section('pageName','Training History')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    <div class="row">

                        <div class="col-sm-6">
                            <h3 class="card-title">Training History</h3>
                        </div>

                        <div class="col-sm-6 text-right">
                            <a href="{{route('user.training.history.download',$user_id)}}" class="text-right"><i class="fas fa-cloud-download-alt"></i> Download CSV</a>
                        </div>
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
                                <th>User Id</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Course</th>
                                <th>Item</th>
                                <th>Set 1</th>
                                <th>Set 2</th>
                                <th>Set 3</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1 @endphp
                            @foreach($trainings as $training)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$training->user_id}}</td>
                                <td>{{$training->date}}</td>
                                <td>{{$training->time}}</td>
                                <td>{{$training->course_name}}</td>
                                <td>{{$training->item}}</td>
                                <td>{{$training->set_1}}</td>
                                <td>{{$training->set_2}}</td>
                                <td>{{$training->set_3}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#sl</th>
                                <th>User Id</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Course</th>
                                <th>Item</th>
                                <th>Set 1</th>
                                <th>Set 2</th>
                                <th>Set 3</th>
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