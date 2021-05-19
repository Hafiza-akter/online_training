@extends('admin/master')
@section('title','admin dashboard')
@section('pageName','admin dashboard')
@section('content')
<div class="container-fluid">
  <!-- Small boxes (Stat box) -->
  <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">支払い管理</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl.</th>
                                <th>日付</th>
                                <th>名前</th>
                                <th>メールアドレス</th>
                                <th>プラン</th>
                                <th>購入ステータス</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $i = 1 @endphp
                          @foreach($planList as $plan)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$plan->created_at}}</td>
                                <td>{{$plan->getUser->name ?? ''}}</td>
                                <td>{{$plan->getUser->email ?? ''}}</td>
                                <td>{{$plan->getPlan->name ?? ''}}</td>
                                
                                <td>
                                    <?php 
                                    if($plan->status == 1){ ?>
                                        <input type="button"  readonly  class="btn btn-primary"  value="支払済">
                                    <?php }else{?>
                                        <input type="button"  readonly  class="btn btn-warning"  value="未支払い">
                                  <?php  } ?>
                                </td> 
                                
                            </tr>
                            @endforeach
                           
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sl.</th>
                                <th>日付</th>
                                <th>名前</th>
                                <th>メールアドレス</th>
                                <th>プラン</th>
                                <th>支払いステータス</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
  <!-- /.row -->

</div><!-- /.container-fluid -->
@endsection