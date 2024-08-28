@extends('layouts.master')

@section('title','Order Details Edit | ')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Orders Details Edit</h3>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('order.details.update') }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="project">Product Name</label>
                                <input type="text" class="form-control" readonly name="product_name" value="{{ $product->ProductName }}">
                            </div>
                            <input type="hidden" name="product_code" value="{{ $productCode }}">
                            <input type="hidden" name="invoice_no" value="{{ $invoiceNo }}">
                            <input type="hidden" name="old_quantity" value="{{ $invoice_details->Quantity }}">
                            <div class="form-group col-md-2">
                                <label for="project">Quantity</label>
                                <input type="number" value="{{ $invoice_details->Quantity }}" name="Quantity" class="form-control">
                            </div>
                            <div class="form-group col-md-2">
                                <button type="submit" class="btn btn-primary" style="margin-top: 32px;">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('jquery')

@endsection
