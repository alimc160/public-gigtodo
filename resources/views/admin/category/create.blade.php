@extends('admin.layouts.master')

@section('content')
    <div class="breadcrumbs mt-2">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1><i class="menu-icon fa fa-cubes"></i> Categories / Insert New</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li class="active">Insert Category</li>
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

                        <h4 class="h4">Insert Category</h4>

                    </div><!--- card-header Ends --->

                    <div class="card-body"><!--- card-body Starts --->

                        <form action="{{ route('admin.categories.store') }}" method="post"
                              enctype="multipart/form-data">
                            <!--- form Starts --->
                            @csrf
                            @if(count($data['categories']) > 0)
                                <div class="form-group row">
                                    <label class="col-md-4 control-label">Select Parent Category : </label>
                                    <div class="col-md-6">

                                        <select class="form-control" name="parent_id" id="">
                                            <option value="">Select Parent Category</option>
                                            @foreach($data['categories'] as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            @endif
                            <div class="form-group row">
                                <!--- form-group row Starts --->

                                <label class="col-md-4 control-label"> Category Title : </label>

                                <div class="col-md-6">

                                    <input type="text" name="name" class="form-control" required="">

                                </div>

                            </div><!--- form-group row Ends --->


                            <div class="form-group row"><!--- form-group row Starts --->

                                <label class="col-md-4 control-label"> Category Description : </label>

                                <div class="col-md-6">

                                    <textarea name="description" class="form-control" required=""></textarea>

                                </div>

                            </div><!--- form-group row Ends --->


                            <div class="form-group row"><!--- form-group row Starts --->

                                <label class="col-md-4 control-label"> Featured Category : </label>

                                <div class="col-md-6">

                                    <input type="radio" name="is_featured" value="1" required="">

                                    <label> Yes </label>

                                    <input type="radio" name="is_featured" value="0" required="">

                                    <label> No </label>

                                </div>

                            </div><!--- form-group row Ends --->


                            <div class="form-group row"><!--- form-group row Starts --->

                                <label class="col-md-4 control-label"> Category Image : </label>

                                <div class="col-md-6">

                                    <input type="file" name="image" class="form-control">

                                </div>

                            </div><!--- form-group row Ends --->


                            <div class="form-group row"><!--- form-group row Starts --->

                                <label class="col-md-4 control-label"> Enable Watermark : </label>

                                <div class="col-md-6">

                                    <input type="radio" name="is_watermark" value="1" required="">

                                    <label> Yes </label>

                                    <input type="radio" name="is_watermark" value="0" required="" checked="">

                                    <label> No </label>

                                </div>

                            </div><!--- form-group row Ends --->


                            <div class="form-group row"><!--- form-group row Starts --->

                                <label class="col-md-4 control-label"></label>

                                <div class="col-md-6">

                                    <input type="submit" name="submit" value="Insert Category"
                                           class="btn btn-success form-control">

                                </div>

                            </div><!--- form-group row Ends --->

                        </form><!--- form Ends --->

                    </div><!--- card-body Ends --->

                </div><!--- card Ends --->

            </div><!--- col-lg-12 Ends --->

        </div><!--- 2 row Ends --->


    </div>
@endsection
