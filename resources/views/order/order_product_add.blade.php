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
                    <form action="{{ route('existing.order.store.product') }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="project">Product Name</label>
                                <select name="product_id" id="product_id" class="form-control">
                                    @foreach($products as $product)
                                        <option value="{{ $product->ProductCode }}">{{ $product->ProductName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="invoice_no" value="{{ $InvoiceNo }}">
                            <div class="form-group col-md-2">
                                <label for="project">Quantity</label>
                                <input type="number" name="Quantity" class="form-control">
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
