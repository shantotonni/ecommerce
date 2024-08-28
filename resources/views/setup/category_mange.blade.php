@extends('layouts.master')

@section('title','Category Manage | '.config('app.name'))

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>{{$featureName}} Manager</h3>
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
                <form class="form-horizontal form-validation" method="post" action="{{url($action)}}"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$selectedCategory->CategoryId ?? ''}}" name="id">
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="project" class="col-sm-4 col-form-label col-form-label-sm">User
                                    Project</label>

                                <div class="col-sm-8">
                                    <select class="form-control form-control-sm" name="project" id="project" required>
                                        <option value="">--Select--</option>
                                        @foreach($projects as $project)
                                            <option value="{{$project->ProjectID}}"
                                                {{(isset($selectedCategory->ProjectID) && ($selectedCategory->ProjectID==$project->ProjectID) || (old('project')== $project->ProjectID)) ? 'selected' : ''}}
                                            >{{$project->ProjectName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="category" class="col-sm-4 col-form-label col-form-label-sm">Category
                                    Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="category"
                                           name="category" placeholder="Category"
                                           value="{{$selectedCategory->Category ?? old('category')}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="categoryIcon" class="col-sm-4 col-form-label col-form-label-sm">Category Icon(Optional)</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="categoryIcon" name="categoryIcon" placeholder="Category Icon"
                                           value="{{$selectedCategory->CategoryIcon ?? old('categoryIcon')}}">
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
                                    @if(isset($selectedCategory->CategoryImage))
                                        <img src="{{$imageUrl.'/'.$selectedCategory->CategoryImage}}" alt=""
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
                                               id="active" <?php if (isset($selectedCategory->CategoryStatus)) {
                                            if ((isset($selectedCategory->CategoryStatus) && $selectedCategory->CategoryStatus == 'Y') || old('active')) {
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

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="isFeatured" class="col-sm-4 col-form-label col-form-label-sm">Featured Category</label>
                                <div class="col-sm-8">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" name="isFeatured"
                                               id="isFeatured" <?php if (isset($selectedCategory->IsFeatured)) {
                                            if ((isset($selectedCategory->IsFeatured) && $selectedCategory->IsFeatured == 'Y') || old('isFeatured')) {
                                                echo 'checked';
                                            }
                                        } else {
                                            echo "checked";
                                        }?> >
                                        <label for="isFeatured">
                                        </label><br>
                                        <span class="small text-info">Featured Category is shown in Homepage</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="category" class="col-sm-4 col-form-label col-form-label-sm">Order</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control form-control-sm" id="Order" name="Order" placeholder="Order" value="{{$selectedCategory->Order ?? old('Order')}}">
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="categoryDescription" class="col-sm-2 col-form-label col-form-label-sm">
                                    Category Description(optional)</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm" name="categoryDescription"
                                              id="categoryDescription" cols="5" rows="5"
                                              placeholder="category Description">{{$selectedCategory->CategoryDescription ?? old('categoryDescription')}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="categoryMetaData" class="col-sm-2 col-form-label col-form-label-sm">
                                    Category Meta Data(Optional)</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm" name="categoryMetaData"
                                              id="categoryMetaData" cols="5" rows="5"
                                              placeholder="Category Meta Data">{{$selectedCategory->CategoryMetaData ?? old('categoryMetaData')}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="CategoryMetaTitle" class="col-sm-2 col-form-label col-form-label-sm">
                                    Category Meta Title(Optional)</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-sm" name="CategoryMetaTitle" value="{{$selectedCategory->CategoryMetaTitle ?? old('CategoryMetaTitle')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"><i
                                class="fas fa-paper-plane"></i> {{isset($selectedCategory) ? 'Update' : 'Add'}}
                        </button>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{$featureName}} List</h3>
                    <p class="float-right"><a class="btn btn-danger btn-sm " href="{{url($action)}}"><i class="fas fa-plus"></i> Add New</a> </p>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px">
                    <table class="table table-hover table-head-fixed text-nowrap">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Slug</th>
                            <th>Image</th>
                            <th>Project</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($categories))
                            @foreach($categories as $key=>$category)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$category->Category}}</td>
                                    <td>{{$category->CategorySlug}}</td>
                                    <td><img src="{{$imageUrl.'/'.$category->CategoryImage}}"
                                             alt="{{$category->CategoryImage}} " width="50"></td>
                                    <td>{{$category->project->ProjectName}}</td>
                                    <td>
                                        <a class="btn btn-default btn-sm" href="{{url($action,$category->CategoryId)}}"><i class="fa fa-edit"></i> Edit</a>
                                        <a class="btn btn-primary btn-sm" href="{{url('subcategory-manage',$category->CategoryId)}}"><i class="fa fa-plus"></i> Add Sub Category</a>
                                        <a class="btn btn-danger btn-sm" onclick="return confirm(' you want to delete?');" href="{{ route('category.delete',$category->CategoryId) }}"><i class="fa fa-trash"></i>Delete</a>
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
            $('.form-validation').validate({
                rules: {
                    category: {
                        required: true,
                        maxlength: 255
                    },
                },
            });
        });
    </script>
@endsection
