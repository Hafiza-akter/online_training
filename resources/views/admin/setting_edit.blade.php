@extends('admin/master')
@section('title','Data setting')
@section('pageName','Data setting')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card card-warning">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="card-title">セットアップデータ</h3>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{route('admin.setting')}}" class="text-right"><i class="fa fas fa-eye"></i>View</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                   
                    <form role="form" method="post" action="{{route('admin.setting.submit')}}">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>最終編集日時</label>
                                    <input type="text" readonly value="{{$setupData->updated_at}}" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>リマインドメール情報</label>
                                    <input type="text" value="{{$setupData->reminder_mail_info}}" name="reminder_mail_info" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>リマインドメール時間</label>
                                    <input type="number" value="{{$setupData->reminder_mail_time}}" name="reminder_mail_time" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>キャンセル期限</label>
                                    <input type="number" value="{{$setupData->cancellation_time}}" name="cancellation_time" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Bmr Weight Coefficient</label>
                                    <input type="number" value="{{$setupData->bmr_weight_coefficient}}" name="bmr_weight_coefficient" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Bmr Length Coefficient</label>
                                    <input type="number" value="{{$setupData->bmr_length_coefficient}}" name="bmr_length_coefficient" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Bmr Age Coefficient</label>
                                    <input type="number" value="{{$setupData->bmr_age_coefficient}}" name="bmr_age_coefficient" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Bmr Male Coefficient</label>
                                    <input type="number" value="{{$setupData->bmr_male_coefficient}}" name="bmr_male_coefficient" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Bmr Female Coefficient</label>
                                    <input type="number" value="{{$setupData->bmr_female_coefficient}}" name="bmr_female_coefficient" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Calory Gained Large Coefficient</label>
                                    <input type="number" value="{{$setupData->calory_gained_large_coefficient}}" name="calory_gained_large_coefficient" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Calory Gained Standard</label>
                                    <input type="number" value="{{$setupData->calory_gained_standard}}" name="calory_gained_standard" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Calory Gained Small Coefficient</label>
                                    <input type="number" value="{{$setupData->calory_gained_small_coefficient}}" name="calory_gained_small_coefficient" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Ditcoefficient</label>
                                    <input type="number" value="{{$setupData->ditcoefficient}}" name="ditcoefficient" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Pal Middium Standard</label>
                                    <input type="number" value="{{$setupData->pal_middium_standard}}" name="pal_middium_standard" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Pal Low Standard</label>
                                    <input type="number" value="{{$setupData->pal_low_standard}}" name="pal_low_standard" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Pal High Standard</label>
                                    <input type="number" value="{{$setupData->pal_high_standard}}" name="pal_high_standard" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Traininng Calory Coefficient</label>
                                    <input type="number" value="{{$setupData->traininng_calory_coefficient}}" name="traininng_calory_coefficient" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Adter Burn Coefficient</label>
                                    <input type="number" value="{{$setupData->adter_burn_coefficient}}" name="" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Weight Balance Coefficient1</label>
                                    <input type="number" value="{{$setupData->weight_balance_coefficient1}}" name="weight_balance_coefficient1" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Weight Balance Coefficient2</label>
                                    <input type="number" value="{{$setupData->weight_balance_coefficient2}}" name="weight_balance_coefficient2" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 offset-md-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-lg btn-block btn-info">Submit</button>
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