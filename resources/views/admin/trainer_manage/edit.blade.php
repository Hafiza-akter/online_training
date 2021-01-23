@extends('admin/master')
@section('title','Edit Trainer')
@section('pageName','Edit Trainer')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card card-warning">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="card-title">Edit Trainer</h3>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{route('trainer.list')}}" class="text-right"><i class="fa fas fa-list"></i> list</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    
                    @if(Session::has('message'))
                    <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
                    @endif
                    <form role="form" method="post" action="{{route('trainer.edit.submit')}}">
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
                                                <label for="exampleInputEmail1">First Name</label>
                                                <input value="{{$trainer->first_name}}" type="text" class="form-control" name="first_name" placeholder="Enter ...">
                                            </div>
                                            <input value="{{$trainer->id}}" type="hidden" name="id">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">First Phonetic</label>
                                                <input value="{{$trainer->first_phonetic}}" type="text" class="form-control" name="first_phonetic" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Family Name</label>
                                                <input value="{{$trainer->family_name}}" type="text" class="form-control" name="family_name" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Email</label>
                                                <input require value="{{$trainer->email}}" type="email" class="form-control" name="email" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Prefecture</label>
                                                <input value="{{$trainer->prefecture}}" type="text" class="form-control" name="prefecture" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">City</label>
                                                <input value="{{$trainer->city}}" type="text" class="form-control" name="city" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Address</label>
                                                <input value="{{$trainer->address_line}}" type="text" class="form-control" name="address_line" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Zipcode</label>
                                                <input value="{{$trainer->zip_code}}" type="text" class="form-control" name="zip_code" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Intro</label>
                                                <textarea class="form-control" name="intro" placeholder="Enter ..."></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Unit Price</label>
                                                <input required value="{{$trainer->unit_price}}" type="text" class="form-control" name="unit_price" placeholder="Enter ...">
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">interface</label><br>
                                                <select class="custom-select mr-sm-2" name="interface">
                                                    <option value="pc" {{ ($trainer->interface == 'pc')? 'selected' :''}}>PC</option>
                                                    <option value="smartphone" {{ ($trainer->interface == 'smartphone')? 'selected' :''}}>Smartphone</option>
                                                    <option value="tablet" {{ ($trainer->interface == 'tablet')? 'selected' :''}}>Tablet</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Certification</label>
                                                <input value="{{$trainer->certification}}" type="text" class="form-control" name="certification" placeholder="Enter ...">
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Status</label><br>
                                                <input type="checkbox" {{ ($trainer->status ==1)? 'checked' :''}} name="status" class="form-control" data-toggle="toggle" data-on="Active" data-off="Inactive">
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