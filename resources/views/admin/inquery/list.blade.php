@extends('admin/master')
@section('title','Inquery List')
@section('pageName','Inquery list')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    <div class="row">

                        <div class="col-sm-6">
                            <h3 class="card-title">Inquery List</h3>
                        </div>
                        <div class="col-sm-6 text-right"></div>
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Title</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1 @endphp
                            @foreach($inqueryList as $inquery)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$inquery->name}}</td>
                                <td>{{$inquery->email}}</td>
                                <td>{{$inquery->title}}</td>
                                <td>{{$inquery->message}}</td>
                            </tr>
                            @endforeach


                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#sl</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Title</th>
                                <th>Message</th>
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