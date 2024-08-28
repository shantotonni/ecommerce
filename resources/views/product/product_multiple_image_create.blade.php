@extends('layouts.master')

@section('title','Add Product Multiple Image | '.config('app.name'))

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Add Product Image</h3>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h4>Product Name : {{ $product->ProductName }}</h4>
                    <form action="{{route('product.multiple.image.store',$product->ProductCode)}}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="project">Add Single or Multiple Image</label>
                                <input type="file" class="form-control" name="ImageFileName[]" multiple>
                            </div>

                            <div class="form-group col-md-2">
                                <button type="submit" class="btn btn-primary" style="margin-top: 32px;">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Image List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 700px">
                    <table class="table table-hover table-head-fixed text-nowrap">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Product Name</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <?php
                       // dd($imageUrl);
                        ?>
                        <tbody>
                        @if(isset($product))
                            @foreach($product->productImage as $key => $product_image)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $product->ProductName }}</td>
                                    <td><img src="{{ $imageUrl.'/'.$product_image->ImageFileName }}" alt="{{ $product_image->ImageFileName }} " width="50"></td>
                                    <td>
                                        <a href="{{ route('product.multiple.image.delete',$product_image->ProductImageID) }}" class="btn btn-outline-danger btn-sm" title="Edit Product Info" data-toggle="tooltip" ><i class="fa fa-trash"></i></a>
                                    </td>

                                </tr>
                            @endforeach
                        @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('jquery')
    <script>
        $(document).ready(function () {
            // jQuery Form Validation
            $('.form-validation').validate({});
        });
    </script>
@endsection
