<div class="card card-info">
    <div class="card-header">
        <h4 class="card-title">{{$featureName ?? ''}} {{$actionTitle ?? ''}}</h4>
    </div>
    @include('common.validation_error')
    <form class="form-horizontal form-validation" method="post" action="{{url($action)}}"
          enctype="multipart/form-data">
        @csrf
        @if(isset($selectedDealer))
            <input type="hidden" value="{{$selectedDealer->DealerId ?? ''}}" name="id">
        @endif
        <div class="card-body row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="Name" name="Name" placeholder="Name"
                        value="{{$selectedDealer->Name ?? old('Name')}}"
                        required="">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="Phone">Phone</label>
                    <input type="text" class="form-control" id="Phone" name="Phone" placeholder="Phone"
                            value="{{$selectedDealer->Phone ?? old('Phone')}}"
                            required="">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="DistrictCode">District</label>
                    <select class="form-control select2" name="DistrictCode" id="DistrictCode">
                        <option value="">Select District</option>
                        @foreach($districts as $district)
                            <option value="{{ $district->DistrictCode }}"
                                {{(isset($selectedDealer->DistrictCode) && ($selectedDealer->DistrictCode==$district->DistrictCode) || (old('project')== $district->DistrictCode)) ? 'selected' : ''}}
                                >{{ $district->DistrictName }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('District'))
                        <div class="error">{{ $errors->first('District') }}</div>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="UpazillaCode">Upazila</label>
                    <select class="form-control select2" id="UpazillaCode" name="UpazillaCode">
                        @if(isset($upazilas))
                            @foreach($upazilas as $upazila)
                            <option value="{{ $upazila->DistrictCode }}"
                                {{(isset($selectedDealer->UpazillaCode) && ($selectedDealer->UpazillaCode==$upazila->UpazillaCode) || (old('project')== $district->DistrictCode)) ? 'selected' : ''}}
                                >{{ $upazila->UpazillaName }}</option>
                            @endforeach
                        @endif
                    </select>
                    @if($errors->has('Upazila'))
                        <div class="error">{{ $errors->first('Upazila') }}</div>
                    @endif
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="Latitude">Latitude</label>
                    <input type="text" class="form-control" id="Latitude" name="Latitude" placeholder="Latitude"
                        value="{{$selectedDealer->Latitude ?? old('Latitude')}}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="Longitude">Longitude</label>
                    <input type="text" class="form-control" id="Longitude" name="Longitude" placeholder="Longitude"
                        value="{{$selectedDealer->Longitude ?? old('Longitude')}}">

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Address">Address</label>
                    <input type="text" class="form-control" id="Address" name="Address" placeholder="Address"
                            value="{{$selectedDealer->Address ?? old('Address')}}">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-info"><i
                    class="fas fa-paper-plane"></i> {{isset($selectedDealer) ? 'Update' : 'Add'}}
            </button>
        </div>
    </form>
</div>
