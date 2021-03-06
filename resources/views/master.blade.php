<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> --}}
    <meta content="width=device-width, initial-scale=1" name="viewport" />

    <title>メディカルジムオンライン</title>
    <link rel="icon" href="img/favicon.png')}}">

    <link rel="stylesheet" href="{{asset('asset_v2/css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{asset('asset_v2/css/animate.css')}}">

    <link rel="stylesheet" href="{{asset('asset_v2/css/owl.carousel.min.css')}}">

    <link rel="stylesheet" href="{{asset('asset_v2/css/themify-icons.css')}}">

    <link rel="stylesheet" href="{{asset('asset_v2/css/flaticon.css')}}">

    <link rel="stylesheet" href="{{asset('asset_v2/css/magnific-popup.css')}}">

    <link rel="stylesheet" href="{{asset('asset_v2/css/all.css')}}">

    <link rel="stylesheet" href="{{asset('asset_v2/css/style.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.5.0/main.min.js'></script>
        @yield('header_css_js')

</head>

<body>

    @include('layout.header')

    @yield('content')

    @include('layout.footer')



    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <script src="{{asset('asset_v2/js/popper.min.js')}}"></script>

    <script src="{{asset('asset_v2/js/bootstrap.min.js')}}"></script>

    <script src="{{asset('asset_v2/js/jquery.magnific-popup.js')}}"></script>

    <script src="{{asset('asset_v2/js/swiper.min.js')}}"></script>

    <script src="{{asset('asset_v2/js/masonry.pkgd.js')}}"></script>

    <script src="{{asset('asset_v2/js/owl.carousel.min.js')}}"></script>

    <script src="{{asset('asset_v2/js/slick.min.js')}}"></script>
    <script src="{{asset('asset_v2/js/gijgo.min.js')}}"></script>
    {{-- <script src="{{asset('asset_v2/js/jquery.nice-select.min.js')}}"></script> --}}

    <script src="{{asset('asset_v2/js/custom.js')}}"></script>
    <script>
        $(document).ready(function() {
            $(".alert").delay(4000).slideUp(200, function() {
                $(this).alert('close');
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        @yield('footer_css_js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var dateData = JSON.parse($(schedule).val());

            var calendar = new FullCalendar.Calendar(calendarEl, {
                selectable: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                dateClick: function(info) {
                    // alert('clicked ' + info.dateStr);
                    $("#selected_date").val('');
                    $("#selected_date").val(info.dateStr);
                    // $("#selected_date").val(info);
                    console.log(info);
                    $('#dateform').submit();
                },
                select: function(info) {
                    // alert('selected ' + info.startStr + ' to ' + info.endStr);
                },
                events: dateData
            });

            calendar.render();
        });

        //   events: [
        //   {
        //     start: "2020-12-06",
        //     allDay: true,
        //     display: 'background',
        //     color: "#00FFFF"

        //   }
        // ]
    </script>

</body>

</html>