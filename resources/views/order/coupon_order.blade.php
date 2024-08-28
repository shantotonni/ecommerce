@extends('layouts.master')

@section('title','Order List | '.config('app.name'))

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
                    <h3>Orders</h3>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Order List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="col-md-12">
                        <form id="filterform">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="from-date" autocomplete="off" id="from-date" placeholder="From Date"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="to-date" autocomplete="off" id="to-date" placeholder="To Date"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <select name="status_id" class="form-control" id="status_id">
                                                <option value="0">Select All</option>
                                                @foreach($status as $value)
                                                    <option value="{{ $value->InvStatusID }}">{{ $value->InvStatus }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <hr>
                    <form action="{{ route('order.order-list-export') }}" method="post" class="export">
                        {{ csrf_field() }}
                        <input type="hidden" name="fdate" class="fdate">
                        <input type="hidden" name="tdate" class="tdate">
                        <input type="hidden" name="status" class="status">
                        <button type="submit" class="btn btn-secondary btn-sm">Export as Excel</button>
                    </form>
                    <hr>
                    <table id="all-data" class="table table-bordered table-striped table-sm small">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Invoice No</th>
                                <th>Order Date</th>
                                <th>Customer Name</th>
                                <th>Customer Number</th>
                                <th>Customer ID</th>
                                <th>Total Amount</th>
{{--                                <th>Discount Amount</th>--}}
                                <th>VAT Amount</th>
                                <th>Grand Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </section>
    <?php
        $user = \Illuminate\Support\Facades\Auth::user();
        $state = '';
        if ($user->project[0]->ProjectID == 3) {
            $state = true;
        }else{
            $state = false;
        }
    ?>
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
            var i = 1;
            $('.export').hide();

            let table = $("#all-data").DataTable({
                processing: true,
                oLanguage: {sProcessing: "<div id='loader'></div><span id='loading-text'>Processing</span>"},
                pageLength: 10,
                serverSide: true,
                stateSave: "{{ $state }}",
                searchDelay: 400,
                responsive: true,
                scrollY: true,
                searching: true,
                deferRender: true,
                ajax: "{{ route('get.coupon.order') }}",
                columns: [
                    {
                        "render": function() {
                            return i++;
                        }
                    },
                    // {data: 'id',name: 'id'},
                    {data: 'InvoiceNo',name: 'Invoice.InvoiceNo'},
                    {data: 'InvoiceDate',searchable: false},
                    {data: 'CustomerName',name: 'Invoice.CustomerName'},
                    {data: 'CustomerMobileNo',name: 'Invoice.CustomerMobileNo'},
                    {data: 'CustomerID',name: 'Invoice.CustomerID'},
                    {data: 'TotalAmount',name: 'Invoice.TotalAmount'},
                    // {data: 'DiscountAmount',name: 'Invoice.DiscountAmount'},
                    {data: 'VATAmount'},
                    {data: 'GrandTotal',name: 'Invoice.GrandTotal'},
                    {data: 'Status',searchable: false},
                    {data: 'action', searchable: false},
                ]
            });

            $("#filterform").on('submit', function(e) {
                $('.fdate').val($("#from-date").val());
                $('.tdate').val($("#to-date").val());
                $('.status').val($("#status_id").val());
                $('.export').show();
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

    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
       function addDeliveryCharge(invoice_no){
           $('#myModal').modal('show')
           $("#InvoiceNo").val(invoice_no);
       }

       function addDiscount(invoice_no){
           $('#addDiscount').modal('show')
           $("#InvoiceNoDiscount").val(invoice_no);
       }
    </script>
@endsection
