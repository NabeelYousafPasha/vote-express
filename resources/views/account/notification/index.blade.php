@extends('account.layouts.default')
@section('title', 'My Notifications')

@section('styles')
    <link href='{{asset('js/dataTables/datatables.min.css')}}' rel='stylesheet' />
    <style>
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


<div class="header pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="/account/dashboard">Dashboard / Notifications</a></li>
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
                    <h2 class="mb-0"> <i class="fas fa-bell"></i> My NotificationS
                        <span class="float-right">
                            <div id="export_buttons" class="mt-2"></div>
                        </span>
                    </h2>
                </div>
                {{-- @if($notifications->isEmpty())
                <h3 class="text-center">You have not yet any Notification.</h3>
                
                @else --}}
                <div class="card-body">
                    <table id="datatable" class="table table-bordered table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sr#</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th class="noExport">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notifications as $key => $notify)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$notify->subject}}</td>
                                    <td>{{$notify->message}}</td>
                                    <td><span class="badge badge-pill badge-primary">{{$notify->status}}</span></td>
                                    <td> <a class="ml-2" href="#" data-toggle="tooltip" data-original-title="Edit"><i class="icon-edit"></i>
                                        <a href="{{route('account.notification.read',$notify->id)}}" >
                                            <span data-toggle="tooltip" data-placement="top" title="Mark as read">
                                              <i class="fas fa-eye text-info" style="font-size:14px; padding:5px"></i>
                                            </span>
                                        </a>

                                        <a href="" onclick="event.preventDefault(); document.getElementById('delete-notification-{{ $notify->id }}').submit();"><span data-toggle="tooltip" data-placement="top" title="Delete notification"><i class="fas fa-trash text-danger" style="font-size:14px; padding:5px"></i></span></a>

                                        <form action="{{ route('account.notification.delete',$notify->id) }}" method="POST" id="delete-notification-{{ $notify->id }}" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" value="{{ $notify->id }}" name="id">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
                {{-- @endif --}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src='{{asset('js/dataTables/datatables.min.js')}}'></script>
<script>
    $(document).ready(function () {
        /* var table = $('#datatable').DataTable({
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
            }, {
                extend: 'excel',
                title: 'Test Data export',
                exportOptions: {
                    columns: "thead th:not(.noExport)"
                }
            }, {
                extend: 'csv',
                title: 'Test Data export',
                exportOptions: {
                    columns: "thead th:not(.noExport)"
                }
            }]
        });
        table.buttons().container().appendTo('#export_buttons');
        $("#export_buttons .btn").removeClass('btn-secondary').addClass('btn-light'); */
    });
</script>
@endsection