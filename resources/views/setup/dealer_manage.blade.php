@extends('layouts.master')

@section('title','Category Manage | '.config('app.name'))
@push('css')
    <link rel="stylesheet" href="{{ asset('public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endpush

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
            @include('setup.dealer_create')
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{$featureName}} List</h3>
                </div>
                <div class="card-body table-responsive" style="height: 300px">
                    <table id="all-data" class="table table-bordered table-striped table-sm small">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Product Group</th>
                            <th>District</th>
                            <th>Upazila</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($dealers))
                            @foreach($dealers as $key=>$dealer)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$dealer->Name}}</td>
                                    <td>{{$dealer->Phone}}</td>
                                    <td>{{$dealer->ProductGroup}}</td>
                                    <td>{{ $dealer->district ? $dealer->district->DistrictName : 'N/A' }}</td>
                                    <td>{{ $dealer->upazilla ? $dealer->upazilla->UpazillaName : 'N/A' }}</td>
                                    <td>{{$dealer->Latitude}}</td>
                                    <td>{{$dealer->Longitude}}</td>
                                    <td>{{$dealer->Address}}</td>
                                    <td>
                                        <a class="btn btn-default btn-sm" href="{{url($action,$dealer->DealerId)}}"><i class="fa fa-edit"></i> Edit</a>
                                        <form action="{{ route('dealer.delete', $dealer->DealerId) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE') <!-- Use DELETE method instead of POST -->
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?');">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
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
<script src="{{ asset('public/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#all-data').DataTable({
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "pageLength": 10,
        });

        // Select2 Initialization
        $('.select2').select2();

        // AJAX setup for CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Handle district change event to load upazilas
        $("#DistrictCode").change(function(){
            var district = $("#DistrictCode").val();
            $.ajax({
                type: "POST",
                url: "{{ url('district/wise/thana') }}",
                data: { district : district }
            }).done(function(data){
                console.log(data);
                $("#UpazillaCode").html('');
                $("#UpazillaCode").html(data);
            });
        });

        // jQuery Form Validation
        $('.form-validation').validate({
            rules: {
                category: {
                    required: true,
                    maxlength: 255
                },
            },
        });
    });
</script>
@endsection
