@extends('layouts.master')

@section('title','Product List | '.config('app.name'))

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>{{$featureName}} Manager</h3>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form action="{{url('product-list')}}">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="project">Project</label>
                                <select class="form-control form-control-sm" name="project" id="project">
                                    <option value="">--Select--</option>
                                    @foreach($projects as $project)
                                        <option value="{{$project['ProjectID']}}"
                                            {{(isset($selectedProject) && ($selectedProject==$project['ProjectID']) || (old('project')== $project['ProjectID'])) ? 'selected' : ''}}
                                        >{{$project['ProjectName']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="business">Business</label>
                                <select class="form-control form-control-sm" name="business" id="business">
                                    <option value="">--Select--</option>
                                    @foreach($businesses as $business)
                                        <option value="{{$business['Business']}}"
                                            {{(isset($selectedBusiness) && ($selectedBusiness==$business['Business']) || (old('business')== $business['Business'])) ? 'selected' : ''}}
                                        >{{$business['business']['BusinessName']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="categoryId">category</label>
                                <select class="form-control form-control-sm" name="categoryId" id="categoryId">
                                    <option value="">--Select--</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category['CategoryId']}}"
                                            {{(isset($selectedCategoryId) && ($selectedCategoryId == $category['CategoryId']) || (old('categoryId')== $category['CategoryId'])) ? 'selected' : ''}}
                                        >{{$category['Category']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="categoryId">Sub Category</label>
                                <select class="form-control form-control-sm" name="subCategoryId" id="subCategoryId">
                                    <option value="">--Select--</option>
                                    @foreach($subCategories as $subCategory)
                                        <option value="{{$subCategory['SubCategoryId']}}" class="{{ $subCategory['CategoryId'] }}"
                                            {{(isset($selectedSubCategoryId) && ($selectedSubCategoryId == $subCategory['SubCategoryId']) ||
                                             (old('subCategoryId')== $subCategory['SubCategoryId'])) ? 'selected' : ''}}
                                        >{{$subCategory['SubCategory']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="productName">Prodcut Name</label>
                                <input type="text" class="form-control form-control-sm" name="productName" id="productName" value="{{ $selectedProductName ?? '' }}">

                            </div>

                            <div class="form-group col-md-3">
                                <button type="submit" class="btn btn-sm btn-success btn-block" style="margin-top: 32px;">Search</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                @include('common.validation_error')
                <div class="card-header">
                    <h3 class="card-title">{{$featureName}} List</h3>
                    <a href="{{$action}}" class="btn btn-danger float-right">Add Product</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 700px">
                    <table class="table table-hover table-head-fixed text-nowrap">
                        <thead>
                        <tr>
                            <th class="text-center">SL</th>
                            <th>Product</th>
                            <th class="text-center">Product Code</th>
                            <th class="text-center">Price</th>
{{--                            <th>Vat</th>--}}
                            <th class="text-center">Discount</th>
                            <th class="text-center">Final Price</th>
                            <th class="text-center">Image</th>
                            <th class="text-center">Category Name</th>
                            <th class="text-center">Available Stock</th>
                            <th class="text-center">Sold Stock</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($products))
                            @foreach($products as $key=>$product)
                                <tr>
                                    <td class="text-center">{{$key+1}}</td>
                                    <td>{{$product->ProductName}}</td>
                                    <td class="text-center">{{$product->ProductCodeSystem}}</td>
                                    <td class="text-center">{{$product->ItemPrice}}</td>
{{--                                    <td>{{$product->VAT}}</td>--}}
                                    <td class="text-center">{{$product->Discount}}</td>
                                    <td class="text-center">{{$product->ItemFinalPrice}}</td>
                                    <td class="text-center"><img src="{{$imageUrl.'/'.$product->ProductImageFileName}}"
                                             alt="{{$product->ProductImageFileName}} " width="50"></td>
                                    <td class="text-center">{{$product->category->Category ?? ''}}</td>

                                    @php
                                    $available_stock = $product->stock ? intval($product->stock->Opening) : 0;
                                    $sold_stock = $product->stock ? intval($product->stock->Sales) : 0;
                                    @endphp

                                    <td class="text-center">{{ $available_stock }}</td>
                                    <td class="text-center">{{ $sold_stock }}</td>
                                    <td class="text-center">
                                        @if($product->ProductStatus=='Y')
                                            <span class="badge badge-success">Active </span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif</td>
                                    <td class="text-center">
                                    <td class="text-center">
                                        <button type="button" class="btn btn-outline-primary btn-sm add-product-stock-btn"
                                                data-product-code="{{ $product->ProductCode }}" data-project-id="{{ $product->project->ProjectID }}"
                                                data-product-name="{{ $product->ProductName }}" data-product-stock="{{ $available_stock }}"
                                                data-toggle="modal" data-target="#myModal" title="Add Product Stock">
                                            <i class="fas fa-cubes"></i>
                                        </button>

                                        <button type="button" class="btn btn-outline-primary btn-sm update-product-price-btn"
                                        data-product-code="{{ $product->ProductCode }}" data-project-id="{{ $product->project->ProjectID }}"
                                        data-toggle="modal" data-target="#updatePrice" title="Update Product Price">
                                            Update Price
                                          </button>

                                        <a class="btn btn-outline-warning btn-sm" title="Edit Product Info" data-toggle="tooltip"
                                           href="{{url($action,$product->ProductCode)}}"><i class="fa fa-edit"></i></a>

                                        <a class="btn btn-outline-warning btn-sm" title="Add, Edit, Delete Multiple image" data-toggle="tooltip"
                                           href="{{ route('product.multiple.image.create',$product->ProductCode) }}"><i class="fa fa-plus"></i></a>

{{--                                        <a class="btn btn-outline-warning btn-sm" title="Product View" data-toggle="tooltip"--}}
{{--                                           href="{{ route('product.view',$product->ProductCode) }}"><i class="fa fa-eye"></i></a>--}}

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
                </form>
              </div>
            </div>
          </div>

        <div class="modal fade" id="updatePrice">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Update Product Price</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <form method="POST" action="{{ url('product/product-price-update') }}">
                        @csrf
                        <div class="modal-body">
                            <p id="specificProductName"></p>
                            <input type="hidden" value="" name="productCode" id="productCode2">
                            <input type="hidden" value="" name="projectId" id="projectId2">
                            <input type="hidden" value="{{ $products->currentPage() }}" name="page" id="page">
                            <div class="form-group">
                                <input type="number" class="form-control" name="price" id="price" placeholder="New Price" required>
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" name="discount" id="discount" placeholder="Discount" required>
                            </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Update Price</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('jquery')
    <script src="{{asset('public/plugins/jquery.chained.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("#subCategoryId").chained("#categoryId");

            $(".add-product-stock-btn").on('click',function(){
                $("#projectId").val($(this).data('project-id'));
                $("#productCode").val($(this).data('product-code'));
                $("#specificProductName").text($(this).data('product-name'));
                $("#specificProductStock").text($(this).data('product-stock'));
            });

            $(".update-product-price-btn").on('click',function(){
                $("#projectId2").val($(this).data('project-id'));
                $("#productCode2").val($(this).data('product-code'));
            });
        });
    </script>
@endsection
