@extends('layouts.master')

@section('title','Menu List | '. title())

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4>Menu List</h4>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <a href="{{ route('menu-list.create') }}" class="btn btn-success btn-xs">Add Menu</a>
                    </h3>
{{--                    <div class="card-tools">--}}
{{--                        <div class="input-group input-group-sm" style="width: 150px;">--}}
{{--                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">--}}
{{--                            <div class="input-group-append">--}}
{{--                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive">
                    <table class="table table-hover text-nowrap table-bordered table-sm small">
                        <thead>
                        <tr>
                            <th class="text-center">SN</th>
                            <th class="text-center">Menu Name</th>
                            <th class="text-center">Sub Menu Name</th>
                            <th class="text-center">Link</th>
                            <th class="text-center">MenuOrder</th>
                            <th class="text-center">Active</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($menus as $key=>$menu)
                            <tr>
                                <td class="text-center">{{ ++$key }}</td>
                                <td class="text-center">{{$menu->MenuName}}</td>
                                <td class="text-center">{{$menu->SubMenuName}}</td>
                                <td class="text-center">{{$menu->Link}}</td>
                                <td class="text-center">{{$menu->MenuOrder}}</td>
                                <td class="text-center">{{$menu->Active}}</td>
                                <td class="text-center">
                                    <a class="btn btn-default btn-sm" href="{{route('menu-list.edit',$menu->MenuId)}}">Edit</a>
{{--                                    <a class="btn btn-warning btn-sm" href="{{url('user-delete',$menu->MenuId)}}">Delete</a>--}}
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
