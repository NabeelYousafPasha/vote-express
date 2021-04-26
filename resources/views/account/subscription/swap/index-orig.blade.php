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
                                <option {{-- value="{{ $plan->gateway_id }}" --}} value="{{$plan->price}}"
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

                <div class="row">
                    <label for="plan" class="col-md-2 control-label">Payment Method</label>
                    @php
                        $array = array(array('metaname' => 'color', 'metavalue' => 'blue'),
                                    array('metaname' => 'size', 'metavalue' => 'big'));
                    @endphp
                    <input type="hidden" name="amount" value="500" /> <!-- Replace the value with your transaction amount -->
                    <input type="hidden" name="payment_method" value="both" /> <!-- Can be card, account, both -->
                    <input type="hidden" name="description" value="Beats by Dre. 2017" /> <!-- Replace the value with your transaction description -->
                    <input type="hidden" name="country" value="NG" /> <!-- Replace the value with your transaction country -->
                    <input type="hidden" name="currency" value="NGN" /> <!-- Replace the value with your transaction currency -->
                    <input type="hidden" name="email" value="test@test.com" /> <!-- Replace the value with your customer email -->
                    <input type="hidden" name="firstname" value="Oluwole" /> <!-- Replace the value with your customer firstname -->
                    <input type="hidden" name="lastname" value="Adebiyi" /> <!-- Replace the value with your customer lastname -->
                    <input type="hidden" name="metadata" value="{{ json_encode($array) }}" > <!-- Meta data that might be needed to be passed to the Rave Payment Gateway -->
                    <input type="hidden" name="phonenumber" value="090929992892" /> <!-- Replace the value with your customer phonenumber -->
                    
                    <input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}"> {{-- required --}}
                    <input type="hidden" name="key" value="{{ config('paystack.secretKey') }}"> {{-- required --}}
                    {{-- <input type="hidden" name="paymentplan" value="362" /> <!-- Ucomment and Replace the value with the payment plan id --> --}}
                    {{-- <input type="hidden" name="ref" value="MY_NAME_5uwh2a2a7f270ac98" /> <!-- Ucomment and  Replace the value with your transaction reference. It must be unique per transaction. You can delete this line if you want one to be generated for you. --> --}}
                    {{-- <input type="hidden" name="logo" value="https://pbs.twimg.com/profile_images/915859962554929153/jnVxGxVj.jpg" /> <!-- Replace the value with your logo url (Optional, present in .env)--> --}}
                    {{-- <input type="hidden" name="title" value="Flamez Co" /> <!-- Replace the value with your transaction title (Optional, present in .env) --> --}}
                    
                    
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-5">
                                <button type="button" id="flutter" class="btn btn-secondary"><a class="nav-link active text-center"><img width="75%" src="{{asset('img/flutterwave_logo_color.png')}}" alt=""></a>
                                </button>
                            </div>
                            <div class="col-md-5">
                                <button type="button" id="bitcoin" class="btn btn-secondary" style="width: 100%">
                                    <a class="nav-link text-center" style="font-size: 1.2rem;"><i class="fab fa-bitcoin" style="color: #deb839"></i> Bitcoin</a>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 mt-4">
                                <button type="button" id="paystack" class="btn btn-secondary" style="width: 100%">
                                    <a class="nav-link text-center" style="font-size: 1.2rem;"><i class="fas fa-layer-group"></i> Paystack</a>
                                </button>
                            </div>
                            <div class="col-md-5 mt-4">
                                <button type="button" id="paypal" class="btn btn-secondary" style="width: 100%">
                                    <a class="nav-link text-center" style="font-size: 1.2rem;"><i class="fab fa-paypal" style="color: #3e93ef;"></i> Paypal</a>
                                </button>
                            </div>
                        </div>
                        
                    </div>
                    
                    {{-- <div class="col-lg-8">
                        <div class="tabs">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" style="width: 25%;">
                                    <a class="nav-link active text-center" id="home-tab" data-toggle="tab" href="#flutter" role="tab" aria-controls="flutter" aria-selected="true"><img width="70%" src="{{asset('img/flutterwave_logo_color.png')}}" alt=""></a>
                                </li>
                                <li class="nav-item" style="width: 25%;">
                                    <a class="nav-link text-center" id="bitcoin-tab" data-toggle="tab" href="#bitcoin" role="tab" aria-controls="bitcoin" aria-selected="false"><i class="fab fa-bitcoin" style="color: #deb839"></i> Bitcoin</a>
                                </li>
                                <li class="nav-item" style="width: 25%;">
                                    <a class="nav-link text-center" id="paystack-tab" data-toggle="tab" href="#paystack" role="tab" aria-controls="paystack" aria-selected="false"><i class="fas fa-layer-group"></i> Paystack</a>
                                </li>
                                <li class="nav-item" style="width: 25%;">
                                    <a class="nav-link text-center" id="paypal-tab" data-toggle="tab" href="#paypal" role="tab" aria-controls="paypal" aria-selected="false"><i class="fab fa-paypal" style="color: #3e93ef;"></i> Paypal</a>
                                </li>
                            </ul>

                            <div class="tab-content mt-5 mb-4" id="myTabContent">
                                <div class="tab-pane fade active show" id="flutter" role="tabpanel" aria-labelledby="tab-profile">
                                    <div class="panel ">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-6">               
                                                    <div class="form-group">
                                                        <label class="">Name</label>
                                                        <input id="name" type="text" class="form-control " name="name" value="" required="" autocomplete="name" autofocus="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="">id</label>
                                                        <input id="email" type="text" class="form-control " name="email" value="" required="" autocomplete="email" autofocus="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group mt-4" style="float: right">
                                                        <button class="btn btn-primary btn-sm" type="button">Proceed with Flutterwave</button>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="tab-pane fade" id="bitcoin" role="tabpanel" aria-labelledby="tab-profile">
                                    <div class="panel ">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                                
                                                    <div class="form-group">
                                                        <label class="">Name</label>
                                                        <input id="name" type="text" class="form-control " name="name" value=""  autocomplete="name" autofocus="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="">id</label>
                                                        <input id="email" type="text" class="form-control " name="email" value=""  autocomplete="email" autofocus="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group mt-4" style="float: right">
                                                        <button class="btn btn-primary btn-sm" type="button">Proceed with Bitcoin</button>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="tab-pane fade" id="paystack" role="tabpanel" aria-labelledby="tab-profile">
                                    <div class="panel ">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                                
                                                    <div class="form-group">
                                                        <label class="">Name</label>
                                                        <input id="name" type="text" class="form-control " name="name" value=""  autocomplete="name" autofocus="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="">id</label>
                                                        <input id="email" type="text" class="form-control " name="email" value=""  autocomplete="email" autofocus="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group mt-4" style="float: right">
                                                        <button class="btn btn-primary btn-sm" type="button">Proceed with paystack</button>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="paypal" role="tabpanel" aria-labelledby="tab-profile">
                                    <div class="panel ">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                                
                                                    <div class="form-group">
                                                        <label class="">Name</label>
                                                        <input id="name" type="text" class="form-control " name="name" value=""  autocomplete="name" autofocus="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="">id</label>
                                                        <input id="email" type="text" class="form-control " name="email" value=""  autocomplete="email" autofocus="">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group mt-4" style="float: right">
                                                        <button class="btn btn-primary btn-sm" type="button">Proceed with paypal</button>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div> --}}
        
                </div>

                {{-- <div class="form-group row mt-3">
                    <div class="col-md-6 offset-md-2">
                        <button type="submit" class="btn btn-primary">
                            Update
                        </button>
                    </div>
                </div> --}}
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){

            $('#flutter').click(function(){
                $('#changePlanForm').attr('action','{{route('pay-rave')}}');
                //console.log($('#changePlanForm').attr('action'));
                $('#changePlanForm').submit();
            })

            $('#paypal').click(function(){
                $('#changePlanForm').attr('action','{{route('payment')}}');
                //console.log($('#changePlanForm').attr('action'));
                $('#changePlanForm').submit();
            })

            $('#paystack').click(function(){
                $('#changePlanForm').attr('action','{{route('pay')}}');
                //console.log($('#changePlanForm').attr('action'));
                $('#changePlanForm').submit();
            })
        })
    </script>
@endsection