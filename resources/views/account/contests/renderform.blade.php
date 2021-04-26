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
                            <li class="breadcrumb-item"><a href="/account/dashboard">Dashboard / Contestant / Create</a></li>
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
            <h2 class="mb-0"><i class="fas fa-ticket-alt"></i>Add Contestants</h2>
            <a href="{{ URL::previous() }}" class="btn btn-primary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <!-- Card body -->
        <div class="card-body">
            <div id='builder'></div>
        </div>
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
        Formio.createForm(document.getElementById('builder'), form).then(function(form) {

            form.on('submit', function(submission) {
                console.log(submission);
                
                    var route = '{!! route('account.contestants.storeFormData') !!}';
                    jQuery.ajax({
                        url: route,
                        method: 'post',
                        data: {
                            _token: "{{ csrf_token() }}",
                            contest: "{!! $contest->id !!}",
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
    };
    </script>
@endsection