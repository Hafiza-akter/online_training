@extends('admin/master')
@section('title','Equipment')
@section('pageName','Equipment list')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                <div class="row">
                
                <div class="col-sm-6"><h3 class="card-title">Equipment List</h3></div>
                <div class="col-sm-6 text-right"><a href="{{route('admin.equipment.add')}}"><i class="fas fa-plus"></i> Add</a></div>
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
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1 @endphp
                            @foreach($equipmentList as $equipment)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$equipment->name}}</td>
                                <td>
                                    <?php 
                                    if($equipment->status == 1){ ?>
                                        <input type="button"  readonly  class="btn btn-primary"  value=" Active ">
                                    <?php }else{?>
                                        <input type="button"  readonly  class="btn btn-warning"  value="Inactive">
                                  <?php  } ?>
                                </td>
                                <td>
                                    <a href="{{route('admin.equipment.edit',$equipment->id)}}" class="pl-3 pr-3"><i class="fas fa-edit"></i></a>
                                    <!-- <a href="{{-- route('admin.equipment.delete',$equipment->id) --}}" ><i class="fas fa-trash"></i></a> -->
                                </td>
                            </tr>
                            @endforeach


                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#sl</th>
                                <th>Name</th>
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