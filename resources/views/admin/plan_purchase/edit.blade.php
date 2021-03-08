@extends('admin/master')
@section('title','Edit Trainer')
@section('pageName','Edit Trainer')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="card-title">Edit Trainer</h3>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{route('purchase.plan.list')}}" class="text-right"><i class="fa fas fa-list"></i> list</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    
                    @if(Session::has('message'))
                    <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
                    @endif
                    <form role="form" method="post" action="{{route('purchase.plan.edit.submit')}}">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-sm">
                                <div class="card card-primary">

                                    <!-- form start -->
                                    <form role="form">
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
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Name</label>
                                                <input value="{{$plan->name}}" required type="text" class="form-control" name="name" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Objective</label><br>
                                                <select class="custom-select mr-sm-2" name="objective">
                                                    <option value="weight_loss" {{ ($plan->objective == 'weight_loss')? 'selected' :''}}>Weight loss</option>
                                                    <option value="weight_gain" {{ ($plan->objective == 'weight_gain')? 'selected' :''}}>Weight gain</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Times Per Week</label>
                                                <input value="{{$plan->times_per_week}}" required type="number" class="form-control" name="times_per_week" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Cost Per Month</label>
                                                <input value="{{$plan->cost_per_month}}" required type="number" class="form-control" name="cost_per_month" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Percentage 1 Month</label>
                                                <input value="{{$plan->percentage_1mo}}" type="number" class="form-control" name="percentage_1mo" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Percentage 3 Month</label>
                                                <input value="{{$plan->percentage_3mo}}" type="number" class="form-control" name="percentage_3mo" placeholder="Enter ...">
                                            </div>
                                            <input value="{{$plan->id}}" type="hidden" name="id">
                                           

                                           
                     
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Status</label><br>
                                                <input type="checkbox" {{ ($plan->status ==1)? 'checked' :''}} name="status" class="form-control" data-toggle="toggle" data-on="Active" data-off="Inactive">
                                                <!-- <input type="checkbox" id="toggle-two"> -->
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