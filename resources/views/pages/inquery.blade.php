{{-- @extends('master_page') --}}
@extends('master_dashboard')
@section('title','inquery')
@section('content')
<style>
    .login_button {
        border-radius: 1px !important;
        font-size: 18px;
        width: 400px;
        color: #a506a4;
        border: 2px solid #bb07bb;
    }

    .gradient {
        background-image: linear-gradient(to left, purple 0%, #c300c3 50%, #7e007e 100%);
        color: #fff !important;
    }
</style>


<section class="about_us section_padding">
    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-8 col-xl-6">
                <div class="section_tittle">
                    <h3>問い合わせ</h3>
                </div>
            </div>
        </div>

    </div>
    <div class="overlay_icon">
        <img src="{{ asset('asset_v2/img/animate_icon/icon_1.png')}}" class="amitated_icon_1" alt="animate_icon">
        <img src="{{ asset('asset_v2/img/animate_icon/icon_2.png')}}" class="amitated_icon_2" alt="animate_icon">
        <img src="{{ asset('asset_v2/img/animate_icon/icon_3.png')}}" class="amitated_icon_3" alt="animate_icon">
        <img src="{{ asset('asset_v2/img/animate_icon/icon_4.png')}}" class="amitated_icon_4" alt="animate_icon">
        <img src="{{ asset('asset_v2/img/animate_icon/icon_5.png')}}" class="amitated_icon_5" alt="animate_icon">
    </div>

    <div class="offset-sm-2 col-sm-8 mb-4">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif


        <!-- /.card-header -->
        <!-- form start -->
        @if(Session::has('message'))
        <p id="flashMessage" class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
        @endif



    </div>



    <div class="offset-sm-2 col-sm-8 mb-4">
        <div class="card card-info">
            <form action="{{route('inquiry.submit')}}" method="post">

                {{ csrf_field() }}
                <input type="hidden" name="email" class="form-control" value="{{ $user->email}}">
                <input type="hidden" name="user_id" class="form-control" value="{{ $user->id}}">
                <div class="card-body">

                    <div class="row mb-3">

                        <div class="col">
                            <label class="col-form-label title">題名 <span style="color:red">*</span></label>
                            <input type="text" class="form-control" name="title" required="required">
                        </div>
                    </div>
                    <div class="col">
                        <label class="col-form-label message">メッセージ <span style="color:red">*</span></label>
                        <textarea class="form-control" rows="6" name="message" required="required"></textarea>
                    </div>
                </div>
        </div>
        <div class="card-footer">
            <div class="row pt-3 pb-3">
                <button type="submit" class="mx-auto btn btn-secondary text-white btn-lg gradient ">決定</button>
            </div>
        </div>

        </form>

        <div class="card mt-4">
            <div class="card-header">
                <h3 class="card-title">Inquery List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#Sl</th>
                            <th>Title</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $i=1 @endphp
                    @foreach($inqueryList as $inquery)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$inquery->title}}</td>
                            <td>{{$inquery->message}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#Sl</th>
                            <th>Title</th>
                            <th>Message</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    </div>
</section>




@endsection
@section('footer_css_js')


<script>
    $(document).ready(function() {

        $(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
            $(".alert-success").slideUp(500);
        });


    });
</script>
@endsection