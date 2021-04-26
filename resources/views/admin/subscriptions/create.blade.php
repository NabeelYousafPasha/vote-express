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
            <form action="{{ route('admin.subscription.store') }}" method="POST" class="form-horizontal offset-sm-2">
                    {!! csrf_field() !!}

                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Client</label>
                    <div class="col-md-6">
                            <select id="client_id" type="" class="form-control" name="client_id">
                                <option value="">Select Client</option>
                                @foreach ($all_users as $user)
                                    @if (! $user->isAdminRoot())
                                        <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                    @endif
                                @endforeach
                            </select>

                            @if ($errors->has('client_id'))
                                <span class="text-danger">{{ $errors->first('client_id') }}</span>
                            @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Stripe Id</label>
                    <div class="col-md-6">
                        <input type="text" id="stripe_id" name="stripe_id" class="form-control"
                            placeholder="Enter Stripe Id"
                            value="{{ old('stripe_id') }}">

                            @if ($errors->has('stripe_id'))
                                <span class="text-danger">{{ $errors->first('stripe_id') }}</span>
                            @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label" for="hf-name">Stripe Plan</label>
                    <div class="col-md-6">
                            <select id="stripe_plan" type="" class="form-control" name="stripe_plan">
                                <option value="Free">Free</option>
                                <option value="Standard">Standard</option>
                                <option value="Plus">Plus</option>
                                <option value="Pro">Pro</option>
                            </select>

                            @if ($errors->has('stripe_plan'))
                                <span class="text-danger">{{ $errors->first('stripe_plan') }}</span>
                            @endif
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('ends_at') ? ' has-error' : '' }}">
                    <label for="expires_at" class="col-md-3 col-form-label" data-toggle="datetimepicker"
                           data-target="#expires_at{{  request()->route('id') or '' }}">
                        Expires at
                    </label>
                    <div class="col-md-6">
                        <div class="input-group datetimepicker" id="expires_at{{ request()->route('id') or '' }}" data-target-input="nearest">
                            <input type="text" name="ends_at"
                                   class="form-control{{ $errors->has('ends_at') ? ' is-invalid' : '' }}"
                                   data-toggle="datetimepicker" data-target="#expires_at{{ request()->route('id') or '' }}"
                                   value="{{ old('ends_at') }}">
                
                            <div class="input-group-append" data-toggle="datetimepicker" data-target="#expires_at{{ request()->route('id') or '' }}">
                                <div class="input-group-text">
                                    <i class="icon-calendar"></i>
                                </div>
                            </div>
                        </div>
                
                        @if($errors->has('ends_at'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('ends_at') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Create</button>
            </form>
        </div>
        <div class="card-footer">
            <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reset</button>
        </div>
    </div>
</div>
@endsection