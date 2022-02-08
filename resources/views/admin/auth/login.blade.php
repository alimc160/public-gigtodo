@extends('admin.auth.master')
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/normalize.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/scss/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/sweat_alert.css')}}">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
@endsection
@section('content')
    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <div class="login-logo pb-4">
                    <a href="{{route('admin.login')}}">
                        <h2 class="text-white"> TRC4 <span class="badge badge-success p-2 font-weight-bold">ADMIN</span>
                        </h2>
                    </a>
                </div>


                <div class="login-form">

                    <form action="{{route('login.post')}}" method="post" autocomplete="off">
                        @csrf
                        <div class="form-group">

                            <label>Email</label>

                            <input type="text" class="input form-control @error('email') border-danger @enderror" value="" placeholder="Email or Username"
                                   name="email">
                            @error('email')
                            <p>
                                <span class="text-danger">{{$message}}</span>
                            </p>
                            @enderror
                        </div>

                        <div class="form-group">

                            <label>Password</label>

                            <input type="password" class="pass form-control @error('password') border-danger @enderror" value="" placeholder="Password"
                                   name="password">
                            @error('password')
                            <p>
                                <span class="text-danger">{{$message}}</span>
                            </p>
                            @enderror

                        </div>

                        <div class="checkbox pb-2">

                            <label>

                                <input type="checkbox" name="remember"> Remember Me

                            </label>

                            <label class="pull-right">

                                <a href="#">Forgotten Password?</a>

                            </label>

                        </div>

                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in
                        </button>

                    </form>


                </div>

            </div>

        </div>

    </div>
@endsection
@section('script')
    <script>

    </script>
@endsection

