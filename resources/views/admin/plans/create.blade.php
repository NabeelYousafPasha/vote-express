@extends('admin.layouts.default')

@section('admin.breadcrumb')
<li class='breadcrumb-item active'>Plan</li>
@endsection

@section('admin.content')
<div class="clearfix">
    <div class="card">
        <div class="card-header">
            <strong>Create a Plan</strong> 
            <span class="center"> Plan will automaticaly create on the fly to the stripe dashboard </span>
        </div>
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <div class="card-body">
            <form action="{{ route('admin.plans.store') }}" method="POST" class="form-horizontal offset-sm-2">
                    {!! csrf_field() !!}
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Plan name</label>
                    <div class="col-md-6">
                        <input type="text" id="name" name="name" class="form-control"
                            placeholder="Enter Plan name.."
                            value="{{ old('name') }}">

                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Plan Price</label>
                    <div class="col-md-6">
                        <input type="text" id="price" name="price" class="form-control"
                            placeholder="Enter Plan price.."
                            value="{{ old('price') }}">

                            @if ($errors->has('price'))
                                <span class="text-danger">{{ $errors->first('price') }}</span>
                            @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Brand Limit</label>
                    <div class="col-md-6">
                        <input type="text" id="brand" name="brand" class="form-control"
                            placeholder="Enter Brand.."
                            value="{{ old('brand') }}">

                            @if ($errors->has('brand'))
                                <span class="text-danger">{{ $errors->first('brand') }}</span>
                            @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Contest Limit</label>
                    <div class="col-md-6">
                        <input type="text" id="contest" name="contest" class="form-control"
                            placeholder="Enter contest.."
                            value="{{ old('contest') }}">

                            @if ($errors->has('contest'))
                                <span class="text-danger">{{ $errors->first('contest') }}</span>
                            @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Plan Trial</label>
                    <div class="col-md-6">
                        <input type="text" id="trial" name="trial" class="form-control"
                            placeholder="Enter Plan name.."
                            value="{{ old('trial') }}">

                            @if ($errors->has('trial'))
                                <span class="text-danger">{{ $errors->first('trial') }}</span>
                            @endif
                    </div>
                </div>
                {{-- <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Plan Type</label>
                    <div class="col-md-6">
                        <select id="duration" type="" class="form-control" name="plan_type">
                            <option value="">Select Plan Type</option>
                            <option value="one_time">One Time</option>
                            <option value="recurring">Recurring</option>
                        </select>

                            @if ($errors->has('plan_type'))
                                <span class="text-danger">{{ $errors->first('plan_type') }}</span>
                            @endif
                    </div>
                </div> --}}
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Plan Duration</label>
                    <div class="col-md-6">
                            <select id="duration" type="" class="form-control" name="duration">
                                <option value="">Select duration</option>
                                <option value="1,day">1 Day</option>
                                <option value="1,week">1 Week</option>
                                <option value="3,month">3 Months</option>
                                <option value="6,month">6 Months</option>
                                <option value="1,year">12 Months</option>
                            </select>

                            @if ($errors->has('duration'))
                                <span class="text-danger">{{ $errors->first('duration') }}</span>
                            @endif
                    </div>
                </div>
                

                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Info One</label>
                    <div class="col-md-6">
                        <input type="text" id="plan_info_1" name="plan_info_1" class="form-control"
                            placeholder="Enter Plan plan_info_1.."
                            value="{{ old('plan_info_1') }}">

                            @if ($errors->has('plan_info_1'))
                                <span class="text-danger">{{ $errors->first('plan_info_1') }}</span>
                            @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Info Two</label>
                    <div class="col-md-6">
                        <input type="text" id="plan_info_2" name="plan_info_2" class="form-control"
                            placeholder="Enter Plan plan_info_2.."
                            value="{{ old('plan_info_2') }}">

                            @if ($errors->has('plan_info_2'))
                                <span class="text-danger">{{ $errors->first('plan_info_2') }}</span>
                            @endif
                    </div>
                </div>

                {{-- <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Teams Plan</label>
                    <div class="col-md-6">
                        <div class="row">
                        <div class="col-md-3">
                            <label class="switch switch-text switch-pill switch-primary">
                                <input type="checkbox" name="checkbox" id="checkbox" class="switch-input">
                                <span class="switch-label" data-on="On" data-off="Off"></span>
                                <span class="switch-handle"></span>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input type="number" id="teams_limit" name="teams_limit" class="form-control"
                            placeholder="Number of member allow for this Plan"
                            value="{{ old('teams_limit') }}">
                            @if ($errors->has('teams_limit'))
                                <span class="text-danger">{{ $errors->first('teams_limit') }}</span>
                            @endif
                        </div>
                        </div>
                    </div>
                </div> --}}
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Create</button>
            </form>
        </div>
        <div class="card-footer">
            <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reset</button>
        </div>
    </div>
</div>
@endsection