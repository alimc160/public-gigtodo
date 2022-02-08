@extends('admin.layouts.master')

@section('content')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 45px;
            height: 20px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 3px;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 10px;
            width: 10px;
            /* left: 0px; */
            bottom: 4px;
            right: 32px;
            background-color: white;
            -webkit-transition: .4s;
            transition: 0.4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
    <div class="breadcrumbs mt-2">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1><i class="menu-icon fa fa-cubes"></i> Users </h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
{{--            <div class="page-header float-right">--}}
{{--                <div class="page-title">--}}
{{--                    <ol class="breadcrumb text-right">--}}
{{--                        <li class="active"><a href="{{route('admin.categories.create')}}" class="btn btn-success">--}}

{{--                                <i class="fa fa-plus-circle text-white"></i> <span class="text-white">Add Category</span>--}}

{{--                            </a></li>--}}
{{--                    </ol>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>

    </div>
    <div class="container">

        <div class="row"><!--- 2 row Starts --->

            <div class="col-lg-12"><!--- col-lg-12 Starts --->

                <div class="card"><!--- card Starts --->

                    <div class="card-header"><!--- card-header Starts --->

                        <h4 class="h4">

                            <i class="fa fa-money-bill-alt"></i> View All Users

                        </h4>

                    </div><!--- card-header Ends --->

                    <div class="card-body" id="app"><!--- card-body Starts --->

                        <table class="table table-bordered"><!--- table table-bordered table-hover Starts --->

                            <thead>

                            <tr>

                                <th>Name</th>

                                <th>Email</th>

                                <th>Role</th>

                                <th>Status</th>

                                <th>Action</th>

                            </tr>

                            </thead>

                            <tbody><!--- tbody Starts --->
                            @foreach($data['users']['result'] as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role->name }}</td>
                                <td>{{ $user->is_active == 1 ? "Active" : "Suspended"}}</td>
                                <td>
                                    <label class="switch">
                                        <input data-url="{{ route('admin.users.change.status',$user->id) }}" class="user_status_change" {{ $user->is_active == 1 ? "checked":"" }} type="checkbox">
                                        <span class="slider round"></span>
                                    </label>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <!--- tbody Ends --->

                        </table>
                        <!--- table table-bordered table-hover Ends --->

                    </div>
                    <!--- card-body Ends --->

                </div>
                <!--- card Ends --->

            </div>
            <!--- col-lg-12 Ends --->

        </div>
        <!--- 2 row Ends --->

    </div>
@endsection
@section('scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        $('.user_status_change').on('change',function (e){
            let url = $(this).data('url');
            let isActive = 0;
            if ($(this).is(':checked')){
                isActive = 1;
            }
            console.log(isActive);
            let request = {
                _token : "{{ csrf_token() }}",
                is_active : isActive
            };
            axios.post(url,request).then(res=>{
                console.log(res);
            }).catch(error=>{
                console.log(error);
            })
        });
    </script>
@endsection
