@extends('admin.layouts.master')

@section('content')
    <div class="breadcrumbs mt-2">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1><i class="menu-icon fa fa-cubes"></i> Gigs </h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        {{--                        <li class="active"><a href="{{route('admin.categories.create')}}" class="btn btn-success">--}}

                        {{--                                <i class="fa fa-plus-circle text-white"></i> <span class="text-white">Add Category</span>--}}

                        {{--                            </a>--}}
                        {{--                        </li>--}}
                    </ol>
                </div>
            </div>
        </div>

    </div>
    <div class="container">

        <div class="row"><!--- 2 row Starts --->

            <div class="col-lg-12"><!--- col-lg-12 Starts --->

                <div class="card"><!--- card Starts --->

                    <div class="card-header"><!--- card-header Starts --->

                        <h4 class="h4">

                            <i class="fa fa-money-bill-alt"></i> View All Gigs

                        </h4>

                    </div><!--- card-header Ends --->

                    <div class="card-body"><!--- card-body Starts --->

                        <table class="table table-bordered"><!--- table table-bordered table-hover Starts --->

                            <thead>

                            <tr>

                                <th>#</th>

                                <th>Title</th>

                                <th>Description</th>

                                <th>Change Status</th>

                                <th>Created At</th>

                                <th>Action</th>

                            </tr>

                            </thead>

                            <tbody><!--- tbody Starts --->
                            @foreach($data['gigs']['result'] as $index=>$gig)
                                <tr>

                                    <td>{{$index + $data['index']}}</td>

                                    <td>{{ substr($gig->title,0,20) }},.......</td>

                                    <td width="400">{{ substr($gig->description,0,35) }},.......</td>
                                    <td>
                                        <select data-id="{{ $gig->id }}" name="change_status" class="form-control">
                                            @foreach(config('app.status_array') as $status)
                                                <option {{ $gig->status == $status ? "selected" : "" }} value="{{ $status }}">{{ ucwords($status) }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>{{ $gig->created_at }}</td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-info text-white">
                                            <i class="fa fa-eye"></i>
                                        </a>
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
    <script>

        $("select[name='change_status']").on("change",function (e) {
            e.preventDefault();
            console.log($(this).val());
            let request = {
                '_token': "{{ csrf_token() }}",
                "status": $(this).val(),
                "id" : $(this).data("id")
            };
            $.post("/admin/change-status-gig",request).then(res=>{
                console.log(res);
            }).catch(error=>{
                console.log(error);
            });
        });
    </script>
@endsection
