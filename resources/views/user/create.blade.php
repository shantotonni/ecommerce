@extends('layouts.master')

@section('title','User Create | '. title())

@push('css')
    <link rel="stylesheet" href="{{ asset('public/plugins/select2/css/select2.min.css') }}">
@endpush

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4>User Create</h4>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('user.store') }}">
                        @csrf
                        <div class="card-body row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="staffId">Staff Id</label>
                                    <input type="number" class="form-control" id="staffId" name="staffId" placeholder="Staff Id" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="designation">Designation</label>
                                    <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="userName">User Name(used for login)</label>
                                    <input type="text" class="form-control" id="userName" name="userName" required placeholder="User Name">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="projectId">User Projects</label>
                                    <select class="form-control" name="projectId" id="project" required>
                                        @foreach($projects as $project)
                                            <option value="{{$project['ProjectID']}}" >{{$project['project']['ProjectName']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="business">User Business</label>
                                    <select class="form-control" name="business" id="business" required>
                                        @if(isset($businesses))
                                            @foreach($businesses as $business)
                                                <option value="{{$business['Business']}}">{{$business['business']['BusinessName']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="District">District</label>
                                    <select class="form-control" name="District" id="District" required>
                                        @foreach($districts as $district)
                                            <option value="{{ $district->DistrictCode }}">{{ ucfirst($district->DistrictName) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label></label>
                                    <div class="select2-purple">
                                        <select id="Thana" name="Thana[]" class="select2" multiple="multiple" data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="active">Active</label>
                                    <input type="checkbox" name="active" id="active" checked class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2" style="margin-top: 30px">
                                <button type="submit" class="btn btn-info"><i class="fa fa-paper-danger"></i> Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('jquery')
    <!-- Select2 -->
    <script src="{{ asset('public/plugins/select2/js/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            $("#District").change(function(){
                var district = $("#District").val();
                $.ajax({
                    type: "POST",
                    url: "{{ url('district/wise/thana') }}",
                    data: { district : district }
                }).done(function(data){
                    console.log(data);
                    $("#Thana").html(data);
                });
            });

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
            //Initialize Select2 Elements
            $('.select2').select2()
        });
    </script>
@endsection
