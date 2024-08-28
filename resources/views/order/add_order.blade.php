@extends('layouts.master')

@section('title','Order Add | '.config('app.name'))

@push('css')
    <link rel="stylesheet" href="{{ asset('public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap-datepicker3.min.css') }}">
@endpush

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Order Add</h3>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Order Add</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('order.store') }}" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="ProductCode" class="col-sm-4 col-form-label col-form-label-sm">Select Product</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="ProductCode[]" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                                            @if(isset($products))
                                                @foreach($products as $product)
                                                    <option value="{{ $product->ProductCode }}">{{ $product->ProductName }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if($errors->has('ProductCode'))
                                            <div class="error">{{ $errors->first('ProductCode') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" name="FirstName" required>
                                    @if($errors->has('FirstName'))
                                        <div class="error">{{ $errors->first('FirstName') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" name="LastName" required>
                                    @if($errors->has('LastName'))
                                        <div class="error">{{ $errors->first('LastName') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" name="CustomerEmail" required>
                                    @if($errors->has('CustomerEmail'))
                                        <div class="error">{{ $errors->first('CustomerEmail') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>District</label>
                                    <select class="form-control" name="District" id="District" required>
                                        <option value="">Select District</option>
                                        @foreach($districts as $district)
                                            <option value="{{ $district->DistrictCode }}">{{ $district->DistrictName }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('District'))
                                        <div class="error">{{ $errors->first('District') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Thana / Area:</label>
                                    <select class="form-control" id="Thana" name="Thana" required>

                                    </select>
                                    @if($errors->has('Thana'))
                                        <div class="error">{{ $errors->first('Thana') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Delivery Address</label>
                                    <input type="text" class="form-control" name="DeliveryAddress" required>
                                    @if($errors->has('DeliveryAddress'))
                                        <div class="error">{{ $errors->first('DeliveryAddress') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Delivery Charge</label>
                                    <input type="text" class="form-control" name="DeliveryCharge" required>
                                    @if($errors->has('DeliveryCharge'))
                                        <div class="error">{{ $errors->first('DeliveryCharge') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>MobileNo</label>
                                    <input type="text" class="form-control" name="CustomerMobileNo" required>
                                    @if($errors->has('CustomerMobileNo'))
                                        <div class="error">{{ $errors->first('CustomerMobileNo') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2" style="padding-top: 30px">
                                <div class="form-group">
                                    <button class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php
        $user = \Illuminate\Support\Facades\Auth::user();
        $state = '';
        if ($user->project[0]->ProjectID == 3) {
            $state = true;
        }else{
            $state = false;
        }
    ?>
@endsection
@section('jquery')
    <script>
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
    </script>

    <script>
        $('.select2').select2()
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#from-date").datepicker({
            format: 'yyyy-mm-dd 00:00:00',
            autoclose: true,
        });

        $("#to-date").datepicker({
            format: 'yyyy-mm-dd 23:59:59',
            autoclose: true,
        });

    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    </script>
@endsection
