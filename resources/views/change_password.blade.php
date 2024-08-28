@extends('layouts.master')

@section('title','Change Password | '.config('app.name'))

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Change Password</h3>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h4 class="card-title">Change Password</h4>
                </div>
                @include('common.validation_error')
                <form class="form-horizontal form-validation" method="post" action="{{ route('change.password') }}">
                    @csrf
                    <div class="card-body">
                        <div class="col-md-8 col-offset-3">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="previous_password" class="col-sm-4 col-form-label col-form-label-sm">Old password</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control form-control-sm" id="previous_password" name="previous_password" placeholder="Previous password" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="password" class="col-sm-4 col-form-label col-form-label-sm">New password:</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control form-control-sm" id="password" name="password"
                                        data-rule-not_same="[name='previous_password']" data-msg-not_same="New Password can not same as Old Password"
                                        placeholder="Password" required minlength="6">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="password_confirmation" class="col-sm-4 col-form-label col-form-label-sm">Confirm password:</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control form-control-sm" id="password_confirmation" name="password_confirmation"
                                        data-rule-equalTo="[name='password']" placeholder="Confirm password" required>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"><i class="fas fa-paper-plane"></i> Change</button>
                    </div>
                </form>
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
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    },
                },
            });
        });
    </script>
@endsection
