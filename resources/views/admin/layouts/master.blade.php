<html >
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Panel - Control Your Entire Site.</title>
    <meta name="description" content="Nulled by TRC4 Albania">
    <meta name="author" content="TRC4">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="stylesheet" href="{{asset('assets/css/normalize.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link href="{{asset('assets/styles/custom.css')}}" rel="stylesheet"> <!-- Custom css code from modified in admin panel --->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/flag-icon.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/cs-skin-elastic.css')}}">
    <link rel="stylesheet" href="{{asset('assets/scss/style.css')}}">
    <link rel="shortcut icon" href="http://localhost/gigtodo/GigToDo_Freelance_Marketplace_153_TRC4_EDIT///images/favicon.ico" type="image/x-icon">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800'rel='stylesheet'type='text/css'>
    <link rel="stylesheet" href="{{asset('assets/css/sweat_alert.css')}}" >

</head>
<body>
<!-- Left Panel -->
@include('admin.layouts.includes.sidebar')


<!-- Left Panel -->

<!-- Right Panel -->
<div id="right-panel" class="right-panel">

    <!-- Header-->
    @include('admin.layouts.includes.haeder')
    <!-- Header-->

    @yield('content')
</div>
<!-- Right Panel -->
<script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/plugins.js')}}"></script>
@yield('scripts')
</body>
</html>
