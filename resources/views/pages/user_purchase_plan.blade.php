@extends('auth/master')
@section('title','Purchase Plan')
@section('content')
<div class="row pb-5">
    <h2 class="mx-auto">Trainee's Page</h2>
</div>
<div class="row pb-3">
    <div class="col-sm border-round">
        <a class="btn">Schedule </a>
    </div>
    <div class="col-sm border-round">
        <a class="btn">Plan Purchase </a>
    </div>
    <div class="col-sm border-round">
        <a class="btn">Progress </a>
    </div>
    <div class="col-sm border-round">
        <a class="btn">ログインする </a>
    </div>
</div>
<div class="row mb-5">
    <div class="offset-sm-4 col-sm-4 border-round">
        <a class="btn">Plan Purchase </a>
    </div>
    <div class="offset-sm-2 col-sm-8 pt-5">
        <h2 class="mx-auto">Current plan is weekly plan</h2>
    </div>
</div>
<div class="row">
    <div class="col-sm">
        <div class="card-deck mb-3 text-center">
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Weekly Plan</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">24000 yen <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>24000 yen will increase for weight loss</li>
                    </ul>
                    <button type="button" class="btn btn-lg btn-block btn-primary">Purchase</button>
                </div>
            </div>
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Twice a week</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">48000 yen <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>lorem ipsum</li>

                    </ul>
                    <button type="button" class="btn btn-lg btn-block btn-primary">Purchase</button>
                </div>
            </div>
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Three times a week</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">72000 yen <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>lorem ipsum</li>

                    </ul>
                    <button type="button" class="btn btn-lg btn-block btn-primary">Purchase</button>
                </div>
            </div>

        </div>
    </div>

</div>
<div class="row">
    <div class="col-sm">
        <div class="card-deck mb-3 text-center">
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Three times a week</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">72000 yen <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>lorem ipsum</li>
                    </ul>
                    <button type="button" class="btn btn-lg btn-block btn-primary">Purchase</button>
                </div>
            </div>
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">One Time a week</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">4800 yen <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>lorem ipsum</li>

                    </ul>
                    <button type="button" class="btn btn-lg btn-block btn-primary">Purchase</button>
                </div>
            </div>
            <div class="card mb-4 box-shadow">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Others any plan</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">---- yen <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>lorem ipsum</li>
                    </ul>
                    <button type="button" class="btn btn-lg btn-block btn-primary">Purchase</button>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

@endsection