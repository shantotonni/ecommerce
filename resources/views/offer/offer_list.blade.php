@extends('layouts.master')

@section('title','Offer List | '.config('app.name'))

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
            {{-- <div class="card">
                <div class="card-body">
                </div>
            </div> --}}
            <div class="card">
                @include('common.validation_error')
                <div class="card-header">
                    <h3 class="card-title">{{$featureName}} List</h3>
                    <a href="{{$action}}" class="btn btn-danger float-right">Add Offer Category</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 700px">
                    <table class="table table-hover table-bordered text-nowrap">
                        <thead>
                            <tr>
                                <th class="text-center">SL</th>
                                <th>Offer Name</th>
{{--                                <th>Offer Description</th>--}}
                                <th class="text-center">Offer Image</th>
                                <th class="text-center">Offer Banner</th>
                                <th>Created At</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(isset($offers))
                            @foreach($offers as $key=>$offer)
                                <tr>
                                    <td class="text-center">{{$key+1}}</td>
                                    <td>{{$offer->OfferName}}</td>
{{--                                    <td>{{$offer_image->OfferDescription}}</td>--}}

                                    <td class="text-center"><img src="{{$imageUrl.'/'.$offer->OfferImage}}"
                                        alt="{{$offer->OfferImage}} " width="50"></td>
                                    <td class="text-center"><img src="{{$imageUrl.'/'.$offer->OfferBanner}}"
                                            alt="{{$offer->OfferBanner}} " width="50"></td>
                                    <td>{{ date("Y-m-d", strtotime($offer->CreatedAt))}}</td>

                                    <td class="text-center">

                                        {{-- <a class="btn btn-outline-warning btn-sm" title="Edit Product Info" data-toggle="tooltip"
                                           href="{{url($action,$product->ProductCode)}}"><i class="fa fa-edit"></i></a>

                                        <a class="btn btn-outline-warning btn-sm" title="Add, Edit, Delete Multiple image" data-toggle="tooltip"
                                           href="{{ route('product.multiple.image.create',$product->ProductCode) }}"><i class="fa fa-plus"></i></a> --}}

                                       <a class="btn btn-outline-warning btn-sm" title="Offer View" data-toggle="tooltip"
                                          href="{{ route('offer.edit',$offer->ID) }}"><i class="fa fa-edit"></i></a>

                                    </td>

                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    {{$offers->links()}}
                </div>
                <!-- /.card-body -->
            </div>
        </div>

    </section>
@endsection
@section('jquery')

@endsection
