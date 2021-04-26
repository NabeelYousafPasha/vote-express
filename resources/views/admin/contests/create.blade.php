@extends('admin.layouts.default')

@section('admin.breadcrumb')
<li class='breadcrumb-item active'>Contests /{!! isset($contest) ? ' Edit' : ' Create' !!}</li>
@endsection

@section('content')
<div class="container-fluid mt--6">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
    <div class="card">
        <!-- Card header -->
        <div class="card-header">
            <h2 class="mb-0"><i class="fas fa-ticket-alt"></i> {!! isset($contest) ? ' Edit' : ' Create' !!} New {{ $title }}</h2>
        </div>
        <!-- Card body -->
        <div class="card-body">
            @php 
                $route = route('admin.contest.store');
                
                if(isset($contest)){
                $route = route('admin.contest.update',$contest->id);
            
                }
            @endphp
            <form class="form-horizontal offset-sm-2" action="{{ $route }}" role="form" method="POST" enctype="multipart/form-data">
                @if(isset($contest))
                    {{ method_field('PUT') }}
                @endif
                {!! csrf_field() !!}

                <div class="form-group row {{ $errors->has($title) ? ' has-error' : '' }}">
                    <label for="title" class="col-md-2 col-form-label form-control-label">{{ text_format($title) }}</label>
                    <div class="col-md-7">
                        <input id="{{ $title }}" type="text" name="title" class="form-control" title="{{ $title }}"
                            value="{{ isset($contest) ? $contest->title : old($title) }}">
                
                        @if ($errors->has($title))
                            <span class="text-danger">{{ $errors->first($title) }}</span>
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
                        <input id="contest_logo" type="file" name="contest_logo" class="form-control" title="logo">
                
                        @if ($errors->has('contest_logo'))
                            <span class="text-danger">{{ $errors->first('contest_logo') }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group row {{ $errors->has('start_date') ? ' has-error' : '' }}">
                    <label for="start_date" class="col-md-2 col-form-label form-control-label">Start Date</label>
                    <div class="col-md-7">
                        <input id="start_date" type="date" class="form-control" name="start_date"
                            value="{{ isset($contest) ? date('Y-m-d' , strtotime($contest->start_date)) :  old('start_date') }}">

                        @if ($errors->has('start_date'))
                            <span class="text-danger">{{ $errors->first('start_date') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group row {{ $errors->has('end_date') ? ' has-error' : '' }}">
                    <label for="end_date" class="col-md-2 col-form-label form-control-label">End Date</label>
                    <div class="col-md-7">
                        <input id="end_date" type="date" class="form-control" name="end_date"
                            value="{{ isset($contest) ? date('Y-m-d' , strtotime($contest->end_date)) :  old('end_date') }}">

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
                            <option @if (isset($contest) && $contest->contest_type =='free') {!!'selected'!!} @endif>free</option>
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
                        <input type="radio" @if (isset($contest) && $contest->vote_count =='number') {!!'checked'!!} @endif style="width:20px; height:20px" name="vote_count" value="number">
                    </div>
                    <div class="col-md-3">
                        <label class="ml-3 mr-3" style="font-weight:bold">Percentage</label>
                        <input type="radio" @if (isset($contest) && $contest->vote_count =='percentage') {!!'checked'!!} @endif style="width:20px; height:20px" name="vote_count" value="percentage">
                    </div>
                    @if ($errors->has('vote_count'))
                        <br>
                        <span class="text-danger">{{ $errors->first('vote_count') }}</span>
                    @endif
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
                        <button type="submit" class="btn btn-primary">
                           </i>{!! isset($contest) ? ' Edit' : ' Create' !!} {{ $title }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection