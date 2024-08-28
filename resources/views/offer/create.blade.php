@extends('layouts.master')

@section('title','Product Manage | '.config('app.name'))

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Offer Category Create</h3>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-info">
                <div class="card-header">
                    <h4 class="card-title">Offer Category Create</h4>
                </div>
                @include('common.validation_error')
                <form class="form-horizontal form-validation" method="post" action="{{url('offer/offer-category-submit')}}" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="category" class="col-sm-4 col-form-label col-form-label-sm">Offer Name</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="OfferName" name="OfferName" placeholder="Offer Name">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="image" class="col-sm-4 col-form-label col-form-label-sm">Offer Image</label>
                                <div class="col-sm-8">
                                    <input type="file" class="form-control form-control-sm" id="image" name="image">
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="image" class="col-sm-4 col-form-label col-form-label-sm">Offer Banner</label>
                                <div class="col-sm-8">
                                    <input type="file" class="form-control form-control-sm" id="bannerImage" name="bannerImage">
                                </div>

                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="OfferDescription" class="col-sm-2 col-form-label col-form-label-sm">Offer Description</label>
                                <div class="col-sm-10">
                                    <textarea id="OfferDescription" name="OfferDescription" style="width: 100%"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="categoryId" class="col-sm-4 col-form-label col-form-label-sm">Products</label>
                                <div class="col-sm-8">
                                    <select class="form-control form-control-sm select2 js-example-basic-multiple" name="ProductCodes[]" id="ProductCode" multiple required>
                                        <option value="">--Select--</option>
                                        @foreach($products as $product)
                                            <option value="{{$product->ProductCode}}" >{{$product->ProductName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info"><i
                                class="fas fa-paper-plane"></i> Create
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
    <script>
        $(function () {
            ClassicEditor
                .create( document.querySelector( '#OfferDescription' ), {
                    image: {
                        toolbar: [ 'imageTextAlternative' ]
                    }
                } )
        })
    </script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2();
        });
    </script>


@endsection
