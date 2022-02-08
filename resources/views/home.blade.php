{{--<html>--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport"--}}
{{--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">--}}
{{--    <meta http-equiv="X-UA-Compatible" content="ie=edge">--}}
{{--    <meta name="csrf-token" content="{{ csrf_token() }}">--}}
{{--    <title>Document</title>--}}
{{--</head>--}}
{{--<body>--}}
{{--<div class="container spark-screen">--}}
{{--    <div class="row">--}}
{{--        <div class="col-md-10 col-md-offset-1">--}}
{{--            <div class="panel panel-default">--}}
{{--                <div class="panel-heading">Chat Message Module</div>--}}
{{--                <div class="panel-body">--}}

{{--                    <div class="row">--}}
{{--                        <div class="col-lg-8">--}}
{{--                            <div id="messages"></div>--}}
{{--                        </div>--}}
{{--                        <div class="col-lg-8">--}}
{{--                            <form action="sendmessage" method="POST">--}}
{{--                                <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
{{--                                <input type="hidden" name="user" value="{{ Auth::user()->name }}">--}}
{{--                                <textarea class="form-control msg"></textarea>--}}
{{--                                <br/>--}}
{{--                                <input type="button" value="Send" class="btn btn-success send-msg">--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>--}}
{{--<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>--}}
{{--<script src="https://cdn.socket.io/4.1.2/socket.io.min.js"></script>--}}
{{--<script>--}}
{{--    const ip_address = 'localhost';--}}
{{--    const socket_port = '3000';--}}
{{--    let socket = io(ip_address + ':' + socket_port);--}}
{{--    socket.on('connection');--}}
{{--    socket.on('message', function (data) {--}}
{{--        console.log(data);--}}
{{--    });--}}
{{--</script>--}}
{{--    <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>--}}
{{--    <script src="{{ url('/js/laravel-echo-setup.js') }}"></script>--}}
{{--    <script>--}}
{{--        let sender_id = 3;--}}
{{--        let receiver_id = 2;--}}
{{--        window.Echo.private('chat')--}}
{{--            .listen('.ChatEvent',(data)=>{--}}
{{--                console.log(data);--}}
{{--        });--}}
{{--    </script>--}}

{{--</body>--}}
{{--</html>--}}
