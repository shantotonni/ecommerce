@extends('layouts.master')
@if(\Illuminate\Support\Facades\Auth::user()->UserName == "mrinmoy")
    <?php
    $title = "ACI-Ricebazar";
    ?>
@endif
@if(\Illuminate\Support\Facades\Auth::user()->UserName == "premio")
    <?php
    $title = "ACI-Premio Plastic";
    ?>
@endif
@if(\Illuminate\Support\Facades\Auth::user()->UserName == "ebazar")
    <?php
    $title = "ACI-Ebazar";
    ?>
@endif
@if(\Illuminate\Support\Facades\Auth::user()->UserName == "sonalika")
    <?php
    $title = "ACI-Sonalika";
    ?>
@endif
@if(\Illuminate\Support\Facades\Auth::user()->UserName == "hygiene")
    <?php
    $title = "ACI-Hygiene";
    ?>
@endif
@if(\Illuminate\Support\Facades\Auth::user()->Site == "aronno")
    <?php
    $title = "ACI-Aronno";
    ?>
@endif
@if(\Illuminate\Support\Facades\Auth::user()->UserName == "alam")
    <?php
    $title = "ACI Aronno";
    ?>
@endif
@if(\Illuminate\Support\Facades\Auth::user()->UserName == "abrar")
    <?php
    $title = "ACI Aronno";
    ?>
@endif

@section('title','Order Details | '.$title)

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Orders</h3>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-globe"></i> Order Details of #{{ $invoice->InvoiceNo }}
                                    <small class="float-right"><a href="{{ route('order.index') }}" class="btn btn-primary btn-sm">BACK</a></small>
{{--                                    <small class="float-right" style="margin-right: 10px"><a href="{{ route('order.edit', $invoice->InvoiceNo) }}" class="btn btn-primary btn-sm">Edit</a></small>--}}
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-3 invoice-col">
                                From
                                <address>
                                    <strong>{{ $title }}</strong><br>
                                    Address: 245, Tejgaon Industrial Area<br>
                                    Dhaka 1208, Bangladesh<br>
                                    Phone: 09606 666 678
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 invoice-col">
                                To
                                <address>
                                    <strong>{{ $invoice->CustomerName }}</strong><br>
                                    {{ $invoice->DeliveryAddress }}<br>
                                    {{ $invoice->ThanaName }}, {{ $invoice->DistrictName }}<br>
                                    Phone: {{ $invoice->CustomerMobileNo }}<br>
                                    Email: {{ $invoice->CustomerEmail }}
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 invoice-col">
                                <b>Invoice #{{ $invoice->InvoiceNo }}</b><br>
                                <br>
                                <b>Invoice Date:</b> {{ $invoice->InvoiceDate }}<br>
                            </div>
                            <!-- /.col -->
                            <!-- /.col -->
                            <div class="col-sm-3 invoice-col">
                                <b>Invoice Status</b><br>
                                <br>
                                <b>Status:</b> {{ $invoice->invoiceStatus->InvStatus }}<br>
                                <b>Change status:</b>
                                <form action="{{ route('order.status.change',$invoice->InvoiceNo) }}" class="form-inline" method="post">
                                    {{ csrf_field() }}

                                    <select name="status_id" id="" class="form-control">
                                        <option value="">Select Status</option>
                                        @foreach($invoice_status as $status)
                                            @if ($invoice->InvStatusID == $status->InvStatusID)
                                                <option value="{{ $status->InvStatusID }}" selected>{{ $status->InvStatus }}</option>
                                            @else
                                                <option value="{{ $status->InvStatusID }}">{{ $status->InvStatus }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <button style="margin-left: 15px" type="submit" class="btn btn-success btn-sm">Change</button>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>VAT</th>
                                            <th>Quantity</th>
                                            <th>Total</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($invoice->invoiceDetail as $key => $item)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $item->ProductName }}</td>
                                                <td>{{ $item->ItemPrice }} TK</td>
                                                <td>{{ $item->VAT }} TK</td>
                                                <td>{{ $item->Quantity }}</td>
                                                <td>{{ $item->Quantity * $item->ItemFinalPrice }} TK</td>
                                                <td>
                                                    @if(Auth::user()->project[0]->ProjectID == 6 || Auth::user()->project[0]->ProjectID == 3)
                                                    <a class="btn btn-primary btn-sm pt-0 pb-0" href="{{ route('order.details.edit',['invoice_id'=>$invoice->InvoiceNo,'product_code'=>$item->ProductCode]) }}">Edit</a>
                                                    @endif
                                                    <a class="btn btn-danger btn-sm pt-0 pb-0" onclick="return confirm('you want to delete?');" href="{{ route('order.details.delete',['invoice_id'=>$invoice->InvoiceNo,'product_code'=>$item->ProductCode]) }}">Delete</a>
                                                </td>
                                            </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <a class="btn btn-primary btn-sm pt-0 pb-0" href="{{ route('existing.order.add.product', $invoice->InvoiceNo) }}">Add</a>
                            </div>
                        </div>

                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-6">
                                <p class="lead">Payment Methods:  Cash On Delivery</p>
                            </div>
                            <!-- /.col -->
                            <div class="col-6">
{{--                                <p class="lead">Amount Due 2/22/2014</p>--}}

                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody><tr>
                                            <th style="width:50%">Subtotal(<span style="font-size: 11px">Included Discount</span>):</th>
                                            <td>{{ $invoice->TotalAmount }} TK</td>
                                        </tr>
                                        <tr>
                                            <th>Delivery Charge:</th>
                                            <td>{{ $invoice->DeliveryCharge }} TK</td>
                                        </tr>
{{--                                        <tr>--}}
{{--                                            <th>Discount:</th>--}}
{{--                                            <td>--}}
{{--                                                @if(!empty($invoice->DiscountAmount) && isset($invoice->DiscountAmount) && $invoice->DiscountAmount > 0)--}}
{{--                                                    {{ $invoice->DiscountAmount }} TK--}}
{{--                                                @else--}}
{{--                                                    0.00 TK--}}
{{--                                                @endif--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
                                        <tr>
                                            <th>Total Vat:</th>
                                            <td>
                                                {{ $invoice->invoiceDetail->sum('VAT') }} TK
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Total Payable Amount:</th>
{{--                                            <td>{{ ($invoice->TotalAmount + $invoice->DeliveryCharge) - $invoice->DiscountAmount }} TK</td>--}}
                                            <td>{{ ($invoice->TotalAmount + $invoice->DeliveryCharge) }} TK</td>
                                        </tr>
                                        </tbody></table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- this row will not appear when printing -->
                        <div class="row">
                            <div class="col-12">
                                <a href="{{ route('order.invoice.print',$invoice->InvoiceNo) }}" target="_blank" class="btn btn-primary float-right"><i class="fas fa-print"></i> Print</a>
                            </div>
                        </div>
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

    </section>
@endsection
@section('jquery')

@endsection
