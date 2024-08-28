@extends('layouts.master')

@section('title','Product Review Details | '.config('app.name'))

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
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Review List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 700px">
                    <table class="table table-hover table-head-fixed text-nowrap">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>User Name</th>
                            <th>Rating</th>
                            <th>Comment</th>
                            <th>Approved</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($product))
                            @foreach($product->reviews as $key => $review)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $review->customer->CustomerFirstName }} {{ $review->customer->CustomerLastName }}</td>
                                    <td>{{ $review->Rating }}</td>
                                    <td>{{ $review->Comment }}</td>
                                    <td>
                                        @if ($review->Approved == 1)
                                            <span style="color: green;font-weight: bold">Yes</span>
                                        @else
                                            <span style="color: red;font-weight: bold">No</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($review->Approved == 1)
                                          <a href="{{ route('product.review.approved',$review->ReviewId) }}" class="btn btn-outline-danger btn-sm" title="Edit Product Info" data-toggle="tooltip" ><i class="fa fa-times"></i></a>
                                        @else
                                            <a href="{{ route('product.review.approved',$review->ReviewId) }}" class="btn btn-outline-success btn-sm" title="Edit Product Info" data-toggle="tooltip" ><i class="fa fa-check"></i></a>
                                        @endif
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
