@extends('layouts.master')

@section('title','Dashboard | '.config('app.name'))

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Delivery Charge</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Delivery Charge</a></li>
                        <li class="breadcrumb-item active">List</li>
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
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Delivery Charge List</h3>
                            @if (count($delivery_charge) > 1)

                            @else
                                <div class="card-tools">
                                    <a href="{{ route('delivery.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Add
                                    </a>
                                </div>
                            @endif

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Delivery Charge</th>
                                        <th>Limit</th>
                                        <th>Destination Name</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($delivery_charge as $key => $value)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $value->DeliveryCharge }}</td>
                                            <td>{{ $value->Limit }}</td>
                                            <td>{{ $value->DestinationName }}</td>
                                            <td>{{ $value->CreatedAt }}</td>
                                            <td>
                                                <a class="btn btn-outline-success btn-sm" href="{{ route('delivery.edit', $value->DeliveryChargeId) }}" data-toggle="tooltip" title="View Order Details"><i class="fa fa-edit"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
@endsection
