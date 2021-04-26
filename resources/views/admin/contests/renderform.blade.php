@extends('admin.layouts.default')

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

@section('admin.breadcrumb')
<li class='breadcrumb-item active'>Create Contestants</li>
@endsection

@section('admin.content')
<div class="container-fluid mt--6">
        {{-- @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif --}}
    <div class="card">
        <!-- Card header -->
        <div class="card-header">
            <h2 class="mb-2"><i class="fas fa-ticket-alt"></i>Add Contestants</h2>
            <a href="{{ URL::previous() }}" class="btn btn-primary btn-sm">
                <i class="fa fa-arrow-left"></i> Back
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
    
    <script type='text/javascript'>
    window.form_data = {!! $form_data ?? basic_form_fields() !!};
    window.onload = function() {
        var form = {!! $form_data ?? basic_form_fields() !!};
        Formio.createForm(document.getElementById('builder'), form).then(function(form) {

            form.on('submit', function(submission) {
                console.log(submission);
                
                    var route = '{!! route('admin.contestants.storeFormData') !!}';
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