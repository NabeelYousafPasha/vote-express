@extends('account.layouts.default')
@section('title', 'My Contests')

@section('styles')
    <link href="{{ asset('css/steps/jquery.steps.css') }}" rel="stylesheet">
    <link href='{{asset('js/dataTables/datatables.min.css')}}' rel='stylesheet' />

    <style type="text/css">
        .wizard > .actions > ul > li {
            display: none !important;
        }

        .wizard-big.wizard > .content{
            min-height: 2540px;
        }

        .wizard > .content > .body input{
            background-color: #FFFFFF;
        }

        .i-checks{
            position: relative;
        }
        
        .icheckbox_square-green,
        .iradio_square-green {
            position: static !important;
        }

        .icheckbox_square-green > label.error,
        .iradio_square-green > label.error
        {
            right: 0;
            position: absolute;
        }

        .wizard > .content > .body label.error{
             margin-bottom: 0 !important; 
        }
        .hidden_td{
            display: none;
        }

        .wizard > .content > .body ul {
            list-style: none !important;
        }

        @media print
        {
        html, body { height: auto; }
        .dt-print-table, .dt-print-table thead, .dt-print-table th, .dt-print-table tr {border: 0 none !important;}
        }

        .print{
            background-color: #32325d;
            border-color: #eef0fc;
        }

        .print:hover{
            background-color: #eef0fc;
            color: gray;
        }

        .pagination >li:first-child >a{
            border-radius: 10% !important;
            width: 80px;
            float: right;
        }

        .pagination >li:last-child >a{
            border-radius: 10% !important;
            width: 50px;
        }

        #export_buttons>div>button{
            background-color: #32325d;
        }
        
    </style>    
@endsection
@section('content')

{{-- Table Settings --}}
@php
     if(array_key_exists('key_name',$table['action'])){
        $key_name = $table['action']['key_name'];
     }else{
        $key_name = 'id';
     }

     if(array_key_exists('route_name_edit',$table['action'])){
        $route_name_edit = $table['action']['route_name_edit'];
     }else{
        $route_name_edit = '';
     }

     if(array_key_exists('route_name_delete',$table['action'])){
        $route_name_delete = $table['action']['route_name_delete'];
     }else{
        $route_name_delete = '';
     }

     if(array_key_exists('route_name_show',$table['action'])){
        $route_name_show = $table['action']['route_name_show'];
     }else{
        $route_name_show = '';
     }

@endphp

