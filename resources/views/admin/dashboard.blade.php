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
                    <h3 class="card-title">Admin Payment Manage</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Sl.</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Plan</th>
                                <th>Payment status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $i = 1 @endphp
                          @foreach($planList as $plan)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$plan->created_at}}</td>
                                <td>{{$plan->getUser->name}}</td>
                                <td>{{$plan->getUser->email}}</td>
                                <td>{{$plan->getPlan->name}}</td>
                                
                                <td>
                                    <?php 
                                    if($plan->status == 1){ ?>
                                        <input type="button"  readonly  class="btn btn-primary"  value="Paid ">
                                    <?php }else{?>
                                        <input type="button"  readonly  class="btn btn-warning"  value="Unpaid">
                                  <?php  } ?>
                                </td> 
                                
                            </tr>
                            @endforeach
                           
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Sl.</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Plan</th>
                                <th>Paid</th>
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