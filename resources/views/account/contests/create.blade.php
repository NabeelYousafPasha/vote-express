@extends('account.layouts.default')
@section('title',  $titles)
@section('content')

<div class="header pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="/account/dashboard">Dashboard / Contest / Create</a></li>
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
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
    <div class="card">
        <!-- Card header -->
        <div class="card-header">
            <h2 class="mb-0"><i class="fas fa-ticket-alt"></i>{{isset($contest) ? ' Edit' : ' Create'}} {{ $title }}</h2>
            <a href="{{ route('account.contest.index') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            {{-- <a style="float: right" href="{{ route('account.contest_builder') }}" class="btn btn-primary btn-sm">
                <i></i> contest builder
            </a> --}}
        </div>
        <!-- Card body -->
        {{-- @if (Route::currentRouteName() == "account.contest.edit" || !is_null(auth()->user()->plan) && count(auth()->user()->contests) < auth()->user()->plan->contest) --}}
        <div class="card-body">
            @php 
                $route = route('account.contest.store');
                
                if(isset($contest)){
                $route = route('account.contest.update',$contest->id);
            
                }
            @endphp

            {{-- @if (Route::currentRouteName() == "account.contest.edit" || !is_null(auth()->user()->plan) && count(auth()->user()->contests) < auth()->user()->plan->contest) --}}
                <input hidden id="subenddate" type="date" value="@if(!is_null($carbon_sub_date)){{ date('Y-m-d' , strtotime($carbon_sub_date)) }}@endif">
                <input hidden id="plan" type="text" value="{{ auth()->user()->subscriptions()->first()->stripe_plan }}">
                
                <form id="contest_form" class="form-horizontal offset-sm-2" action="{{ $route }}" role="form" method="POST" enctype="multipart/form-data">
                    @if(isset($contest))
                        {{ method_field('PUT') }}
                    @endif
                    {!! csrf_field() !!}

                    <div class="form-group row {{ $errors->has('title') ? ' has-error' : '' }}">
                        <label for="title" class="col-md-2 col-form-label form-control-label">Title</label>

                        <div class="col-md-7">
                            <input type="text" rows="5" id="title" class="form-control" name="title" value="{{isset($contest) ? $contest->title : old('title')}}">

                            @if ($errors->has('title'))
                            <span class="help-block">
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('desc') ? ' has-error' : '' }}">
                        <label for="desc" class="col-md-2 col-form-label form-control-label">Description</label>

                        <div class="col-md-7">
                            <textarea rows="5" id="desc" class="form-control" name="desc">{{isset($contest) ? $contest->desc : ''}}</textarea>

                            @if ($errors->has('desc'))
                            <span class="help-block">
                                <span class="text-danger">{{ $errors->first('desc') }}</span>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('contest_logo') ? ' has-error' : '' }}">
                        <label for="contest_logo" class="col-md-2 col-form-label form-control-label">Logo</label>

                        <div class="col-md-7">
                            <input type="file" id="contest_logo" class="form-control" name="contest_logo" value="{{isset($contest) ? $contest->contest_logo : old('contest_logo')}}">

                            @if ($errors->has('contest_logo'))
                            <span class="help-block">
                                <span class="text-danger">{{ $errors->first('contest_logo') }}</span>
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group row {{ $errors->has('start_date') ? ' has-error' : '' }}">
                        <label for="start_date" class="col-md-2 col-form-label form-control-label">Start Date</label>
                        <div class="col-md-7">
                            <input id="start_date" type="date" class="form-control" name="start_date"
                                value="{{ isset($contest)?  date('Y-m-d' , strtotime($contest->start_date)) : old('start_date') }}">

                            @if ($errors->has('start_date'))
                                <span class="text-danger">{{ $errors->first('start_date') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('end_date') ? ' has-error' : '' }}">
                        <label for="end_date" class="col-md-2 col-form-label form-control-label">End Date</label>
                        <div class="col-md-7">
                            <input id="end_date" type="date" class="form-control" name="end_date"
                                value="{{ isset($contest)?  date('Y-m-d' , strtotime($contest->end_date)) : old('end_date') }}">

                            @if ($errors->has('end_date'))
                                <span class="text-danger">{{ $errors->first('end_date') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('contest_type') ? ' has-error' : '' }}">
                        <label for="contest_type" class="col-md-2 col-form-label form-control-label">Contest Type</label>

                        <div class="col-md-7">
                            <select class="form-control" id="contest_type" name="contest_type">
                                <option @if (isset($contest) && $contest->contest_type =='paid') {!!'selected'!!} @endif >paid</option>
                                <option @if (isset($contest) && $contest->contest_type =='free') {!!'selected'!!} @endif >free</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('vote_amount') ? ' has-error' : '' }}">
                        <label for="vote_amount" class="col-md-2 col-form-label form-control-label">Vote Amount</label>
                        <div class="col-md-7">
                            <input id="vote_amount" type="number" class="form-control" name="vote_amount"
                                value="{{isset($contest) ? $contest->vote_amount : old('vote_amount')}}">

                            @if ($errors->has('vote_amount'))
                                <span class="text-danger">{{ $errors->first('vote_amount') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('contest_currency') ? ' has-error' : '' }}">
                        <label for="contest_currency" class="col-md-2 col-form-label form-control-label">Contest Currency</label>

                        <div class="col-md-7">
                            <select class="form-control" id="contest_currency" name="contest_currency">
                                <option @if (isset($contest) && $contest->contest_currency =='NGN') {!!'selected'!!} @endif >NGN</option>
                                <option @if (isset($contest) && $contest->contest_currency =='USD') {!!'selected'!!} @endif >USD</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('contest_currency') ? ' has-error' : '' }}">
                        <label for="contest_currency" class="col-md-2 col-form-label form-control-label">Vote Count View</label>
    
                        <div class="col-md-3">
                            <label class="ml-3 mr-3" style="font-weight:bold">Number</label>
                            <input type="radio" style="width:20px; height:20px" name="vote_count" value="number">
                        </div>
                        <div class="col-md-3">
                            <label class="ml-3 mr-3" style="font-weight:bold">Percentage</label>
                            <input type="radio" style="width:20px; height:20px" name="vote_count" value="percentage">
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('votetopercent') ? ' has-error' : '' }}">
                        <label for="votetopercent" class="col-md-2 col-form-label form-control-label">Vote to Percentage</label>
                        <div class="col-md-7">
                            <input style="display:inline-block; width:30%" id="votetopercent" type="number" class="form-control" name="votetopercent"
                                value="{{isset($contest) ? $contest->votetopercent : old('votetopercent')}}">
                            <span>Votes to 1%</span>
    
                            @if ($errors->has('votetopercent'))
                                <span class="text-danger">{{ $errors->first('votetopercent') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 col-md-offset-6">
                            <span class="btn btn-primary" id="formsubmitbtn">
                            {{isset($contest) ? ' Edit' : ' Create'}} {{ $title }}
                            </span>
                        </div>
                    </div>
                </form>
            {{-- @else
                <div class="alert alert-danger" style="border-color: #f6abba;
                background-color: #f6abba;color: #d70707;" role="alert">
                    <h4 class="alert-heading" style="font-size: 1.3rem"><i class="fas fa-exclamation-triangle"></i> Access Denied!</h4>
                    <p>You have reached the limit of submitting the Contest according to your Plan, Please Upgrade to extend the limit</p>
                    <hr>
                    <p class="mb-0">
                        <a href="{{route('plans.index')}}"><button class="btn btn-danger">Plans</button></a>
                    </p>
                </div>
            @endif --}}
            
        </div>
        {{-- @else
            <div class="alert alert-danger" style="border-color: #f6abba;
            background-color: #f6abba;color: #d70707;" role="alert">
                <h4 class="alert-heading" style="font-size: 1.3rem"><i class="fas fa-exclamation-triangle"></i> Access Denied!</h4>
                <p>You have reached the limit of submitting the contest according to your Plan, Please Upgrade your plan.</p>
                <hr>
                <p class="mb-0">
                    <a href="{{route('plans.index')}}"><button class="btn btn-danger">Plans</button></a>
                </p>
            </div>
        @endif --}}
    </div>
</div>


<div class="modal" id="contestPaymentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Payment Confirmation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="paymentmessage">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal" aria-hidden="true">Cancel</button>
                
                @if(auth()->user()->subscriptions()->first() && auth()->user()->subscriptions()->first()->stripe_plan == "Basic")
                    <a href="{{ route('account.subscription.swap.index')}}" type="button" class="btn btn-lg btn-primary" >Change Plan</a>
                @endif
                
                <button type="button" class="btn btn-lg btn-success"
                        onclick="submitForm()">
                    Pay Amount
                </button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
{{-- <link href="https://code.jquery.com/ui/1.12.0/themes/smoothness/jquery-ui.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script> --}}

    <script>
        function submitForm() {
            $('#contest_form').submit();
        }

        function confirmationModal(end_date , sub_end_date){
            var daydiff = (end_date.getTime() - sub_end_date.getTime())/86400000;
            var weeks = Math.ceil(daydiff/7);
            $('#paymentmessage').html("<p>You have to pay $"+weeks*10+" for "+weeks+" weeks exceeding your subscription end date");
            $('#contestPaymentModal').modal("show");
        }

        $('#formsubmitbtn').click(function(){
            var end_date = new Date($('#end_date').val());
            var sub_end_date = new Date($('#subenddate').val());
            var plan = $('#plan').val()
            if((plan != "Basic" || $('#subenddate').val() !='') && end_date > sub_end_date){
                confirmationModal(end_date , sub_end_date);
            }else{
                $('#contest_form').submit();
            }
        });
    </script>
@endsection