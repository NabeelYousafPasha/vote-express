@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item active'>Users</li>
@endsection

@section('admin.content')
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <strong>Users</strong>
                <a class="pull-right" href="{{ route('admin.users.create') }}">Add new user</a>
            </div>

            <div class="my-1">
                <p class="h5">Filters</p>

                <div class="row">
                    <div class="col-sm-12">
                        @include('admin.users.partials._filters')
                    </div>
                </div>
            </div>
        </div>

        @if($users->total())
            <table class="table table-responsive-sm table-hover table-outline mb-0">
                <thead class="thead-light">
                <tr>
                    <th>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="selectAll">
                            <label class="custom-control-label" for="selectAll"></label>
                        </label>
                    </th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Verified</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    @if (! $user->isAdminRoot())
                        <tr>
                            <td>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="user{{ $user->id }}">
                                    <label class="custom-control-label" for="user{{ $user->id }}"></label>
                                </label>
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>{{ $user->activated ? 'True' : 'False' }}</td>
                            {{-- <td>
                                <a href="{{ route('admin.users.roles.index', $user) }}">Manage roles</a>
                            </td> --}}
                            <td>
                                {{-- <span class="float-right" style="font-size:18px;">
                                    <a href="{{ URL::to('admin/users/' . $user->id . '/edit') }}"><i style="padding-right:10px;" class="fa fa-edit" title="Edit user"></i></a>
                                   
                                </span> --}}
                            {{-- <span class="float-right" style="font-size:18px;">
                                    <a href="{{ route('admin.users.destroy',$user->id) }}"><i style="padding-right:10px;" class="fa fa-trash-o" title="delete user"></i></a>
                                </span> --}}
                                <span>
                                <form action="{{ route('admin.users.destroy',$user->id) }}" method="POST">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" value="submit" class="btn" style="border: none"><i style="padding-right:10px;font-size: 1.3rem;" class="fa fa-trash-o" title="delete user"></i></button>
                                </form>
                                </span>
                            </td>
                        </tr>
                    @endif
                    
                @endforeach
                </tbody>
            </table>
            <div class="card-body">
                {{ $users->links() }}
            </div>
        @else
            <div class="card-body">
                <div class="card-text">No users found.</div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        //alert(123);
    })
    </script>
@endsection