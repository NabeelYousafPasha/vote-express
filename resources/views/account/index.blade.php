@extends('account.layouts.default')

@section('content')
<div class="header pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="/account/dashboard">Dashboard / Account</a></li>
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
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Account Overview</h4>
        </div>
        <div class="list-group list-group-flush">
            <div class="list-group-item">
                <h4>Name</h4>
                <p>{{ auth()->user()->name }}</p>
            </div>
            <div class="list-group-item">
                <h4>Email Address</h4>
                <p>{{ auth()->user()->email }}</p>
            </div>
            @subscribed
                @notpiggybacksubscription
                    <div class="list-group-item">
                        <h4>Plan</h4>
                        <p>{{  auth()->user()->plan->name }}</p>
                    </div>
                @endnotpiggybacksubscription
            @endsubscribed
            <div class="list-group-item">
                <h4>Joined</h4>
                <p>{{ auth()->user()->created_at->diffForHumans() }}</p>
            </div>
        </div>
    </div>
</div>
@endsection