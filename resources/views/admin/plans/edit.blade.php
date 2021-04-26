@extends('admin.layouts.default')

@section('admin.breadcrumb')
<li class='breadcrumb-item active'>Plan</li>
@endsection

@section('admin.content')
<div class="clearfix">
    <div class="card">
        <div class="card-header">
            <strong>Update Plan</strong>
        </div>
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        <div class="card-body">
            <form action="{{ route('admin.plans.update', $plan->id) }}" method="POST" class="form-horizontal offset-sm-2">
                    {!! csrf_field() !!}
                    @method('PUT')
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Plan name</label>
                    <div class="col-md-6">
                        <input type="text" id="name" name="name" class="form-control" value="{{ $plan->name }}"
                            placeholder="Enter Plan name..">

                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Plan Price</label>
                    <div class="col-md-6">
                        <input type="text" id="price" name="price" class="form-control"
                            value="{{ $plan->price }}">

                            @if ($errors->has('price'))
                                <span class="text-danger">{{ $errors->first('price') }}</span>
                            @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Brand Limit</label>
                    <div class="col-md-6">
                        <input type="text" id="brand" name="brand" class="form-control"
                            value="{{ $plan->brand }}">

                            @if ($errors->has('brand'))
                                <span class="text-danger">{{ $errors->first('brand') }}</span>
                            @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Contest Limit</label>
                    <div class="col-md-6">
                        <input type="text" id="contest" name="contest" class="form-control"
                            value="{{ $plan->contest }}">

                            @if ($errors->has('contest'))
                                <span class="text-danger">{{ $errors->first('contest') }}</span>
                            @endif
                    </div>
                </div>
                {{-- <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Plan Trial</label>
                    <div class="col-md-6">
                        <input type="text" id="trial" name="trial" class="form-control"
                            value="{{ $plan->trial_period_days }}">

                            @if ($errors->has('trial'))
                                <span class="text-danger">{{ $errors->first('trial') }}</span>
                            @endif
                    </div>
                </div> --}}
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Plan Duration</label>
                    <div class="col-md-6">
                        <select id="duration" type="" class="form-control" name="duration">
                            <option value="">Select plan</option>
                            <option value="1,week" {{ $plan->duration == '1,week' ? 'selected' : '' }}>1 Week</option>
                            <option value="3,month" {{ $plan->duration == '3,month' ? 'selected' : '' }}>3 Months</option>
                            <option value="6,month" {{ $plan->duration == '6,month' ? 'selected' : '' }}>6 Months</option>
                            <option value="12,month" {{ $plan->duration == '12,month' ? 'selected' : '' }}>12 Months</option>
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
                            value="{{ $plan->other_info_1 }}">

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
                            value="{{ $plan->other_info_2 }}">

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
                                <input type="checkbox" name="checkbox" id="checkbox" class="switch-input" {{ $plan->teams_enabled == 1 ? 'checked' : '' }}>
                                <span class="switch-label" data-on="On" data-off="Off"></span>
                                <span class="switch-handle"></span>
                            </label>
                        </div>
                        <div class="col-md-9">
                            <input type="number" id="teams_limit" name="teams_limit" class="form-control"
                            placeholder="Number of member allow for this Plan"
                            value="{{ $plan->teams_limit }}">
                            @if ($errors->has('teams_limit'))
                                <span class="text-danger">{{ $errors->first('teams_limit') }}</span>
                            @endif
                        </div>
                        </div>
                    </div>
                </div> --}}
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Update</button>
            </form>
        </div>
        <div class="card-footer">
            <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reset</button>
        </div>
    </div>
</div>
@endsection