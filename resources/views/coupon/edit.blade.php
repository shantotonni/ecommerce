@extends('layouts.master')

@section('title','Coupon Edit | '.config('app.name'))

@push('css')
    <link rel="stylesheet" href="{{asset('public/plugins/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap-datepicker3.min.css') }}">
@endpush

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Coupon Edit</h3>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Coupon</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form class="form-validation form-horizontal" method="post" action="{{ route('coupon.update',$coupon->CouponID) }}">
                        @csrf
                        <div class="card-body row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-4 col-form-label col-form-label-sm">Coupon Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" id="CouponName" value="{{ $coupon->CouponName }}" name="CouponName" placeholder="Coupon Name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="staffId" class="col-sm-4 col-form-label col-form-label-sm">Coupon Code</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" value="{{ $coupon->CouponCode }}" id="CouponCode" name="CouponCode" placeholder="Coupon Code" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="designation"
                                           class="col-sm-4 col-form-label col-form-label-sm">Offer</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" value="{{ $coupon->Offer }}" id="Offer" name="Offer" placeholder="Offer" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="designation"
                                           class="col-sm-4 col-form-label col-form-label-sm">Limit</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" value="{{ $coupon->Limit }}" id="Limit" name="Limit" placeholder="Limit" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="designation"
                                           class="col-sm-4 col-form-label col-form-label-sm">Status</label>
                                    <div class="col-sm-8">
                                        <select name="Status" class="form-control" id="Status">
                                            <option>Select Status</option>
                                            @if ($coupon->Status == 'active')
                                                <option value="active" selected>Active</option>
                                                <option value="inactive">Inactive</option>
                                            @else
                                                <option value="active">Active</option>
                                                <option value="inactive" selected>Inactive</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php
                            /*
                            ?>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="product_id" class="col-sm-4 col-form-label col-form-label-sm">Select Product</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="product_id[]" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                                            @if(isset($products))
                                                @foreach($products as $product)
                                                    @foreach($coupon->couponProduct as $coupon_product)
                                                        <option value="{{ $product->ProductCode }}"
                                                        <?php
                                                            if ($product->ProductCode == $coupon_product->ProductID) {
                                                                echo "selected";
                                                            }
                                                            ?>
                                                        >{{ $product->ProductName }}</option>
                                                    @endforeach
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <?php */ ?>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="designation"
                                           class="col-sm-4 col-form-label col-form-label-sm">Coupon Amount</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control form-control-sm" value="{{ $coupon->CouponAmount }}" id="CouponAmount" name="CouponAmount" placeholder="Coupon Amount" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="designation"
                                           class="col-sm-4 col-form-label col-form-label-sm">Expired Date</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" id="CouponExpiredDate" name="CouponExpiredDate" placeholder="Coupon Expired Date" required value="{{ $coupon->CouponExpiredDate }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="project" class="col-sm-4 col-form-label col-form-label-sm">User Project</label>

                                    <div class="col-sm-8">
                                        <select class="form-control form-control-sm" name="ProjectID" id="project" required>
                                            @foreach($projects as $project)
                                                <option value="{{$project->ProjectID}}">{{ $project->ProjectName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success float-right">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('jquery')
    <script src="{{asset('public/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{ asset('public/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $('.select2').select2();
        $("#CouponExpiredDate").datepicker({
            format: 'yyyy-mm-dd 00:00:00',
            autoclose: true,
        });
    </script>
@endsection