{{-- Table Settings --}}
<div class="header pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="/account/dashboard">Dashboard / Report</a></li>
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
    <div class="row">
        <div class="col">
            <div class="card card-default">
                <div class="card-header border-0">
                    <h2 class="mb-0"> <i class="fas fa-calendar"></i> My {{ $titles }}
                        <span class="float-right">
                            <div id="export_buttons" class="mt-2"></div>
                        </span>
                    </h2>
                </div>
                <div class="card-body">
                    @if($data->isEmpty())
                        <h3 class="text-center">You have not created any {{ $title }}.</h3>
                        @else
                        <form id="form" method="POST" action="" class="wizard-big">
                            @csrf

                            <h1>Contest</h1>
                            <fieldset>
                                <h2>Contest</h2>
                                <table id="datatable" class="table table-bordered table-hover dt-print-table" style="width:100%" >
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            @foreach($table['fields'] as $key => $val)
                                            {{-- <th>{{ text_format(key(collect($val)->toArray())) }}</th> --}}
                                            <th>{{ $val ?? text_format($key) }}</th>
                                            @endforeach
                                            {{--<th>Title</th>
                                            <th>Description</th>
                                            <th>Location</th>
                                            <th>Start Date</th>
                                            <th>End Date</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $index => $data_single)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            @foreach($table['fields'] as $key => $val)
                                            <th>{{ $data_single->$key }}</th>
                                            @endforeach
                                        
                                            {{-- <td>
                                                {{ \Carbon\Carbon::parse($data_single->start_date)->diffForHumans() }}
                                            </td> --}}
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </fieldset>

                            <h1>Contestants</h1>
                            <fieldset>
                                <h2>Products</h2>
                                <div class="table-responsive wizard-content-wrapper">
                                    <table class="table align-items-center table-flush dataTables-example dt-print-table" >
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                @foreach($table['fields'] as $key => $val)
                                                {{-- <th>{{ text_format(key(collect($val)->toArray())) }}</th> --}}
                                                <th>{{ $val ?? text_format($key) }}</th>
                                                @endforeach
                                                {{--<th>Title</th>
                                                <th>Description</th>
                                                <th>Location</th>
                                                <th>Start Date</th>
                                                <th>End Date</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($data as $index => $data_single)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                @foreach($table['fields'] as $key => $val)
                                                <th>{{ $data_single->$key }}</th>
                                                @endforeach
                                            
                                                {{-- <td>
                                                    {{ \Carbon\Carbon::parse($data_single->start_date)->diffForHumans() }}
                                                </td> --}}
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>

                        </form>
                    @endif

                </div>
                
            </div>
        </div>
    </div>
</div>
{{-- New ticket modal --}}
<div class="col-md-4">
        <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
          <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Create new ticket</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
                <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
</div>
@endsection

@section('scripts')
    <!-- Steps -->
    <script src="{{ asset('js/steps/jquery.steps.min.js') }}"></script>

    <!-- Jquery Validate -->
    <script src="{{ asset('js/validate/jquery.validate.min.js') }}"></script>

    <script src='{{asset('js/dataTables/datatables.min.js')}}'></script>

    <script>
        $(document).ready(function(){
            $("#wizard").steps();
            $("#form").steps({
                setStep:1,
                enableAllSteps: true,
                // enableAllSteps:true,
                bodyTag: "fieldset",
                onStepChanging: function (event, currentIndex, newIndex)
                {
                    // Always allow going backward even if the current step contains invalid fields!
                    if (currentIndex > newIndex)
                    {
                        return true;
                    }

                    // Forbid suppressing "Warning" step if the user is to young
                    if (newIndex === 3 && Number($("#age").val()) < 18)
                    {
                        return false;
                    }

                    var form = $(this);

                    // Clean up if user went backward before
                    if (currentIndex < newIndex)
                    {
                        // To remove error styles
                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                    }

                    // Disable validation on fields that are disabled or hidden.
                    form.validate().settings.ignore = ":disabled,:hidden";

                    // Start validation; Prevent going forward if false
                    return form.valid();
                    // return true;
                },
                onStepChanged: function (event, currentIndex, priorIndex)
                {
                    // Suppress (skip) "Warning" step if the user is old enough.
                    if (currentIndex === 2 && Number($("#age").val()) >= 18)
                    {
                        $(this).steps("next");
                    }

                    // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                    if (currentIndex === 2 && priorIndex === 3)
                    {
                        $(this).steps("previous");
                    }
                },
                onFinishing: function (event, currentIndex)
                {
                    var form = $(this);

                    // Disable validation on fields that are disabled.
                    // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                    // form.validate().settings.ignore = ":disabled";

                    // Start validation; Prevent form submission if false
                    return form.valid();
                },
                onFinished: function (event, currentIndex)
                {
                    var form = $(this);

                    // Submit form input
                    form.submit();
                }
            })
            .validate({
                        errorPlacement: function (error, element)
                        {
                            element.before(error);
                        },
                        rules: {
                            confirm: {
                                equalTo: "#password"
                            }
                        }
            });

            var table = $('#datatable').DataTable({
            buttons: [{
                extend: 'print',
                title: 'Test Data export',
                exportOptions: {
                    columns: "thead th:not(.noExport)"
                }
            }, {
                extend: 'pdf',
                title: 'Test Data export',
                exportOptions: {
                    columns: "thead th:not(.noExport)"
                }
            },{
                extend: 'csv',
                title: 'Test Data export',
                exportOptions: {
                    columns: "thead th:not(.noExport)"
                }
            }]
        });
        table.buttons().container().appendTo('#export_buttons');
        $("#export_buttons .btn").removeClass('btn-secondary').addClass('btn-light');
        })
    </script>
@endsection