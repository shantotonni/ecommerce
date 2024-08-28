@extends('layouts.master')

@section('title','Guest Customer List | '.config('app.name'))

@push('css')
    <link rel="stylesheet" href="{{ asset('public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/bootstrap-datepicker3.min.css') }}">
@endpush

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Guest Customer</h3>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Guest Customer List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="all-data" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Customer ID</th>
                                <th>Customer Name</th>
                                <th>Customer MobileNo</th>
                                <th>Customer Email</th>
                                <th>Delivery Address</th>
                                <th>District</th>
                                <th>Thana</th>
                                <th>Created Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>

    <div class="modal fade" id="customer_details_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Customer Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <td>Customer Id</td>
                                <td id="customer_id"></td>
                            </tr>
                            <tr>
                                <td>Customer Name</td>
                                <td id="customer_name"></td>
                            </tr>
                            <tr>
                                <td>Mobile</td>
                                <td id="mobile"></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td id="email"></td>
                            </tr>
                            <tr>
                                <td>Delivery Address</td>
                                <td id="DeliveryAddress"></td>
                            </tr>
                            <tr>
                                <td>District</td>
                                <td id="District"></td>
                            </tr>
                            <tr>
                                <td>Thana</td>
                                <td id="Thana"></td>
                            </tr>
                            <tr>
                                <td>Created Date</td>
                                <td id="created_date"></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('jquery')
    <script src="{{ asset('public/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('public/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('public/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('public/js/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            let table = $("#all-data").DataTable({
                processing: true,
                oLanguage: {sProcessing: "<div id='loader'></div><span id='loading-text'>Processing</span>"},
                pageLength: 10,
                serverSide: true,
                searchDelay: 400,
                responsive: true,
                scrollY: true,
                searching: true,
                deferRender: true,
                ajax: "{{ route('guest.customer.list') }}",
                columns: [
                    // {data: 'id',name: 'id'},
                    {data: 'id',name: 'guest_users.id'},
                    {data: 'customer_name',name: 'guest_users.customer_name'},
                    {data: 'mobile',name: 'guest_users.mobile'},
                    {data: 'email',name: 'guest_users.email'},
                    {data: 'DeliveryAddress',name: 'guest_users.DeliveryAddress'},
                    {data: 'District',name: 'guest_users.District'},
                    {data: 'Thana',name: 'guest_users.Thana'},
                    {data: 'created_at',name: 'guest_users.created_at'},
                    {data: 'action', searchable: false},
                ]
            });
        });

        function guestCustomerDetails(id) {
            var CustomerId = id;
            $.ajax({
                url: '{{ route('guest.customer.details') }}',
                type: "POST",
                data: {CustomerId: CustomerId},
                dataType: 'JSON',
                success: function (data) {
                    //console.log(data);
                    $('#customer_id').html(data.id);
                    $('#customer_name').html(data.customer_name);
                    $('#email').html(data.email);
                    $('#DeliveryAddress').html(data.DeliveryAddress);
                    $('#District').html(data.District);
                    $('#mobile').html(data.mobile);
                    $('#Thana').html(data.Thana);
                    $('#created_date').html(data.created_at);
                    $('#customer_details_modal').modal('show');
                }
            });
        }

    </script>
@endsection
