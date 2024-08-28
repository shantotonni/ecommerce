
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('public/plugins/fontawesome/css/all.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/plugins/select2/select2.min.css')}}">
    {{--    Bootstratp bultiselect--}}
    <link rel="stylesheet" href="{{asset('public/css/bootstrap-multiselect.css')}}">
    <link rel="stylesheet" href="{{asset('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    @stack('css')
<!-- Theme style -->
    <link rel="stylesheet" href="{{asset('public/css/adminlte.min.css')}}">

    {{--    Custom Style--}}
    <link rel="stylesheet" href="{{asset('public/css/custom.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/css/toastr.min.css') }}">
    <style>
        thead{
            background: black;
            color: white;
        }
        ul li{
            font-size: 14px;
        }
    </style>
</head>

<style>
    @media print {
        @page { margin: 0; }
        body { margin: 1.6cm; }
    }
</style>
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

<body>
<div class="wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @if(\Illuminate\Support\Facades\Auth::user()->UserName == "abrar")
                    <img src="{{ asset('public/logo/aronno.jpg') }}" alt="logo" height="62">
                @endif
                    @if(\Illuminate\Support\Facades\Auth::user()->UserName == "aronno")
                        <img src="{{ asset('public/logo/aronno.jpg') }}" alt="logo" height="62">
                    @endif
                @if(\Illuminate\Support\Facades\Auth::user()->UserName == "premio")
                    <img src="{{ asset('public/logo/premio.png') }}" alt="logo" height="62">
                @endif
                <div class="col-12">
                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
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
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr style="color: black">
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>VAT</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($invoice->invoiceDetail as $key => $item)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $item->ProductName }}</td>
                                            <td>{{ $item->ItemPrice }} TK</td>
                                            <td>{{ $item->VAT }} TK</td>
                                            <td style="font-weight: bold;font-size: 20px">{{ $item->Quantity }}</td>
                                            <td>{{ $item->Quantity * $item->ItemFinalPrice }} TK</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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
                                        <tbody>
                                        <tr>
                                            <th >Subtotal(<span style="font-size: 11px">Included Discount</span>):</th>
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
                                            <td style="font-weight: bold;font-size: 20px">{{ ($invoice->TotalAmount + $invoice->DeliveryCharge) }} TK</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    window.addEventListener("load", window.print());
</script>
</body>

