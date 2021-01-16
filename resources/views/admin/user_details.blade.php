@extends('admin/master')
@section('title','User Deatils')
@section('pageName','User Deatils')
@section('content')
<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Management</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <div class="col-sm">
                                <h4 class="text-center">Kakashi Hatake</h4>
                            </div>
                            <nav>
                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Basic Information</a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Personal Data</a>
                                </div>
                            </nav>
                            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="row mt-5">
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <label for="" class="col-sm-4 col-form-label pl-5 ">Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" readonly class="form-control-plaintext" id="" value="Kakashi Hatake">
                                                </div>
                                                <label for="" class="col-sm-4 col-form-label pl-5 ">Frigana</label>
                                                <div class="col-sm-8">
                                                    <input type="text" readonly class="form-control-plaintext" id="" value="Lorem Ipsum">
                                                </div>
                                                <label for="" class="col-sm-4 col-form-label pl-5 ">Email</label>
                                                <div class="col-sm-8">
                                                    <input type="text" readonly class="form-control-plaintext" id="" value="xyz@gmail.com">
                                                </div>
                                                <label for="" class="col-sm-4 col-form-label pl-5 ">Phone</label>
                                                <div class="col-sm-8">
                                                    <input type="text" readonly class="form-control-plaintext" id="" value="998856">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h5 class="col-sm-6 text-center ">Personal View</h5>
                                                </div>
                                                <label for="" class="col-sm-4 col-form-label pl-5 ">Dubmel</label>
                                                <div class="col-sm-8">
                                                    <input type="text" readonly class="form-control-plaintext" id="" value="Time">
                                                </div>
                                                <label for="" class="col-sm-4 col-form-label pl-5 ">Bench</label>
                                                <div class="col-sm-8">
                                                    <input type="text" readonly class="form-control-plaintext" id="" value="Have">
                                                </div>
                                                <label for="" class="col-sm-4 col-form-label pl-5 ">Barbell</label>
                                                <div class="col-sm-8">
                                                    <input type="text" readonly class="form-control-plaintext" id="" value="Have">
                                                </div>
                                                <label for="" class="col-sm-4 col-form-label pl-5 ">Machine </label>
                                                <div class="col-sm-8">
                                                    <input type="text" readonly class="form-control-plaintext" id="" value="Have">
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <h5 class="text-center">Personal Data</h5>
                                            <span class="text-center">4 times (last month) Attendence: 2</span>
                                        </div>
                                        <div class="col-sm-12 pt-5">
                                            <div class="row">
                                                <div class="col-sm">
                                                    <h5>Date: December 24, 2020</h5>
                                                </div>
                                                <div class="col-sm">
                                                <h5>Section : B</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm">
                                            <label for="staticEmail" class="col-sm-4 col-form-label pl-5 pt-3">Email</label>
                                            <div class="col-sm-8">
                                                <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="email@example.com">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<!-- /.row -->

</div><!-- /.container-fluid -->
@endsection