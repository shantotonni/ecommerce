@extends('layouts.master')

@section('title','Product Manage | '.config('app.name'))

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
            <div class="card card-info">
                <div class="card-header">
                    <h4 class="card-title">{{$featureName ?? ''}} {{$actionTitle ?? ''}}</h4>
                </div>
                @include('common.validation_error')
                <form class="form-horizontal form-validation" method="post" action="{{url($action)}}"
                      enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{$selectedProduct->ProductCode ?? ''}}" name="id">
                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="category" class="col-sm-4 col-form-label col-form-label-sm">Product
                                    Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="productName"
                                           name="productName" placeholder="Product Name"
                                           value="{{$selectedProduct->ProductName ?? old('productName')}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="image" class="col-sm-4 col-form-label col-form-label-sm">Product Image</label>
                                <div class="col-sm-8">
                                    <input accept="image/*" type="file" class="form-control form-control-sm" id="image" name="image">
                                    <span class="small text-info">Type:jpg,jpeg,png; Width:{{$maxWidth}}, Height: {{$maxHeight}}</span><br>
                                    @if(isset($selectedProduct->CategoryImage))
                                        <img src="{{$imageUrl.'/'.$selectedProduct->ProductImageFileName}}" alt="" width="100" height="50">
                                    @endif
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="project" class="col-sm-4 col-form-label col-form-label-sm">Project</label>

                                <div class="col-sm-8">
                                    <select class="form-control form-control-sm" name="project" id="project" required>
                                        <option value="">--Select--</option>
                                        @foreach($projects as $project)
                                            <option value="{{$project->ProjectID}}"
                                                {{(isset($selectedProduct->ProjectID) && ($selectedProduct->ProjectID==$project->ProjectID) || (old('project')== $project->ProjectID)) ? 'selected' : ''}}
                                            >{{$project->ProjectName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="business" class="col-sm-4 col-form-label col-form-label-sm">Business</label>

                                <div class="col-sm-8">
                                    <select class="form-control form-control-sm" name="business" id="business" required>
                                        <option value="">--Select--</option>
                                        @foreach($businesses as $business)
                                            <option value="{{$business['Business']}}"
                                                {{(isset($selectedProduct->Business) && ($selectedProduct->Business==$business['Business']) || (old('project')== $project->ProjectID)) ? 'selected' : ''}}
                                            >{{$business['business']['BusinessName']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="categoryId" class="col-sm-4 col-form-label col-form-label-sm">Category</label>

                                <div class="col-sm-8">
                                    <select class="form-control form-control-sm" name="categoryId" id="categoryId" required>
                                        <option value="">--Select--</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category['CategoryId']}}"
                                                {{(isset($selectedProduct->CategoryId) && ($selectedProduct->CategoryId==$category['CategoryId']) || (old('categoryId')== $category['CategoryId'])) ? 'selected' : ''}}
                                            >{{$category['Category']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="subCategoryId" class="col-sm-4 col-form-label col-form-label-sm">Sub Category</label>

                                <div class="col-sm-8">
                                    <select class="form-control form-control-sm" name="subCategoryId" id="subCategoryId" required>
                                        <option value="">--Select--</option>
                                        @foreach($subCategories as $subCategory)
                                            <option value="{{$subCategory['SubCategoryId']}}" class="{{$subCategory['CategoryId']}}"
                                                {{(isset($selectedProduct->SubCategoryId) && ($selectedProduct->SubCategoryId==$subCategory['SubCategoryId']) || (old('subCategoryId')== $subCategory['SubCategoryId'])) ? 'selected' : ''}}
                                            >{{$subCategory['SubCategory']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="itemPrice" class="col-sm-4 col-form-label col-form-label-sm">ItemPrice</label>
                                <div class="col-sm-8">
                                    <input type="number" onkeyup="itemPriceFunction()" class="form-control form-control-sm" id="itemPrice" name="itemPrice" placeholder="Item Price" required
                                           value="{{$selectedProduct->ItemPrice ?? old('itemPrice')}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="vat" class="col-sm-4 col-form-label col-form-label-sm">VAT(Flat)</label>
                                <div class="col-sm-8">
                                    <input type="number" onkeyup="itemPriceVatFunction()" class="form-control form-control-sm" id="vat" name="vat" placeholder="Enter VAT(Flat Amount)" value="{{$selectedProduct->VAT ?? 0}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="discountType" class="col-sm-4 col-form-label col-form-label-sm">Discount Type</label>
                                <div class="col-sm-8">
                                    <select class="form-control form-control-sm" id="discountType" name="discountType" onkeyup="itemPriceTypeFunction()" required>
                                        <option value="percentage">Percentage</option>
                                        <option value="flat">Flat</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="discount" class="col-sm-4 col-form-label col-form-label-sm">Discount</label>
                                <div class="col-sm-8">
                                    <input type="number" onkeyup="itemPriceDiscountFunction()" class="form-control form-control-sm" id="discount" required name="discount" placeholder="Discount" value="{{ $selectedProduct->Discount ?? 0 }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="itemFinalPrice" class="col-sm-4 col-form-label col-form-label-sm">Item Final Price</label>
                                <div class="col-sm-8">
                                    <input readonly type="number" class="form-control form-control-sm" id="itemFinalPrice" name="itemFinalPrice" placeholder="Item Final Price"
                                           value="{{$selectedProduct->ItemFinalPrice ?? old('itemFinalPrice')}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="active" class="col-sm-4 col-form-label col-form-label-sm">Active</label>
                                <div class="col-sm-8">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" name="active"
                                               id="active" <?php if (isset($selectedProduct->ProductStatus)) {
                                            if ((isset($selectedProduct->ProductStatus) && $selectedProduct->ProductStatus == 'Y') || old('active')) {
                                                echo 'checked';
                                            }
                                        } else {
                                            echo "checked";
                                        }?> >
                                        <label for="active">
                                        </label>
                                        <br>
                                        <span class="small text-info">Uncheck not to show the product in website</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="ProductCodeSystem" class="col-sm-4 col-form-label col-form-label-sm">Product Code (Optional)</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="ProductCodeSystem" name="ProductCodeSystem" placeholder="Product Code System"
                                           value="{{$selectedProduct->ProductCodeSystem ?? old('ProductCodeSystem')}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="ProductVideo" class="col-sm-4 col-form-label col-form-label-sm">Product Video (Optional)</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="ProductVideo" name="ProductVideo" placeholder="Enter Product Video Link"
                                           value="{{$selectedProduct->ProductVideo ?? old('ProductVideo')}}">
                                </div>
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="ProductDetails" class="col-sm-2 col-form-label col-form-label-sm">
                                    Product Details (optional)</label>
                                <div class="col-sm-10">
                                    <textarea id="productDetails" name="productDetails" style="width: 100%">{{$selectedProduct->ProductDetails ?? old('ProductDetails')}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="categoryMetaData" class="col-sm-2 col-form-label col-form-label-sm">
                                    Product Meta Data(Optional)</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control form-control-sm" name="productMetaData"
                                              id="productMetaData" cols="5" rows="5"
                                              placeholder="Product Meta Data">{{$selectedProduct->ProductMetaData ?? old('productMetaData')}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="categoryMetaData" class="col-sm-2 col-form-label col-form-label-sm">
                                    Product Meta Title(Optional)</label>
                                <div class="col-sm-10">
                                    <input type="text" name="ProductMetaTitle" class="form-control form-control-sm" value="{{$selectedProduct->ProductMetaTitle ?? old('ProductMetaTitle')}}">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"><i
                                class="fas fa-paper-plane"></i> {{isset($selectedProduct) ? 'Update' : 'Add'}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('jquery')
    <script src="{{asset('public/plugins/jquery.chained.js')}}"></script>
    <!-- CK Editor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/24.0.0/classic/ckeditor.js"></script>
{{--    <script src="{{ asset('public/plugins/ckeditor/ckeditor.js') }}"></script>--}}
    <script>
        $(document).ready(function () {
            // jQuery Form Validation
            $('.form-validation').validate({});
            $("#subCategoryId").chained("#categoryId")

            // $('#discount').change(function (e) {
            //
            //    var discount = $('#discount').val();
            //    var type = $('#discountType').val();
            //    var vat = $('#vat').val();
            //    var price = $('#itemPrice').val();
            //     var vat_price = parseInt(price) + parseInt(vat);
            //
            //    if (type === 'percentage') {
            //        var vat_price_with_discount = (vat_price * discount) / 100;
            //        final = parseFloat(vat_price) - parseFloat(vat_price_with_discount);
            //        $('#itemFinalPrice').val(final);
            //
            //    }else {
            //        var final = parseInt(vat_price) - parseInt(discount);
            //        $('#itemFinalPrice').val(final);
            //    }
            //
            // });
        });
    </script>

    <script>
        $(function () {
            ClassicEditor
                .create( document.querySelector( '#productDetails' ), {
                    image: {
                        toolbar: [ 'imageTextAlternative' ]
                    }
                } )
        })
    </script>

    <script type="text/javascript">

        function itemPriceFunction(){

            var discount = $('#discount').val();
            var type = $('#discountType').val();
            var vat = $('#vat').val();
            var price = $('#itemPrice').val();
            var vat_price = parseFloat(price) + parseFloat(vat);

            if (type === 'percentage') {
                var vat_price_with_discount = (vat_price * discount) / 100;
                final = parseFloat(vat_price) - parseFloat(vat_price_with_discount);
                $('#itemFinalPrice').val(final);

            }else {
                var final = parseFloat(vat_price) - parseFloat(discount);
                $('#itemFinalPrice').val(final);
            }
        }

        function itemPriceVatFunction(){
            var price = $('#itemPrice').val();
            var vat = $('#vat').val();
            var type = $('#discountType').val();
            var discount = $('#discount').val();

            if (type === 'percentage') {
                var price_with_discount = (price * discount) / 100;
                final = (parseFloat(price) + parseFloat(vat)) - parseFloat(price_with_discount);
                $('#itemFinalPrice').val(final);

            }else {
                var final = (parseFloat(price) + parseFloat(vat)) - parseFloat(discount);
                $('#itemFinalPrice').val(final);
            }
        }

        function itemPriceTypeFunction(){
            var price = $('#itemPrice').val();
            var vat = $('#vat').val();
            var discount = $('#discount').val();
            var type = $('#discountType').val();

            if (type === 'percentage') {
                var price_with_discount = (price * discount) / 100;
                final = (parseFloat(price) + parseFloat(vat)) - parseFloat(price_with_discount);
                $('#itemFinalPrice').val(final);

            }else {
                var final = (parseFloat(price) + parseFloat(vat)) - parseFloat(discount);
                $('#itemFinalPrice').val(final);
            }
        }

        function itemPriceDiscountFunction(){
            var price = $('#itemPrice').val();
            var vat = $('#vat').val();
            var discount = $('#discount').val();
            var type = $('#discountType').val();

            if (type === 'percentage') {
                var price_with_discount = (price * discount) / 100;
                final = (parseFloat(price) + parseFloat(vat)) - parseFloat(price_with_discount);
                $('#itemFinalPrice').val(final);

            }else {

                var final = (parseFloat(price) + parseFloat(vat)) - parseFloat(discount);
                $('#itemFinalPrice').val(final);
            }
        }

    </script>

@endsection
