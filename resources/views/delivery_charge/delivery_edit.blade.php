@extends('layouts.master')

@section('title','Delivery Charge Edit | '.config('app.name'))

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Delivery Charge Edit</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Delivery Charge</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Delivery Charge Edit</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="col-md-12">
                                <form action="{{ route('delivery.update',$delivery_charge->DeliveryChargeId) }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="number" class="form-control" name="DeliveryCharge" value="{{ $delivery_charge->DeliveryCharge }}" autocomplete="off" placeholder="Delivery Charge"/>
                                                </div>
                                                @if ($errors->has('DeliveryCharge'))
                                                    <div class="error" style="color: red">{{ $errors->first('DeliveryCharge') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="number" class="form-control" name="Limit" value="{{ $delivery_charge->Limit }}" autocomplete="off" placeholder="Limit"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <select name="DestinationName" class="form-control" id="DestinationName">
                                                    <option value="">Select Destination</option>
                                                    @if ($delivery_charge->DestinationName == 'in_dhaka')
                                                        <option value="in_dhaka" selected>In Dhaka</option>
                                                        <option value="out_dhaka">Outside Dhaka</option>
                                                    @elseif ($delivery_charge->DestinationName == 'out_dhaka')
                                                        <option value="in_dhaka">In Dhaka</option>
                                                        <option value="out_dhaka" selected>Outside Dhaka</option>
                                                    @else
                                                        <option value="in_dhaka">In Dhaka</option>
                                                        <option value="out_dhaka">Outside Dhaka</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <div class="form-group">
                                                    <select name="ProjectID" class="form-control" id="ProjectID">
                                                        @foreach($projects as $value)
                                                            <option value="{{ $value->ProjectID }}">{{ $value->ProjectName }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('ProjectID'))
                                                        <div class="error" style="color: red">{{ $errors->first('ProjectID') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-success">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
@endsection
