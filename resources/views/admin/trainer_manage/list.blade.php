@extends('admin/master')
@section('title','トレーナーリスト')
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
                            <h3 class="card-title">トレーナーリスト</h3>
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
                                <th>名前</th>
                                <th>メールアドレス</th>
                                <th>都市</th>
                                <th>携帯番号</th>
                                <th>プロフィール写真</th>
                                <th>希望単価</th>
                                <!-- <th>Certification</th> -->
                                <th>ステータス</th>
                                <th>詳細</th>
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
                                <!-- <td>{{$trainer->certification}}</td> -->
                                
                                <td>
                                    <?php 
                                  if($trainer->status == 1){ ?>
                                    <span class="span-info ml-2">Active</span>
                                    <?php }else{?>
                                        <span class="span-warning ml-2">Inactive</span>
                                   <?php } ?>
                                </td>
                                <td>
                                    <a href="{{route('admin.trainer.edit',$trainer->id)}}" class="pl-3 pr-3"><i class="fas fa-edit"></i></a>
                                    <a href="{{route('admin.trainer.view',$trainer->id)}}" class="pl-3 pr-3"><i class="fas fa-eye"></i></a>
                                </td>

                            </tr>
                            @endforeach


                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#sl</th>
                                <th>名前</th>
                                <th>メールアドレス</th>
                                <th>都市</th>
                                <th>携帯番号</th>
                                <th>プロフィール写真</th>
                                <th>希望単価</th>
                                <!-- <th>Certification</th> -->
                                <th>ステータス</th>
                                <th>詳細</th>

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