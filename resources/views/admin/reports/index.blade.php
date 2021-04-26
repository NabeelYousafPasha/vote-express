@extends('admin.layouts.default')

@section('admin.breadcrumb')
<li class='breadcrumb-item active'>Reports</li>
@endsection

@section('styles')
    <link href='{{asset('js/dataTables/datatables.min.css')}}' rel='stylesheet' />
    <style>
        .btn-primary {
            border-color: #9cbed3;
        }
    </style>
@endsection

@section('admin.content')
<div class="clearfix">
    <div class="col-lg">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Reports
                <div class="btn-group" style="float: right" role="group" aria-label="Basic example">
                    <div id="export_button" class="mt-2"></div>
                </div>
            </div>
            <div class="card-body">
                <table id="reportDatatable" class="table table-responsive-sm table-striped">
                    <thead>
                        <tr>
                            <th>User</th>
                            {{-- <th>Slug</th> --}}
                            <th>Plan</th>
                            <th>Trial end</th>
                            {{-- <th>Trial Day</th> --}}
                            <th>Plan end</th>
                            <th>Created at</th>
                            <th>Updated at</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscriptions as $subscription )
                        <tr>
                            <td>{{ $subscription->user_id }}</td>
                            {{-- <td>{{ $plan->slug }}</td> --}}
                            <td>{{ $subscription->stripe_plan }}</td>
                            <td>{{ $subscription->trial_ends_at }}</td>
                            {{-- <td>{{ $plan->trial_period_days }}</td> --}}
                            <td>
                                
                                {{ $subscription->ends_at }}
                            </td>
                             <td>{{ \Carbon\Carbon::parse($subscription->updated_at)->diffForHumans() }}</td>
                            <td>{{ \Carbon\Carbon::parse($subscription->created_at)->diffForHumans() }}</td>
                            <td>
                                {{-- {{ $subscription->stripe_status }}  --}}
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="User Actions">
                                    <a href="{{ URL::to('admin/subscription/' . $subscription->id . '/edit') }}" data-toggle="tooltip" data-placement="top" title="" class="btn btn-primary" data-original-title="Edit"><i class="fa fa-edit "></i></a>
                                    <form action="{{ route('admin.subscription.destroy', $subscription->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash-o "></i></b>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script src='{{asset('js/dataTables/datatables.min.js')}}'></script>
    <script>
        $(document).ready(function(){

            var table = $('#reportDatatable').DataTable({
                destroy: true,
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
            table.buttons().container().appendTo('#export_button');
            $("#export_button .btn").removeClass('btn-secondary').addClass('btn-primary');
        })
    </script>
@endsection