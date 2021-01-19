@extends('admin/master')
@section('title','Add Admin')
@section('pageName','Add Admin')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card card-warning">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="card-title">Add New Admin</h3>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{route('admin.list')}}" class="text-right"><i class="fa fas fa-list"></i> list</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
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
                    <form role="form" method="post" action="{{route('admin.add.submit')}}">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-sm">
                                <div class="card card-primary">

                                    <!-- form start -->
                                    <form role="form">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email</label>
                                                <input required type="text" class="form-control" name="email" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Role</label>
                                                <input required type="text" class="form-control" name="role" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Password</label>
                                                <input required type="password" class="form-control" name="password" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Status</label><br>
                                                <input type="checkbox" name="status" class="form-control" data-toggle="toggle" data-on="Active" data-off="Inactive">
                                                <!-- <input required type="checkbox" id="toggle-two"> -->
                                            </div>

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