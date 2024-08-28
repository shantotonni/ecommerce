@extends('layouts.master')

@section('title','Coupon List | '.config('app.name'))

@push('css')

@endpush

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>All Coupons</h3>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <form action="{{ route('coupon.index') }}">
                        {{ csrf_field() }}
                        <div class="col-sm-4" style="display: flex">
                            <input type="text" class="form-control" name="search" placeholder="Search">
                            <button class="btn btn-success">Filter</button>
                        </div>
                    </form>
                    <a href="{{ route('coupon.create') }}" class="btn btn-success float-right">Add Coupon</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Offer Name</th>
                                <th>Coupon Code</th>
                                <th>Coupon Expired Date</th>
                                <th>Offer(%)</th>
                                <th>OfferType</th>
                                <th>Limit</th>
                                <th>Sold</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($coupons as $key => $coupon)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $coupon->CouponName }}</td>
                                <td>{{ $coupon->CouponCode }}</td>
                                <td>{{ $coupon->CouponExpiredDate }}</td>
                                <td>{{ $coupon->Offer }}</td>
                                <td>{{ $coupon->OfferType }}</td>
                                <td>{{ $coupon->Limit }}</td>
                                <td>{{ $coupon->Sold }}</td>
                                <td>
                                    @if($coupon->Status == 'active')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $coupon->CreatedAt }}</td>
                                <td>
                                    <a class="btn btn-primary btn-sm pt-0 pb-0" href="{{ route('coupon.edit',$coupon->CouponID) }}">Edit</a>
                                    @if ($coupon->Status == 'active')
                                        <a class="btn btn-warning btn-sm pt-0 pb-0" href="{{ route('coupon.active_inactive',$coupon->CouponID) }}">Inactive</a>
                                    @else
                                        <a class="btn btn-success btn-sm pt-0 pb-0" href="{{ route('coupon.active_inactive',$coupon->CouponID) }}">Active</a>
                                    @endif
                                    <a class="btn btn-danger btn-sm pt-0 pb-0" onclick="return confirm(' you want to delete?');" href="{{ route('coupon.delete',$coupon->CouponID) }}">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$coupons->links()}}
                </div>
            </div>
        </div>
    </section>

@endsection
@section('jquery')

@endsection
