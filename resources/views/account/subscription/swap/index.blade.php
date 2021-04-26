@extends('account.layouts.default')

@section('styles')
    <style>
        @media only screen and (max-width: 600px) {
            #flutter img {
                width: 35%;
            }

            #bitcoin{
                margin-top: 1.5rem; 
            }
        }
    </style>
@endsection

@section('content')

<div class="header pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="/account/dashboard">Dashboard / Subscription</a></li>
                            <li class="breadcrumb-item active" aria-current="page"></li>
                        </ol>
                    </nav>
                </div>
                {{-- <div class="col-lg-6 col-5 text-right">
                    <a href="#" class="btn btn-sm btn-neutral">New</a>
                    <a href="#" class="btn btn-sm btn-neutral">Filters</a>
                </div> --}}
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt--6">
    @if ($message=Session::get('success'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{$message}}
      </div>
      <?php Session::forget('success'); ?>
    @endif
    @if ($message=Session::get('error'))
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{$message}}
      </div>
      <?php Session::forget('error'); ?>
    @endif
    <div class="card">

        <div class="card-body">
            <h4 class="card-title">Swap subscription - Upgrading or Downgrading plan</h4>
            <p class="card-subtitle mb-2">
                You are currently on the <strong>{{ auth()->user()->plan->name }}</strong> plan, at a rate of:
                <strong>({{ config('settings.cashier.currency.symbol') }}{{ auth()->user()->plan->price }})</strong>
            </p>

            <form method="POST" id="changePlanForm" class="ml-5" action="{{ route('account.subscription.swap.store') }}">
                {{ csrf_field() }}

                <div class="form-group row{{ $errors->has('plan') ? ' has-error' : '' }}">
                    <label for="plan" class="col-md-2 control-label">Plan</label>

                    <div class="col-md-6">

                        <select name="plan" id="plan"
                                class="form-control custom-select{{ $errors->has('plan') ? ' is-invalid' : '' }}"
                                required>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->gateway_id }}"
                                        {{ request('plan') === $plan->slug ||
                                        old('plan') === $plan->gateway_id ? 'selected' : '' }}>
                                    {{ $plan->name }} (${{ $plan->price }})
                                </option>
                            @endforeach
                        </select>

                        @if ($errors->has('plan'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('plan') }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
                {{-- <div class="form-group row{{ $errors->has('coupon') ? ' has-error' : '' }}">
                    <label for="coupon" class="col-md-2 control-label">Coupon</label>

                    <div class="col-md-6">
                        <input id="coupon" type="text"
                               class="form-control{{ $errors->has('coupon') ? ' is-invalid' : '' }}"
                               name="coupon" value="{{ old('coupon') }}">

                        @if ($errors->has('coupon'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('coupon') }}</strong>
                            </div>
                        @endif
                    </div>
                </div> --}}

                <div class="form-group row">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary" id="pay">
                            Subscribe
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
       
    </script>
@endsection