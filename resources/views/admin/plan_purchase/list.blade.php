@extends('admin/master')
@section('title','Plan List')
@section('pageName','Plan list')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    <div class="row">

                        <div class="col-sm-6">
                            <h3 class="card-title">プラン一覧</h3>
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
                                <th> プラン名</th>
                                <th> 目標</th>
                                <th> トレーニングの回数(週)</th>
                                <th> 費用</th>
                                <th> 1か月辺り%</th>
                                <th> 2か月辺り%</th>
                                
                                <th>ステータス</th>
                                <th>詳細</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1 @endphp
                            @foreach($planList as $plan)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$plan->name}}</td>
                                <td>{{$plan->objective}}</td>
                                <td>{{$plan->times_per_week}}</td>
                                <td>{{$plan->cost_per_month}}</td>
                                <td>{{$plan->percentage_1mo}}</td>
                                <td>{{$plan->percentage_3mo}}</td>
                                
                                <td>
                                    <?php 
                                  if($plan->status == 1){ ?>
                                    <span class="span-info ml-2">Active</span>
                                    <?php }else{?>
                                        <span class="span-warning ml-2">Inactive</span>
                                   <?php } ?>
                                </td>
                                <td>
                                    <a href="{{route('purchase.plan.edit',$plan->id)}}" class="pl-3 pr-3"><i class="fas fa-edit"></i></a>
                                </td>

                            </tr>
                            @endforeach


                        </tbody>
                        <tfoot>
                            <tr>
                            <th>#sl</th>
                                <th> プラン名</th>
                                <th> 目標</th>
                                <th> トレーニングの回数(週)</th>
                                <th> 費用</th>
                                <th> 1か月辺り%</th>
                                <th> 2か月辺り%</th>
                                
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