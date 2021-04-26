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
        </div>
        <!-- Card body -->
        <div class="card-body">
            <div id='builder'></div>

            <div class="float-right">
                <button id="saveForm" class="btn btn-success">Save Form</button>
            </div>
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
        Formio.builder(document.getElementById('builder'), {!! $form_data ?? basic_form_fields() !!}, {
            builder: {
                basic: {
                    title: 'Fields',
                    default: true,
                    weight: 0,
                    components: {
                        password: false,
                        
                    },
                },
                advanced: {
                components: {
                    signature: false,
                },
                },
                data: false,
                customBasic: false,
                premium: false,
            },
            editForm: {
                textfield: [
                {
                    key: 'api',
                    ignore: true
                },{
                    key: 'logic',
                    ignore: true
                },{
                    key: 'layout',
                    ignore: true
                }, 
                ],
                textarea: [
                {
                    key: 'api',
                    ignore: true
                },{
                    key: 'logic',
                    ignore: true
                },{
                    key: 'layout',
                    ignore: true
                }, 
                ],
                number: [
                {
                    key: 'api',
                    ignore: true
                },{
                    key: 'logic',
                    ignore: true
                },{
                    key: 'layout',
                    ignore: true
                }, 
                ],
                checkbox: [
                {
                    key: 'api',
                    ignore: true
                },{
                    key: 'logic',
                    ignore: true
                },{
                    key: 'layout',
                    ignore: true
                }, 
                ],
                selectboxes: [
                {
                    key: 'api',
                    ignore: true
                },{
                    key: 'logic',
                    ignore: true
                },{
                    key: 'layout',
                    ignore: true
                }, 
                ],
                select: [
                {
                    key: 'api',
                    ignore: true
                },{
                    key: 'logic',
                    ignore: true
                },{
                    key: 'layout',
                    ignore: true
                }, 
                ],
                radio: [
                {
                    key: 'api',
                    ignore: true
                },{
                    key: 'logic',
                    ignore: true
                },{
                    key: 'layout',
                    ignore: true
                }, 
                ],
                button: [
                {
                    key: 'api',
                    ignore: true
                },{
                    key: 'logic',
                    ignore: true
                },{
                    key: 'layout',
                    ignore: true
                }, 
                ],
            
            },
        }).then(function(builder) {

            $('.component-settings-button-edit-json').html('');
            $('.component-settings-button-edit-json').hide();

            builder.on('saveComponent', function() {

                console.log(form = builder.schema);
            });

            builder.on('removeComponent', function() {
                console.log(form = builder.schema);
            });

            builder.on('editComponent', function() {
                console.log(form = builder.schema);
            });
        });

        $('#saveForm').click(function(builder){
            // console.log(form);
            var route = '{!! route('account.contest-form.store') !!}';
            jQuery.ajax({
                url: route,
                method: 'post',
                
                data: {
                    _token: "{{ csrf_token() }}",
                    contest: "{!! $contest_id !!}",
                    form_data: JSON.stringify(form)
                },
                success: function(result){
                    console.log(result);
                    Swal.fire(
                            'Success!',
                            'Form Saved',
                            'success'
                        );
                },
                fail: function (jqXHR, textStatus, error) {
                    console.log("Post error: " + error);
                    Swal.fire(
                            'Error!',
                            'Something went wrong ! ',
                            'error'
                        );
                }
            });
        })
    };
    </script>
@endsection