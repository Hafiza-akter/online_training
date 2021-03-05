@extends('admin/master')
@section('title','add course')
@section('pageName','add course')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="card-title">Course Add</h3>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{route('course.list')}}" class="text-right"><i class="fa fas fa-list"></i> list</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    
                    @if(Session::has('message'))
                    <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
                    @endif
                    <form role="form" method="post" action="{{route('course.add.submit')}}" enctype="multipart/form-data">
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
                                                <label for="exampleInputEmail1">Course Name</label>
                                                <input  type="text" class="form-control" name="course_name" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Course Type</label><br>
                                                <select class="custom-select mr-sm-2" name="course_type">
                                                    <option value="weight_loss" >Weight loss</option>
                                                    <option value="weight_gain">Weight gain</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Equipment</label>
                                                <select class="custom-select mr-sm-2" name="equipment_id">
                                                @foreach($equipmentList as $equipment)
                                                    <option value="{{$equipment->id}}" >{{$equipment->name}}</option>
                                                @endforeach
                                                </select> 
                                                
                                             </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Image</label>
                                                <input type="file"  name="image" accept="image/jpeg,image/png" class="form-control">
                                             </div>
                                             <div class="form-group">
                                                <label for="exampleInputEmail1">Set 1</label>
                                                {{-- <input  type="number" class="form-control" name="set_1" placeholder="Enter ..."> --}}
                                                
                                                <input type="text"  name="set_1_kg" class="kg p-1 m-1" /><span>KG</span>
                                                <input  type="text" name="set_1_times" class="times kg p-1 m-1"  /><span>回</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Set 2</label>
                                                {{-- <input  type="number" class="form-control" name="set_2" placeholder="Enter ..."> --}}
                                                <input type="text"  name="set_2_kg" class="kg p-1 m-1" /><span>KG</span>
                                                <input  type="text" name="set_2_times" class="times kg p-1 m-1"  /><span>回</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Set 3</label>
                                                {{-- <input  type="number" class="form-control" name="set_3" placeholder="Enter ..."> --}}
                                                <input type="text"  name="set_3_kg" class="kg p-1 m-1" /><span>KG</span>
                                                <input  type="text" name="set_3_times" class="times kg p-1 m-1"  /><span>回</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Summary</label>
                                                <input  type="text" class="form-control" name="summary" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Reference URL</label>
                                                <input  type="text" class="form-control" name="reference_url" placeholder="Enter ...">
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Mets</label>
                                                <input  type="text" class="form-control" name="mets" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Main</label>
                                                <input  type="text" class="form-control" name="main" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Sub</label>
                                                <input  type="text" class="form-control" name="sub" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Motion</label>
                                                <input  type="text" class="form-control" name="motion" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Way</label>
                                                <input  type="text" class="form-control" name="way" placeholder="Enter ...">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Session Time</label>
                                                <input  type="number" class="form-control" name="session_time" placeholder="Enter ...">
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