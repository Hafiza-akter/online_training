@extends('admin/master')
@section('title','Admin List')
@section('pageName','Admin list')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                <div class="row">
                
                <div class="col-sm-6"><h3 class="card-title">Admin List</h3></div>
                <div class="col-sm-6 text-right"><a href="{{route('admin.add')}}"><i class="fas fa-plus"></i> Add</a></div>
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
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1 @endphp
                            @foreach($userData as $user)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->role}}</td>
                               
                                <td>
                                    <?php 
                                  if($user->status == 1){ ?>
                                    <span class="span-info ml-2">Active</span>
                                    <?php }else{?>
                                        <span class="span-warning ml-2">Inactive</span>
                                   <?php } ?>
                                </td>
                                <td>
                                    <a href="{{route('admin.edit',$user->id)}}" class="pl-3 pr-3"><i class="fas fa-edit"></i></a>
                                    <!-- <a href="{{-- route('admin.equipment.delete',$user->id) --}}" ><i class="fas fa-trash"></i></a> -->
                                </td>
                            </tr>
                            @endforeach


                        </tbody>
                        <tfoot>
                        <tr>
                                <th>#sl</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
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