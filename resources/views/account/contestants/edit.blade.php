@extends('account.layouts.default')

@section('styles')
    <link rel='stylesheet' href='https://unpkg.com/formiojs@latest/dist/formio.full.min.css'>
    <style>
        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            color: #ffffff;
            border-color: #dee2e6 #dee2e6 #f8f9fe;
            background-color: #5e72e4;
        }
    </style>
@endsection

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
                            <li class="breadcrumb-item"><a href="/account/dashboard">Dashboard / Contest / Update</a></li>
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
        {{-- @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif --}}
    <div class="card">
        <!-- Card header -->
        <div class="card-header">
            <h2 class="mb-0"><i class="fas fa-ticket-alt"></i>Update Contestant</h2>
            <a href="{{ URL::previous() }}" class="btn btn-primary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <!-- Card body -->
        @if (isset($form_data))
            <div class="card-body">
                <div id='builder'></div>

            </div>
        @else
            <form class="form-horizontal offset-sm-2" action="{{ route('account.contestant.update',$contestant->id) }}" role="form" method="POST" enctype="multipart/form-data">
                
                {{ method_field('PUT') }}
                {!! csrf_field() !!}

                <div class="form-group row {{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-2 col-form-label form-control-label">Name</label>

                    <div class="col-md-7">
                        <input type="text" rows="5" id="name" class="form-control" name="name" value="{{isset($contestant) ? $contestant->name : old('name')}}">

                        @if ($errors->has('name'))
                        <span class="help-block">
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-2 col-form-label form-control-label">Email</label>

                    <div class="col-md-7">
                        <input type="email" rows="5" id="email" class="form-control" name="email" value="{{isset($contestant) ? $contestant->email : old('email')}}">

                        @if ($errors->has('email'))
                        <span class="help-block">
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row {{ $errors->has('phone') ? ' has-error' : '' }}">
                    <label for="phone" class="col-md-2 col-form-label form-control-label">Phone</label>

                    <div class="col-md-7">
                        <input type="text" rows="5" id="phone" class="form-control" name="phone" value="{{isset($contestant) ? $contestant->phone : old('phone')}}">

                        @if ($errors->has('phone'))
                        <span class="help-block">
                            <span class="text-danger">{{ $errors->first('phone') }}</span>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="exampleFormControlSelect1" class="col-md-2 col-form-label form-control-label">Avatar</label>
                    <div class="col-md-7">
                        <input class="btn btn-success form-control" type="file" name="avatar" id="">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6 col-md-offset-6">
                        <button type="submit" class="btn btn-primary">
                        </i>Update {{ $title }}
                        </button>
                    </div>
                </div>
            </form>
        @endif
        
    </div>
</div>
@endsection

@section('scripts')
    <script src='https://unpkg.com/formiojs@latest/dist/formio.full.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
    <script type='text/javascript'>
    window.form_data = {!! $form_data ?? basic_form_fields() !!};
    window.onload = function() {
        var form = {!! $form_data ?? basic_form_fields() !!};
        var contestant_data={!!$contestant_data ?? null !!};
        if (typeof contestant_data !== 'null') {
            Formio.createForm(document.getElementById('builder'), form).then(function(form) {

            form.submission = {
                data:contestant_data
            };

            form.on('submit', function(submission) {
                console.log(submission);
                
                    var route = '/account/contestant/'+"{!!$contestant->id!!}";
                    jQuery.ajax({
                        url: route,
                        method: 'put',
                        data: {
                            _token: "{{ csrf_token() }}",
                            contestant_id: "{!! $contestant->id !!}",
                            q:'form_data',
                            form_data: submission.data
                        },
                        success: function(result){
                            console.log(result);
                        },
                        fail: function (jqXHR, textStatus, error) {
                            console.log("Post error: " + error);
                        }
                    });
                
            });
        });
        }
        
    };
    </script>
@endsection