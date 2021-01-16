@extends('admin/auth/master')
@section('title','admin login')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Login</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                @if(Session::has('message'))
                <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
                @endif
                <form class="form-horizontal" method="post" action="{{route('admin.Login.submit')}}">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="form-group row required">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" required class="form-control" name="username" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group row required">
                            <label for="inputPassword3" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" required class="form-control" name="password" placeholder="Password">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info login_admin btn-block mx-auto">Submit</button>

                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
            <!-- /.card -->
        </div>
    </div>
    <!-- /.row -->

</div><!-- /.container-fluid -->
@endsection