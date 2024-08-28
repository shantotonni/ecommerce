@extends('layouts.master')

@section('title','Product Review | '.config('app.name'))

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3> Product Review List</h3>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Product Review List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 700px">
                    <table class="table table-hover table-head-fixed text-nowrap">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Product</th>
                            <th>Product Code</th>
                            <th>Price</th>
                            <th>Final Price</th>
                            <th>Category Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($products))
                            @foreach($products as $key=>$product)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$product->ProductName}}</td>
                                    <td>{{$product->ProductCodeSystem}}</td>
                                    <td>{{$product->ItemPrice}}</td>
                                    <td>{{$product->ItemFinalPrice}}</td>
                                    <td>{{$product->category->Category ?? ''}}</td>
                                    <td>
                                        @if($product->ProductStatus=='Y')
                                            <span class="badge badge-success">Active </span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif</td>
                                    <td>
                                    <td>
                                        <a class="btn btn-outline-warning btn-sm" title="Product View" data-toggle="tooltip" href="{{ route('product.review.details',$product->ProductCode) }}"><i class="fa fa-eye"></i></a>
                                    </td>

                                </tr>
                            @endforeach
                        @endif


                        </tbody>
                    </table>
                    {{$products->links()}}
                </div>
                <!-- /.card-body -->
            </div>


        </div>


        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                  <h4 class="modal-title">Add Product Stock Quantity</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form method="POST" action="{{ url('product/product-stock-add') }}">
                    @csrf
                <div class="modal-body">
                    <p id="specificProductName"></p>
                    <p >Available Stock : <span id="specificProductStock" class="text-info"></span></p>
                  <input type="hidden" value="" name="productCode" id="productCode">
                  <input type="hidden" value="" name="projectId" id="projectId">
                  <input type="number" class="form-control" name="newQuantity" id="newQuantity" value="" placeholder="New Stock Quantity">

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>

              </div>
            </div>
          </div>

    </section>
@endsection
@section('jquery')
    <script src="{{asset('public/plugins/jquery.chained.js')}}"></script>
    <script>
        $(document).ready(function () {
            // jQuery Form Validation
            // $('.form-validation').validate({});
            $("#subCategoryId").chained("#categoryId");

            $(".add-product-stock-btn").on('click',function(){
                $("#projectId").val($(this).data('project-id'));
                $("#productCode").val($(this).data('product-code'));
                $("#specificProductName").text($(this).data('product-name'));
                $("#specificProductStock").text($(this).data('product-stock'));
            });
        });
    </script>
@endsection
