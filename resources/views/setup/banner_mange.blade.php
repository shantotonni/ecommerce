@extends('layouts.master')

@section('title','Banner Manage | '.config('app.name'))

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
                <form class="form-horizontal form-validation" method="post" action="{{url($action)}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$selectedBanner->BannerID ?? ''}}" name="id">
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
                                                {{(isset($selectedBanner->ProjectID) && ($selectedBanner->ProjectID==$project->ProjectID) || (old('project')== $project->ProjectID)) ? 'selected' : ''}}
                                            >{{$project->ProjectName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="bannerName" class="col-sm-4 col-form-label col-form-label-sm">Banner
                                    Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="bannerName"
                                           name="bannerName"
                                           placeholder="Banner Name"
                                           value="{{$selectedBanner->BannerName ?? old('bannerName')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="image" class="col-sm-4 col-form-label col-form-label-sm">Banner
                                    Image</label>
                                <div class="col-sm-8">
                                    <input accept="image/*" type="file" class="form-control form-control-sm" id="image" name="image"
                                           {{!isset($selectedBanner) ? 'required' : ''}} >
                                    <span class="small text-info">Type:jpg,jpeg,png; Max Width:{{$maxWidth}}, Max Height: {{$maxHeight}}</span><br>
                                    @if(isset($selectedBanner) && $selectedBanner->BannerImageFile)
                                        <img src="{{$imageUrl.'/'.$selectedBanner->BannerImageFile}}" alt="" width="100" height="50">
                                    @endif
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="url" class="col-sm-4 col-form-label col-form-label-sm">URL (Link)</label>
                                <div class="col-sm-8">
                                    <input type="url" class="form-control form-control-sm" id="url"
                                           name="url"
                                           placeholder="URL (Link)"
                                           value="{{$selectedBanner->Url ?? old('url')}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="active" class="col-sm-4 col-form-label col-form-label-sm">Active</label>
                                <div class="col-sm-8">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" name="active"
                                               id="active" <?php if (isset($selectedBanner->Active)) {
                                            if (isset($selectedBanner) && $selectedBanner->Active == 'Y' || old('active')) {
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

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"><i
                                class="fas fa-paper-plane"></i> {{isset($selectedBanner) ? 'Update' : 'Add'}}
                        </button>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{$featureName}} List</h3>
                    <a class="btn btn-sm btn-danger float-right" href="{{url($action)}}"><i class="fas fa-plus"></i> Add New Banner</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 300px">
                    <table class="table table-hover table-head-fixed text-nowrap">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Project</th>
                            <th>Banner Name</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($banners))
                            @foreach($banners as $key=>$banner)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$banner->project->ProjectName}}</td>
                                    <td>{{$banner->BannerName}}</td>
                                    <td><img src="{{$imageUrl.'/'.$banner->BannerImageFile}}" alt="" width="50"></td>
                                    <td>{{$banner->Url}}</td>
                                    <td>
                                        @if($banner->Active=='Y')
                                            <span class="badge badge-success">Active </span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif</td>
                                    <td>
                                        <a class="btn btn-default btn-sm pt-0 pb-0" href="{{url($action,$banner->BannerID)}}"><i class="fas fa-edit"></i> Edit</a>
                                        <a class="btn btn-danger btn-sm" onclick="return confirm(' you want to delete?');" href="{{ route('banner.delete',$banner->BannerID) }}"><i class="fa fa-trash"></i>Delete</a>
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
