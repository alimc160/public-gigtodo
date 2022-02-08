@extends('admin.layouts.master')

@section('content')
    <div class="breadcrumbs mt-2">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1><i class="menu-icon fa fa-cubes"></i> Categories </h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li class="active"><a href="{{route('admin.categories.create')}}" class="btn btn-success">

                                <i class="fa fa-plus-circle text-white"></i> <span class="text-white">Add Category</span>

                            </a></li>
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

                            <i class="fa fa-money-bill-alt"></i> View All Categories

                        </h4>

                    </div><!--- card-header Ends --->

                    <div class="card-body"><!--- card-body Starts --->

                        <table class="table table-bordered"><!--- table table-bordered table-hover Starts --->

                            <thead>

                            <tr>

                                <th>Category Id</th>

                                <th>Category Title</th>

                                <th>Category Description</th>

                                <th>Category Featured</th>

                                <th>Delete Category</th>

                                <th>Edit Category</th>

                            </tr>

                            </thead>

                            <tbody><!--- tbody Starts --->
                            @foreach($data['categories'] as $category)
                            <tr>

                                <td>{{$category->id}}</td>

                                <td>{{ $category->name }}</td>

                                <td width="400">{{ $category->description }}</td>

                                <td>{{ $category->is_featured == 1 ? "Yes" : "No" }}</td>

                                <td>
                                    <form action="{{ route('admin.categories.destroy',$category->id) }}" method="post">
                                        @csrf
                                        <button onclick="return confirm('Deleting this category will delete all its sub-categories. Do you wish to proceed?');" class="btn btn-danger">

                                            <i class="fa fa-trash text-white"></i> <span class="text-white">Delete</span>

                                        </button>
                                    </form>

                                </td>

                                <td>

                                    <a href="{{ route('admin.categories.edit',$category->id) }}" class="btn btn-success">

                                        <i class="fa fa-pencil text-white"></i> <span class="text-white">Edit Cat</span>

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
