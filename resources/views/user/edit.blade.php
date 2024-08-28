@extends('layouts.master')

@section('title','User Edit | '. title())

@push('css')
    <link rel="stylesheet" href="{{ asset('public/plugins/select2/css/select2.min.css') }}">
@endpush

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4>User Edit</h4>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('user.update',$user->UserId) }}">
                        @csrf
                        <div class="card-body row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->Name }}" placeholder="Name" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="staffId">Staff Id</label>
                                    <input type="number" class="form-control" id="staffId" name="staffId" value="{{ $user->StaffId }}" placeholder="Staff Id" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="designation">Designation</label>
                                    <input type="text" class="form-control" id="designation" name="designation" value="{{ $user->Designation }}" placeholder="Designation" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="userName">User Name(used for login)</label>
                                    <input type="text" class="form-control" id="userName" name="userName" value="{{ $user->UserName }}" required placeholder="User Name">
                                </div>
                            </div>
                            <?php
                                if (count($user->thana) > 0){
                                    $discode = $user->thana[0]->DistrictCode;
                                }else{
                                    $discode = '';
                                }
                            ?>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="District">District</label>
                                    <select class="form-control" name="District" id="District" required>
                                        @foreach($districts as $district)
                                            @if($discode == $district->DistrictCode)
                                                <option value="{{ $district->DistrictCode }}" selected>{{ ucfirst($district->DistrictName) }}</option>
                                            @else
                                                <option value="{{ $district->DistrictCode }}">{{ ucfirst($district->DistrictName) }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="form-group">
                                    <label>Thana</label>
                                    <div class="select2-purple">
                                        <select id="Thana" name="Thana[]" class="select2" multiple="multiple" required data-placeholder="Select a State" data-dropdown-css-class="select2-purple" style="width: 100%;">
                                            @foreach($thanas as $thana)
                                                @if(in_array($thana->UpazillaCode,$user_thana))
                                                    <option value="{{ $thana->UpazillaCode }}" selected>{{ ucfirst($thana->UpazillaName) }}</option>
                                                @else
                                                    <option value="{{ $thana->UpazillaCode }}">{{ ucfirst($thana->UpazillaName) }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Active">Status</label>
                                    <select name="Active" id="" class="form-control">
                                        <option value="">Select Status</option>
                                        @if($user->Active == 'Y')
                                        <option value="Y" selected>Active</option>
                                        <option value="N">Inactive</option>
                                        @else
                                            <option value="Y">Active</option>
                                            <option value="N" selected>Inactive</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2" style="margin-top: 30px">
                                <button type="submit" class="btn btn-info"><i class="fa fa-paper-danger"></i> Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('jquery')
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
                    $("#Thana").html(data);
                });
            });

            //Initialize Select2 Elements
            $('.select2').select2()
        });
    </script>
@endsection
