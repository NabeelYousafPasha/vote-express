@extends('admin.layouts.default')

@section('admin.breadcrumb')
<li class='breadcrumb-item active'>Plans</li>
@endsection

@section('admin.content')
<div class="clearfix">
    <div class="col-lg">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Plans
            </div>
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <div class="card-body">
                <table class="table table-responsive-sm table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            {{-- <th>Slug</th> --}}
                            <th>Duration</th>
                            <th>Price</th>
                            {{-- <th>Trial Day</th> --}}
                            {{-- <th>Teams</th> --}}
                            <th>Brand</th>
                            <th>Contest</th>
                            <th>Info 1</th>
                            <th>Info 2</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($plans as $plan )
                        <tr>
                            <td>{{ $plan->name }}</td>
                            {{-- <td>{{ $plan->slug }}</td> --}}
                            <td>{{ $plan->duration }}</td>
                            <td>{{ $plan->price }}</td>
                            {{-- <td>{{ $plan->trial_period_days }}</td> --}}
                            {{-- <td>
                                @if ($plan->teams_enabled === 1)
                                <span class="badge badge-success"> Team Plan</span>
                                @else
                                <span class="badge badge-info"> Normal plan</span>
                                @endif
                            </td> --}}
                            {{-- <td>{{ $plan->teams_limit }}</td> --}}
                            <td>{{ $plan->brand }}</td>
                            <td>{{ $plan->contest }}</td>
                            <td>{{$plan->other_info_1}}</td>
                            <td>{{$plan->other_info_2}}</td>
                            <td>{{ $plan->created_at->diffForHumans() }}</td>
                            <td>
                                @if ($plan->active === 1)
                                <span class="badge badge-success"> Active</span>
                                @else
                                <span class="badge badge-danger"> Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="User Actions">
                                    <a href="{{ URL::to('admin/plans/' . $plan->id . '/edit') }}" data-toggle="tooltip" data-placement="top" title="" class="btn btn-primary" data-original-title="Edit"><i class="fa fa-edit "></i></a>
                                    <form action="{{ route('admin.plans.destroy', $plan->id)}}" method="post">
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