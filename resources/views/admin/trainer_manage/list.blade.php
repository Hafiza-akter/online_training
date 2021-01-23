@extends('admin/master')
@section('title','Trainer List')
@section('pageName','Trainer list')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    <div class="row">

                        <div class="col-sm-6">
                            <h3 class="card-title">Trainer List</h3>
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
                                <th>First Name</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>Phone</th>
                                <th>Photo</th>
                                <th>Unit Price</th>
                                <th>Certification</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1 @endphp
                            @foreach($trainerList as $trainer)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$trainer->first_name}}</td>
                                <td>{{$trainer->email}}</td>
                                <td>{{$trainer->city}}</td>
                                <td>{{$trainer->phone}}</td>
                                <td>
                                <img src="{{asset('asset_v2/img/user-thumb.jpg')}}" style="width:50px">
                                </td>
                                <td>{{$trainer->unit_price}}</td>
                                <td>{{$trainer->certification}}</td>
                                <td>
                                    <?php 
                                    if($trainer->status == 1){ ?>
                                        <input type="button"  readonly  class="btn btn-primary"  value=" Active ">
                                    <?php }else{?>
                                        <input type="button"  readonly  class="btn btn-warning"  value="Inactive">
                                  <?php  } ?>
                                </td>                                
                                <td>
                                    <a href="{{route('admin.trainer.edit',$trainer->id)}}" class="pl-3 pr-3"><i class="fas fa-edit"></i></a>
                                </td>

                            </tr>
                            @endforeach


                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#sl</th>
                                <th>First Name</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>Phone</th>
                                <th>Photo</th>
                                <th>Unit Price</th>
                                <th>Certification</th>
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