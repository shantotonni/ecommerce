@extends('layouts.master')

@section('title','Searching List | '.config('app.name'))

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
                    <h3>Searching List</h3>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Searching List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Query</th>
                                <th>Count</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($searches as $key=>$search)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $search->query }}</td>
                                <td>{{ $search->count }}</td>
                                <td>{{ $search->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
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

