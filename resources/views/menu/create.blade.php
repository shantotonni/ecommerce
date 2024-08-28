@extends('layouts.master')

@section('title','Menu Create | '. title())

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h4>Menu Create</h4>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('menu-list.store') }}">
                        @csrf
                        <div class="card-body row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="MenuName">Menu Name</label>
                                    <input type="text" class="form-control" id="MenuName" name="MenuName" placeholder="Menu Name" required>
                                </div>
                                @if ($errors->has('MenuName'))
                                    <span class="help-block"><strong>{{ $errors->first('MenuName') }}</strong></span>
                                @endif
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="SubMenuName">Sub Menu Name</label>
                                    <input type="text" class="form-control" id="SubMenuName" name="SubMenuName" placeholder="Sub Menu Name" required>
                                </div>
                                @if ($errors->has('SubMenuName'))
                                    <span class="help-block"><strong>{{ $errors->first('SubMenuName') }}</strong></span>
                                @endif
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Link">Link</label>
                                    <input type="text" class="form-control" id="Link" name="Link" placeholder="Link" required>
                                </div>
                                @if ($errors->has('Link'))
                                    <span class="help-block"><strong>{{ $errors->first('Link') }}</strong></span>
                                @endif
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="MenuOrder">Menu Order</label>
                                    <input type="number" class="form-control" id="MenuOrder" name="MenuOrder" placeholder="Menu Order" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="Active">Status</label>
                                    <select name="Active" id="Active" class="form-control">
                                        <option>Select Status</option>
                                        <option value="Y">Active</option>
                                        <option value="N">Inactive</option>
                                    </select>
                                    @if ($errors->has('Active'))
                                        <span class="help-block"><strong>{{ $errors->first('Active') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2" style="margin-top: 30px">
                                <button type="submit" class="btn btn-info"><i class="fa fa-paper-danger"></i> Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('jquery')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $(document).ready(function () {
            //
        });
    </script>
@endsection
