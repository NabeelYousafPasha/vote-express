@extends('account.layouts.default')
@section('title',  $titles)
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
            <h2 class="mb-0"><i class="fas fa-ticket-alt"></i> Edit {{ $title }}</h2>
        </div>
        <!-- Card body -->
        <div class="card-body">
                
            <form class="form-horizontal offset-sm-2" action="{{route('account.brand.update',$brand->id)}}" role="form" method="POST">
                {!! csrf_field() !!}
                @method('put')
                <div class="form-group row {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-2 col-form-label form-control-label">Brand Name</label>
                    <div class="col-md-7">
                        <input id="name" type="text" class="form-control" name="name"
                             value="{{$brand->name}}" required>

                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('desc') ? ' has-error' : '' }}">
                    <label for="desc" class="col-md-2 col-form-label form-control-label">Description</label>

                    <div class="col-md-7">
                        <textarea rows="5" id="desc" class="form-control" name="desc" required>{{$brand->desc}}</textarea>

                        @if ($errors->has('desc'))
                        <span class="help-block">
                            <span class="text-danger">{{ $errors->first('desc') }}</span>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6 col-md-offset-6">
                        <button type="submit" class="btn btn-primary">
                           </i>Submit {{ $title }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection