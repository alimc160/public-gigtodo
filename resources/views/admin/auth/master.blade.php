<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title','Login')</title>

    <meta name="description"
          content="Admin login. You will need admin credentials to access the admin panel. Reset your password if you have trouble remebering it.">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="shortcut icon" href="favicon.ico"> -->

        @yield('styles')
{{--    <link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">--}}

{{--    <link rel="stylesheet" href="{{asset('assets/css/themify-icons.css')}}">--}}
{{--    <link rel="stylesheet" href="{{asset('assets/css/flag-icon.min.css')}}">--}}
{{--    <link rel="stylesheet" href="{{asset('assets/css/cs-skin-elastic.css')}}">--}}
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->




    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

    <style>

        .swal2-popup .swal2-styled.swal2-confirm {

            background-color: #28a745 !important;
        }

        .log-width {

            width: 550px;
            margin: 0 auto;
        }

    </style>

</head>
<body class="bg-dark">
@yield('content')

<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/ie.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/sweat_alert.js')}}"></script>
@yield('script')
</body>
