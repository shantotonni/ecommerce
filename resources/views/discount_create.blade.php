@extends('layouts.master')

@section('title','Discount Create | '.config('app.name'))

@push('css')
    <style>
        .error{
            color: red!important;
        }
    </style>
@endpush

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Discount Create</h3>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Discount</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form class="form-validation form-horizontal" method="post" action="{{ route('discount.store') }}">
                        @csrf
                        <div class="card-body row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="project" class="col-sm-4 col-form-label col-form-label-sm">User Project</label>

                                    <div class="col-sm-8">
                                        <select class="form-control form-control-sm" name="ProjectID" id="ProjectID" required>
                                            @foreach($projects as $project)
                                                <option value="{{$project->ProjectID}}">{{ $project->ProjectName }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('ProjectID'))
                                            <div class="error">{{ $errors->first('ProjectID') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="discountType" class="col-sm-4 col-form-label col-form-label-sm">Discount Type</label>
                                    <div class="col-sm-8">
                                        <select class="form-control form-control-sm" id="discountType" name="discountType" required>
                                            <option value="percentage">Percentage</option>
                                            <option value="flat">Flat</option>
                                        </select>
                                        @if($errors->has('discountType'))
                                            <div class="error">{{ $errors->first('discountType') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="designation"
                                           class="col-sm-4 col-form-label col-form-label-sm">Discount</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" id="discount" name="discount" placeholder="Enter Discount" required>
                                        @if($errors->has('discount'))
                                            <div class="error">{{ $errors->first('discount') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="product_id" class="col-sm-4 col-form-label col-form-label-sm">Select Product</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="product_id[]" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                                            @if(isset($products))
                                                <option value="all_products">All Products</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->ProductCode }}">{{ $product->ProductName }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @if($errors->has('product_id'))
                                            <div class="error">{{ $errors->first('product_id') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success float-right">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('jquery')

    <script>
        $('.select2').select2()
    </script>
@endsection
