@extends('layouts.master')

@section('title','User Manage | '. title())

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>User Manager</h3>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h4 class="card-title">{{$title ?? ''}}</h4>
                </div>
                <form class="form-validation form-horizontal" method="post" action="{{url('user-add')}}">
                    @csrf
                    <input type="hidden" value="{{$selectedUser->UserId ?? ''}}" name="userId">
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="name" class="col-sm-4 col-form-label col-form-label-sm">Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Name" required value="{{$selectedUser->Name ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="staffId" class="col-sm-4 col-form-label col-form-label-sm">Staff Id</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control form-control-sm" id="staffId" name="staffId" value="{{$selectedUser->StaffId ?? ''}}" placeholder="Staff Id" required maxlength="10">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="designation" class="col-sm-4 col-form-label col-form-label-sm">Designation</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="designation" name="designation" placeholder="Designation" required value="{{$selectedUser->Designation ?? ''}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="active" class="col-sm-4 col-form-label col-form-label-sm">Active</label>
                                <div class="col-sm-8">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" name="active"
                                               id="active" <?php if (isset($selectedUser->Active)) {
                                            if ($selectedUser->Active == 'Y') {
                                                echo 'checked';
                                            }
                                        } else {
                                            echo "checked";
                                        }?> >
                                        <label for="active"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="userName" class="col-sm-4 col-form-label col-form-label-sm">User Name(used for login)</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="userName" name="userName" required placeholder="User Name" value="{{$selectedUser->UserName ?? ''}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="password" class="col-sm-4 col-form-label col-form-label-sm">Password</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="User Name" {{isset($selectedUser->Password) ? 'readonly' : ' required' }}>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="project" class="col-sm-4 col-form-label col-form-label-sm">User
                                    Projects</label>

                                <div class="col-sm-8">
                                    <select class="multiselect form-control form-control-sm" name="project[]" id="project" multiple="multiple" required>
                                        @foreach($projects as $project)
                                            <option value="{{$project['ProjectID']}}"
                                                {{(isset($userProject) && in_array($project['ProjectID'],$userProject)) ? 'selected' : ''}}
                                            >{{$project['project']['ProjectName']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="business" class="col-sm-4 col-form-label col-form-label-sm">User Business</label>
                                <div class="col-sm-8">
                                    <select class="multiselect" name="business[]" id="business" multiple="multiple" required>
                                        @if(isset($businesses))
                                            @foreach($businesses as $business)
                                                <option value="{{$business['Business']}}"
                                                    {{(isset($userBusiness) && in_array($business['Business'],$userBusiness)) ? 'selected' : ''}}
                                                >{{$business['business']['BusinessName']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"><i class="fa fa-paper-danger"></i> {{isset($selectedUser) ? 'Update' : 'Add'}}</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User List</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0" style="height: 300px">
                    <table class="table table-hover table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Staff ID</th>
                                <th>Designation</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key=>$user)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$user->Name}}</td>
                                    <td>{{$user->StaffId}}</td>
                                    <td>{{$user->Designation}}</td>
                                    <td>{{$user->Active}}</td>
                                    <td>
                                        <a class="btn btn-default btn-sm pt-0 pb-0" href="{{url('user-list',$user->UserId)}}">Edit</a>
                                        <a class="btn btn-danger btn-sm pt-0 pb-0" href="{{url('manage-menu-permission',$user->UserId)}}">Add Permission</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
                    userName: {
                        required: true,
                        maxlength: 255
                    },
                    designation: {
                        required: true,
                        maxlength: 250
                    },
                },
            });
        });
    </script>
@endsection
