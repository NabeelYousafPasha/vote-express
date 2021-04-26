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
                            <li class="breadcrumb-item"><a href="/account/dashboard">Dashboard / Brands / Create</a></li>
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
            <h2 class="mb-0"><i class="fas fa-ticket-alt"></i> Create New {{ $title }}</h2>
            <a href="{{ route('account.brand.index') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <!-- Card body -->
        <div class="card-body">
            {{-- @if (!is_null(auth()->user()->plan) && auth()->user()->brands != "N" && count(auth()->user()->brands) < auth()->user()->plan->brand) --}}
                <form class="form-horizontal offset-sm-2" role="form" method="POST">
                    {!! csrf_field() !!}

                    <div class="form-group row {{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-2 col-form-label form-control-label">Brand Name</label>
                        <div class="col-md-7">
                            <input id="name" type="text" class="form-control" name="name"
                                value="{{ old('name') }}" required>

                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row {{ $errors->has('desc') ? ' has-error' : '' }}">
                        <label for="desc" class="col-md-2 col-form-label form-control-label">Description</label>

                        <div class="col-md-7">
                            <textarea rows="5" id="desc" class="form-control" name="desc" required></textarea>

                            @if ($errors->has('desc'))
                            <span class="help-block">
                                <span class="text-danger">{{ $errors->first('desc') }}</span>
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    {{-- <div class="form-group row {{ $errors->has('start_date') ? ' has-error' : '' }}">
                        <label for="start_date" class="col-md-2 col-form-label form-control-label">Start Date</label>
                        <div class="col-md-7">
                            <input id="start_date" type="date" class="form-control" name="start_date"
                                value="{{ old('start_date') }}">

                            @if ($errors->has('start_date'))
                                <span class="text-danger">{{ $errors->first('start_date') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('end_date') ? ' has-error' : '' }}">
                        <label for="end_date" class="col-md-2 col-form-label form-control-label">End Date</label>
                        <div class="col-md-7">
                            <input id="end_date" type="date" class="form-control" name="end_date"
                                value="{{ old('end_date') }}">

                            @if ($errors->has('end_date'))
                                <span class="text-danger">{{ $errors->first('end_date') }}</span>
                            @endif
                        </div>
                    </div> --}}

                    <div class="form-group row">
                        <div class="col-md-6 col-md-offset-6">
                            <button type="submit" class="btn btn-primary">
                            </i>Submit {{ $title }}
                            </button>
                        </div>
                    </div>
                </form>
            {{-- @else
                <div class="alert alert-danger" style="border-color: #f6abba;
                background-color: #f6abba;color: #d70707;" role="alert">
                    <h4 class="alert-heading" style="font-size: 1.3rem"><i class="fas fa-exclamation-triangle"></i> Access Denied!</h4>
                    <p>You have reached the limit of submitting the brand according to your Plan, Please Upgrade your plan.</p>
                    <hr>
                    <p class="mb-0">
                        <a href="{{route('plans.index')}}"><button class="btn btn-danger">Plans</button></a>
                    </p>
                </div>
            @endif --}}
            
        </div>
    </div>
</div>
@endsection