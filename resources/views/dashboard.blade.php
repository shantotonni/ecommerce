@extends('layouts.master')

@if(\Illuminate\Support\Facades\Auth::user()->UserName == "mrinmoy")
    <?php
        $title = "ACI-Ricebazar";
    ?>
@endif
@if(\Illuminate\Support\Facades\Auth::user()->UserName == "wahid")
    <?php
    $title = "ACI-Premio Plastic";
    ?>
@endif
@if(\Illuminate\Support\Facades\Auth::user()->UserName == "luthfor")
    <?php
    $title = "ACI-Ebazar";
    ?>
@else
    <?php
    $title = "ACI-Ebazar";
    ?>
@endif

@section('title','Dashboard | '.$title)

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Order</span>
                            <span class="info-box-number">
                              {{ count($total_order) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Delivery (in amount)</span>
                            <span class="info-box-number">{{ $total_delivered->sum('GrandTotal') }}</span>
                        </div>
                    </div>
                </div>

                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Pending (in amount)</span>
                            <span class="info-box-number">{{ $total_pending->sum('GrandTotal') }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Traffics</span>
                            <span class="info-box-number">{{ count($total_customer) }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-md-12">
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="card">
                        <div class="card-header border-transparent">
                            <h3 class="card-title">Latest Orders</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                    <tr>
                                        <th>Invoice No</th>
                                        <th>Invoice Date</th>
                                        <th>Customer Name</th>
                                        <th>Customer Number</th>
                                        <th>Customer ID</th>
                                        <th>Total Amount</th>
                                        <th>Discount Amount</th>
                                        <th>Grand Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($latest_order as $order)
                                        <tr>
                                            <td>{{ $order->InvoiceNo }}</td>
                                            <td>{{ $order->InvoiceDate }}</td>
                                            <td>{{ $order->CustomerName }}</td>
                                            <td>{{ $order->CustomerMobileNo }}</td>
                                            <td>{{ $order->CustomerID }}</td>
                                            <td>{{ $order->TotalAmount }}</td>
                                            <td>{{ number_format($order->DiscountAmount,2) }}</td>
                                            <td>{{ $order->GrandTotal }}</td>
                                            <td>{{ isset($order->invoiceStatus) ? $order->invoiceStatus->InvStatus: '' }}</td>
                                            <td>
                                                <a class="btn btn-outline-warning btn-sm" href="{{ route('order.details', $order->InvoiceNo) }}" data-toggle="tooltip" title="View Order Details"><i class="fa fa-eye"></i></a>
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
