<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('public/plugins/fontawesome/css/all.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/plugins/select2/select2.min.css')}}">
    {{--    Bootstratp bultiselect--}}
    <link rel="stylesheet" href="{{asset('public/css/bootstrap-multiselect.css')}}">
    <link rel="stylesheet" href="{{asset('public/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    @stack('css')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('public/css/adminlte.min.css')}}">

{{--    Custom Style--}}
    <link rel="stylesheet" href="{{asset('public/css/custom.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/css/toastr.min.css') }}">
    <style>
        thead{
            background: black;
            color: white;
        }
        ul li{
            font-size: 14px;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('common.sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @yield('content')

    <!-- /.content-wrapper -->
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>{{date('Y-m-d')}} <a href="#">{{ title() }}</a>.</strong>
{{--            All rights reserved.--}}
{{--            <div class="float-right d-none d-sm-inline-block">--}}
{{--                <b>MIS - ACI</b>--}}
{{--            </div>--}}
        </footer>
    </div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{asset('public/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('public/js/adminlte.js')}}"></script>
<script src="{{asset('public/plugins/select2/select2.full.min.js')}}"></script>
<!-- OPTIONAL SCRIPTS -->
{{--<script src="{{asset('public/js/demo.js')}}"></script>--}}

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{asset('public/plugins/jquery-mousewheel/jquery.mousewheel.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('public/plugins/chart.js/Chart.min.js')}}"></script>

<!-- PAGE SCRIPTS -->
<script src="{{asset('public/js/pages/dashboard2.js')}}"></script>
{{--Bootstrap multiselect--}}
<script type="text/javascript" src="{{asset('public/js/bootstrap-multiselect.js')}}"></script>
<script type="text/javascript" src="{{asset('public/js/jquery.validate.min.js')}}"></script>
{{--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.js"></script>--}}
<script src="{{ asset('public/js/toastr.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $('.multiselect').multiselect({
            // enableClickableOptGroups: true,
            // enableCollapsibleOptGroups: true,
            enableFiltering: true,
            includeSelectAllOption: true,
            buttonWidth: '100%',
            templates: {
                // button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown"></button>',
                // ul: '<ul class="multiselect-container dropdown-menu"></ul>',
                // filter: '<li class="multiselect-item filter"><div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span><input class="form-control multiselect-search" type="text"></div></li>',
                filterClearBtn: '<span class="input-group-btn"><button class="btn btn-default multiselect-clear-filter" type="button"><i class="fa fa-times"></i></button></span>',
                // li: '<li><a href="javascript:void(0);"><label></label></a></li>',
                // divider: '<li class="multiselect-item divider"></li>',
                // liGroup: '<li class="multiselect-item group"><label class="multiselect-group"></label></li>'
            }
        });


        // add Custom method to jQuery Form Validation
        $.validator.addMethod('smaller_than', function (value, element, param) {
            return +$(element).val() < +$(param).val();
        });

        $.validator.addMethod('smaller_than_or_equal', function (value, element, param) {
            return +$(element).val() <= +$(param).val();
        });

        $.validator.addMethod('greater_than', function (value, element, param) {
            return +$(element).val() > +$(param).val();
        });

        $.validator.addMethod('greater_than_or_equal', function (value, element, param) {
            return +$(element).val() >= +$(param).val();
        });

        $.validator.addMethod('not_same', function (value, element, param) {
            return +$(element).val() != +$(param).val();
        });
    });
</script>

@yield('jquery')
{!! Toastr()->message() !!}
</body>
</html>
