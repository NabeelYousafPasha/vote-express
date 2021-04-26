@extends('account.layouts.default')
@section('styles')
    <style>
        .line {
            background: linear-gradient(to right, #507bf5 0%,#04c3e1 100%);
            height: 2px;
            width: 50px;
            margin-bottom: 50px;
            display: inline-block;
        }
        .heading {
            font-size: 30px;
            color: #3b566e;
            font-weight: 700;
            margin-bottom: 15px;
            padding: 0;
        }

        .plan:hover{
            box-shadow: 1px 2px 10px 1px #99adb4;
            transition: transform .2s; /* Animation */
            transform: scale(1.1);
        }
    </style>
@endsection
@section('content')
    <div class="container text-center">
        <div class="d-flex d-flex-wrap justify-content-center mb-3 heading" style="text-transform: none">
            <h1 style="color: #808080;">Our Price</h1>
        </div><!-- /.d-flex -->
        <div class="line"></div>

        @foreach($plans->chunk(3) as $plansRow)
            <div class="{{ $plansRow->count() == 1 ? 'd-flex flex-wrap justify-content-center' : 'card-deck' }} mb-3">

                @foreach($plansRow as $plan)
                    <div class="card {{ $plansRow->count() == 1 ? 'col-sm-6' : '' }} text-center plan">
                        <h2 class="my-3 text-truncate" style="color: rgb(67, 148, 198);;margin-bottom: 0px !important">
                           {{$plan->name}}
                        </h2>
                        <h2 class="my-3 text-truncate">
                            <small>$.</small> {{ $plan->price }}<small>/ {{str_replace(","," ",$plan->duration) }}</small>
                        </h2>
                        <hr class="mx-auto" style="margin-bottom: 0rem; width: 80%">
                        <div class="card-body">
                            <h2 class="my-3 text-truncate">
                                <small><i class="fa fa-check"></i></small> {{ $plan->brand }} BRAND
                            </h2>
                            <h2 class="my-3 text-truncate">
                                <small><i class="fa fa-check"></i></small> {{ $plan->contest }} CONTEST
                            </h2>

                            <h3 class="my-3" style="padding: 1.5rem;">
                                <small><i class="fa fa-{{$plan->name == 'FREE' ?'ban':'check'}}"></i></small> {{ $plan->other_info_1 ?? '' }}
                                <br>
                                <small><em>{{ $plan->other_info_2 ?? '' }}</em></small>
                            </h3>

                            <a class="btn btn-link" href="{{ route('plans.show', $plan) }}">
                                Details
                            </a>

                            <a class="btn btn-primary" href="{{ route('account.subscription.new.index', ['plan' => $plan]) }}">
                                Subscribe
                            </a>
                        </div><!-- /.card-body -->

                        @if($plan->teams_enabled)
                            <div class="list-group list-group-flush">
                                <div class="list-group-item flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">Team Limit</h5>
                                        <span>{{ $plan->teams_limit }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div><!-- /.card -->
                @endforeach

            </div><!-- /.d-flex or .card-deck -->
        @endforeach

        <div class="d-flex d-flex-wrap justify-content-center">
            {{ $links or '' }}
        </div><!-- /.d-flex -->
    </div>
@endsection