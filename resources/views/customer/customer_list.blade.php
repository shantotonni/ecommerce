@extends('layouts.master')

@section('title','Customer List | '.config('app.name'))

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
                    <h3>Customer</h3>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Customer List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="all-data" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Customer ID</th>
                                <th>Customer FirstName</th>
                                <th>Customer LastName</th>
                                <th>Date Of Birth</th>
                                <th>Customer MobileNo</th>
                                <th>Customer Email</th>
                                <th>Created Date</th>
                                <th>Status</th>
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
                                <td>First Name</td>
                                <td id="first_name"></td>
                            </tr>
                            <tr>
                                <td>Last Name</td>
                                <td id="last_name"></td>
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
                                <td>Created Date</td>
                                <td id="created_date"></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td id="status"></td>
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
                ajax: "{{ route('customer.list') }}",
                columns: [
                    // {data: 'id',name: 'id'},
                    {data: 'CustomerID',name: 'Customer.CustomerID'},
                    {data: 'CustomerFirstName',name: 'Customer.CustomerFirstName'},
                    {data: 'CustomerLastName',name: 'Customer.CustomerLastName'},
                    {data: 'DateOfBirth',name: 'Customer.DateOfBirth'},
                    {data: 'CustomerMobileNo',name: 'Customer.CustomerMobileNo'},
                    {data: 'CustomerEmail',name: 'Customer.CustomerEmail'},
                    {data: 'CreatedDate',name: 'Customer.CreatedDate'},
                    {data: 'Status',searchable: false},
                    {data: 'action', searchable: false},
                ]
            });

            $("#filterform").on('submit', function(e) {
                table.ajax.url('list?status_id=' + $("#status_id").val()
                    + '&from_date=' + $("#from-date").val()
                    + '&to_date=' + $("#to-date").val())
                    .load();
                e.preventDefault();
            });
        });

        $("#from-date").datepicker({
            format: 'yyyy-mm-dd 00:00:00',
            autoclose: true,
        });

        $("#to-date").datepicker({
            format: 'yyyy-mm-dd 23:59:59',
            autoclose: true,
        });

        function customerDetails(id) {
            var CustomerId = id;
            $.ajax({
                url: '{{ route('customer.details') }}',
                type: "POST",
                data: {CustomerId: CustomerId},
                dataType: 'JSON',
                success: function (data) {
                    //console.log(data);
                    $('#customer_id').html(data.CustomerID);
                    $('#first_name').html(data.CustomerFirstName);
                    $('#last_name').html(data.CustomerLastName);
                    $('#email').html(data.CustomerEmail);
                    $('#mobile').html(data.CustomerMobileNo);
                    $('#created_date').html(data.CreatedDate);
                    var badge = '';
                    if(data.Status == 1){
                        badge += '<span class="badge badge-success">Active</span>';
                    }else{
                       badge += '<span class="badge badge-warning">InActive</span>';
                    }
                    $('#status').html(badge);

                    $('#customer_details_modal').modal('show');
                }
            });
        }

    </script>
@endsection
