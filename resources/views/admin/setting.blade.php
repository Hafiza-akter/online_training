@extends('admin/master')
@section('title','Data setting')
@section('pageName','Data setting')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6">
                         <h3 class="card-title">Setup Data</h3>
                        </div>
                        <div class="col-sm-6 text-right">
                            <a href="{{route('admin.setting.edit')}}" class="text-right"><i class="fa fas fa-edit"></i>Edit</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                @if(Session::has('message'))
                    <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                    <form role="form">
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Last Edited Date</label>
                                    <input type="text" value="{{$setupData->updated_at}}" readonly class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Reminder Mail Info</label>
                                    <input type="text" value="{{$setupData->reminder_mail_info}}" readonly class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Reminder Mail Time</label>
                                    <input type="number" value="{{$setupData->reminder_mail_time}}" readonly class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Cancellation Time</label>
                                    <input type="number" value="{{$setupData->cancellation_time}}" readonly class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Bmr Weight Coefficient</label>
                                    <input type="number" value="{{$setupData->bmr_weight_coefficient}}" readonly class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Bmr Length Coefficient</label>
                                    <input type="number" value="{{$setupData->bmr_length_coefficient}}" readonly class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Bmr Age Coefficient</label>
                                    <input type="number" value="{{$setupData->bmr_age_coefficient}}" readonly class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Bmr Male Coefficient</label>
                                    <input type="number" value="{{$setupData->bmr_male_coefficient}}" readonly class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Bmr Female Coefficient</label>
                                    <input type="number" value="{{$setupData->bmr_female_coefficient}}" readonly class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Calory Gained Large Coefficient</label>
                                    <input type="number" value="{{$setupData->calory_gained_large_coefficient}}" readonly class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Calory Gained Standard</label>
                                    <input type="number" value="{{$setupData->calory_gained_standard}}" readonly class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Calory Gained Small Coefficient</label>
                                    <input type="number" value="{{$setupData->calory_gained_small_coefficient}}" readonly class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Ditcoefficient</label>
                                    <input type="number" value="{{$setupData->ditcoefficient}}" readonly class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Pal Middium Standard</label>
                                    <input type="number" value="{{$setupData->pal_middium_standard}}" readonly class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Pal Low Standard</label>
                                    <input type="number" value="{{$setupData->pal_low_standard}}" readonly class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Pal High Standard</label>
                                    <input type="number" value="{{$setupData->pal_high_standard}}" readonly class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Traininng Calory Coefficient</label>
                                    <input type="number" value="{{$setupData->traininng_calory_coefficient}}" readonly class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- text input -->
                                <div class="form-group">
                                    <label>Adter Burn Coefficient</label>
                                    <input type="number" value="{{$setupData->adter_burn_coefficient}}" readonly class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Weight Balance Coefficient1</label>
                                    <input type="number" value="{{$setupData->weight_balance_coefficient1}}" readonly  class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Weight Balance Coefficient2</label>
                                    <input type="number" value="{{$setupData->weight_balance_coefficient2}}" readonly  class="form-control" placeholder="Enter ...">
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