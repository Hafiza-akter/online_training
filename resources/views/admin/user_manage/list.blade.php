@extends('admin/master')
@section('title','ユーザー一覧')
@section('pageName','User list')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                <div class="row">
                
                <div class="col-sm-6"><h3 class="card-title">ユーザー一覧</h3></div>
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
                                <th>電話番号</th>
                                <th>ステータス</th>
                                <th>詳細</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1 @endphp
                            @foreach($userList as $user)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->phone}}</td>
                                
                                <td>
                                    <?php 
                                  if($user->status == 1){ ?>
                                    <span class="span-info ml-2">Active</span>
                                    <?php }else{?>
                                        <span class="span-warning ml-2">Inactive</span>
                                   <?php } ?>
                                </td>
                                <td>
                                    <a href="{{route('user.edit',$user->id)}}" class="pl-3 pr-3"><i class="fas fa-edit"></i></a>
                                    <a href="{{route('user.training.history',$user->id)}}" ><i class="fas fa-dumbbell"></i></a>

                                </td>
                            </tr>
                            @endforeach


                        </tbody>
                        <tfoot>
                        <tr>
                                <th>#sl</th>
                                <th>名前</th>
                                <th>メールアドレス</th>
                                <th>電話番号</th>
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