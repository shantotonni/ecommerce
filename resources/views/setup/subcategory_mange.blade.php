@extends('layouts.master')

@section('title','SubCategory Manage | '.config('app.name'))

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>{{$featureName}} Manager</h3>
                </div>
                <div class="col-md-6">
                    <p class="float-right">Category: <span class="text-danger text-bold">{{$category->Category}}</span> Project: <span class="text-danger text-bold">{{$category->project->ProjectName}}</span></p>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h4 class="card-title">{{$featureName ?? ''}} {{$actionTitle ?? ''}}</h4>
                </div>
                @include('common.validation_error')
                <form class="form-horizontal form-validation" method="post" action="{{url($action)}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$selectedSubcategory->SubCategoryId ?? ''}}" name="id">
                    <input type="hidden" value="{{$categoryId ?? ''}}" name="categoryId">
                    <input type="hidden" value="{{$category->ProjectID ?? ''}}" name="projectID">
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="subCategory" class="col-sm-4 col-form-label col-form-label-sm">Sub Category
                                    Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="subCategory"
                                           name="subCategory" placeholder="Sub Category"
                                           value="{{$selectedSubcategory->SubCategory ?? old('subCategory')}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="subCategoryIcon" class="col-sm-4 col-form-label col-form-label-sm">Sub Category
                                    Icon(Optional)</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="subCategoryIcon"
                                           name="subCategoryIcon" placeholder="Sub Category Icon"
                                           value="{{$selectedSubcategory->SubCategoryIcon ?? old('subCategoryIcon')}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="image" class="col-sm-4 col-form-label col-form-label-sm">Category
                                    Image</label>
                                <div class="col-sm-8">
                                    <input accept="image/*" type="file" class="form-control form-control-sm" id="image"
                                           name="image">
                                    <span class="small text-info">Type:jpg,jpeg,png; Width:{{$maxWidth}}, Height: {{$maxHeight}}</span><br>
                                    @if(isset($selectedSubcategory->SubCategoryImage))
                                        <img src="{{$imageUrl.'/'.$selectedSubcategory->SubCategoryImage}}" alt="{{$selectedSubcategory->SubCategoryImage}}"
                                             width="100" height="50">
                                    @endif
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="active" class="col-sm-4 col-form-label col-form-label-sm">Active</label>
                                <div class="col-sm-8">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" name="active"
                                               id="active" <?php if (isset($selectedSubcategory->SubCategoryStatus)) {
                                            if (($selectedSubcategory->SubCategoryStatus == 'Y') || old('subCategoryStatus')) {
                                                echo 'checked';
                                            }
                                        } else {
                                            echo "checked";
                                        }?> >
                                        <label for="active">
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="subCategoryDescription" class="col-sm-2 col-form-label col-form-label-sm">Sub Category Description(Optional)</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm" name="subCategoryDescription" id="subCategoryDescription" cols="5" rows="5" placeholder="Sub Category Description">{{$selectedSubcategory->SubCategoryDescription ?? old('subCategoryDescription')}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="subCategoryMetaData" class="col-sm-2 col-form-label col-form-label-sm">Meta Data(Optional)</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm" name="subCategoryMetaData" id="subCategoryMetaData" cols="5" rows="5" placeholder="Category Meta Data">{{$selectedSubcategory->SubCategoryMetaData ?? old('subCategoryMetaData')}}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"><i
                                class="fas fa-paper-plane"></i> {{isset($selectedSubcategory) ? 'Update' : 'Add'}}
                        </button>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{$featureName}} List</h3>
                    <p class="float-right">Category: <span class="text-danger text-bold">{{$category->Category}}</span> Project: <span class="text-danger text-bold">{{$category->project->ProjectName}}</span> <a class="btn btn-danger btn-sm " href="{{url($action,$categoryId)}}"><i class="fas fa-plus"></i> Add New</a> </p>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px">
                    <table class="table table-hover table-head-fixed text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sub Category Name</th>
                            <th>Slug</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($subcategories))
                            @foreach($subcategories as $key=>$subcategory)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$subcategory->SubCategory}}</td>
                                    <td>{{$subcategory->SubcategorySlug}}</td>
                                    <td><img src="{{$imageUrl.'/'.$subcategory->SubCategoryImage}}" alt="{{$subcategory->SubCategoryImage}} " width="50"></td>
                                    <td>
                                        @if($subcategory->SubCategoryStatus=='Y')
                                            <span class="badge badge-success">Active </span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif</td>
                                    <td>
                                    <td>
                                        <a class="btn btn-default btn-sm" href="{{url($action.'/'.$categoryId,$subcategory->SubCategoryId)}}"><i class="fa fa-edit"></i> Edit</a>
                                        <a class="btn btn-danger btn-sm" onclick="return confirm(' you want to delete?');" href="{{ route('sub.category.delete',$subcategory->SubCategoryId) }}"><i class="fa fa-trash"></i>Delete</a>
                                    </td>

                                </tr>
                            @endforeach
                        @endif


                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>


        </div>
    </section>
@endsection
@section('jquery')
    <script>
        $(document).ready(function () {
            // jQuery Form Validation
            $('.form-validation').validate();
        });
    </script>
@endsection
