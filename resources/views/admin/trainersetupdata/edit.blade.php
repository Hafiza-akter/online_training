@extends('admin/master')
@section('title','Edit Setup data')
@section('pageName','Edit Setup data')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="card-title">Edit Trainer setup input</h3>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{route('admin.trainersetupdata')}}" class="text-right"><i class="fa fas fa-list"></i> list</a>
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
                    <form role="form" method="post" action="{{route('admin.trainersetupdata.edit.submit')}}">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-sm">
                                <div class="card card-primary">

                                    <!-- form start -->
                                    <form role="form">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Name</label>
                                                <input type="text" class="form-control" value="{{$data->name}}" name="name" placeholder="Enter ...">
                                                <input type="hidden" value="{{$data->id}}" name="id" >
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Status</label><br>
                                                <input type="checkbox" {{( $data->status  ==1)? 'checked' :''}} name="status" class="form-control" data-toggle="toggle" data-on="Active" data-off="Inactive">

                                            </div>

                                        </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary">送信</button>
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