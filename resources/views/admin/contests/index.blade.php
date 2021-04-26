@extends('admin.layouts.default')

@section('admin.breadcrumb')
<li class='breadcrumb-item active'>Contests</li>
@endsection

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
@section('admin.content')
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card card-default">
                    <div class="card-header border-0">
                        <h2 class="mb-0"> <i class="fa fa-calendar"></i> {{ $titles }} List
                            <span class="float-right">
                                <a href="{{ route('admin.contest.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus"></i> Create New {{ $title }}
                                </a>
                            </span>
                        </h2>
                    </div>
                    <div class="card-body">

                        @if($data->isEmpty())
                        <h3 class="text-center">You have not created any {{ $title }}.</h3>
                        @else
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
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
                                        <th>Contestants</th>
                                        <th>URL</th>
                                        <th>Action</th>
                                        <th>Form</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $index => $data_single)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        @foreach($table['fields'] as $key => $val)
                                        <td>{{ $data_single->$key }}</td>
                                        @endforeach
                                        
                                        <td>{{ count($data_single->Contestants) ?? '' }}</td>
                                        @php
                                            $route_param = array();
                                            $route_param[$key_name] = $data_single->$key_name;
                                        @endphp

                                        <td>{{ route('contest.publish',$data_single->id) }}</td>
                                        <td>
                                            <span class="btn-group" role="group" aria-label="User Actions">
                                                {{-- <a href="@if($route_name_show) {{ route($route_name_show,$route_param) }} @endif"><span class="badge adge badge-success">View</span></a> --}}
                                                <a href="{{ route('contest.publish',$data_single->id) }}" class="btn btn-warning"><span class="badgebadge-primary">Publish</span></a>
                                                <a class="btn btn-primary" data-original-title="Edit" href="@if($route_name_edit) {{ route($route_name_edit,$route_param) }} @endif"><i class="fa fa-edit "></i></a>

                                                <form action="{{ route('admin.contest.destroy', $data_single->id)}}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="submit"><i class="fa fa-trash-o "></i></b>
                                                </form>
                                            </span>
                                        </td>
                                        <td>
                                            @if (!$data_single->Contestants->isEmpty())
                                                {{-- if contestants exist for a contest--}}

                                                @if ($data_single->Contestants[0]->form_data ==null)
                                                    {{-- if contest entry is not through form. --}}    
                                                @else
                                                    {{-- if contest entry is through form. --}}   
                                                    <a href="{{ route('admin.contest-form.manage') }}?contest={{$data_single->id}}">
                                                    <span class="badge adge badge-success" style="padding: 1.15em 0.4em;font-size: 77%">Build Form</span>
                                                    </a>
                                                @endif
                                                
                                            @else
                                                {{-- if there are no contestants--}}
                                                <a href="{{ route('admin.contest-form.manage') }}?contest={{$data_single->id}}">
                                                    <span class="badge adge badge-success" style="padding: 1.15em 0.4em;font-size: 77%">Build Form</span>
                                                </a>
                                            @endif
                                            <a href="{{route('admin.contestants.index')}}">
                                                <span class="badge adge badge-primary" style="padding: 1.15em 0.4em;font-size: 77%">Add Contestants</span>
                                            </a>
                                            
                                        </td>
                                        {{-- <td>
                                            {{ \Carbon\Carbon::parse($data_single->start_date)->diffForHumans() }}
                                        </td> --}}
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $data->render() }}
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