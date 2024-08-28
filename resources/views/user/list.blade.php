@extends('layouts.master')

@section('title','User Manage | '. title())

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4>User Manager List</h4>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <a href="{{ route('user.create') }}" class="btn btn-success btn-xs">Add User</a>
                    </h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">
                    <table class="table table-hover text-nowrap table-bordered table-sm small">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">User Name</th>
                                <th class="text-center">Staff ID</th>
                                <th class="text-center">Designation</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $key=>$user)
                                <tr>
                                    <td class="text-center">{{$key+1}}</td>
                                    <td class="text-center">{{$user->Name}}</td>
                                    <td class="text-center">{{$user->UserName}}</td>
                                    <td class="text-center">{{$user->StaffId}}</td>
                                    <td class="text-center">{{$user->Designation}}</td>
                                    <td class="text-center">{{$user->Active}}</td>
                                    <td class="text-center">
                                        <a class="btn btn-default btn-sm" href="{{url('user-edit',$user->UserId)}}">Edit</a>
                                        <a class="btn btn-warning btn-sm" href="{{url('user-delete',$user->UserId)}}">Delete</a>
                                        <a class="btn btn-danger btn-sm" href="{{url('user-menu-permission',$user->UserId)}}">Add Permission</a>
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
