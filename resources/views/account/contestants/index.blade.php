@extends('account.layouts.default')
@section('title', 'Contestants')
@section('content')

{{-- Table Settings --}}
{{-- @php
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

@endphp --}}

{{-- Table Settings --}}

<div class="header pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="/account/dashboard">Dashboard / Contestants</a></li>
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
    <div class="row">
        <div class="col">
            <div class="card card-default">
                <div class="card-header border-0">
                    <h2 class="mb-0"> <i class="fas fa-calendar"></i>{{ $titles }}
                        {{-- <span class="float-right">
                            <a href="{{ route('account.contestants.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Create New {{ $title }}
                            </a>
                        </span> --}}
                    </h2>
                </div>
                @if($contest->isEmpty())
                    <h3 class="text-center">You have not created any {{ $title }}.</h3>
                @else
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>SR #</th>
                                {{-- @foreach($table['fields'] as $key => $val) --}}
                                {{-- <th>{{ text_format(key(collect($val)->toArray())) }}</th> --}}
                                {{-- <th>{{ $val ?? text_format($key) }}</th> --}}
                                {{-- @endforeach --}}
                                <th>Contest</th>
                                {{--<th>Description</th>
                                <th>Location</th>
                                <th>Start Date</th>
                                <th>End Date</th> --}}
                                <th>Contestants</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contest as $index => $data_single)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $data_single->title }}</td>
                                    {{-- <td>{{ $data_single->email }}</td>
                                    <td>{{ $data_single->phone }}</td>
                                    <td>{{ $data_single->avatar}}</td>
                                    <td>{{ $data_single->contest_id }}</td>
                                    <td>{{$data_single->votes}}</td> --}}
                                    <td>
                                        @php

                                        /* $route_param = array();
                                        $route_param[$key_name] = $data_single->$key_name; */
                                        @endphp
                                        {{-- <span class="badge badge-dot mr-4">
                                            <a href="@if($route_name_show) {{ route($route_name_show,$route_param) }} @endif"><span class="badge adge badge-success">View</span></a>
                                
                                            <a href="@if($route_name_edit) {{ route($route_name_edit,$route_param) }} @endif"><span class="badge adge badge-info">Edit</span></a>
                                            
                                            <a href="" onclick="event.preventDefault(); document.getElementById('delete-contestant-{{ $data_single->id }}').submit();"><span class="badge badge-danger">Delete</span></a>

                                            <form action="{{ route('account.contestant.destroy',$data_single->id) }}" method="POST" id="delete-contestant-{{ $data_single->id }}" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" value="{{ $data_single->id }}" name="id">
                                            </form>
                                        </span> --}}
                                        <span >
                                            @if (!is_null($data_single->form_data))
                                                <a href="{{ route('account.contest.getForm') }}?contest_id={{$data_single->id}}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-plus"></i> Form Entry
                                                </a>
                                            @else
                                                <a href="{{ asset('img/required-format.xlsx') }}" class="btn btn-secondary">
                                                    <span>Required Format:</span>
                                                    <img src="{{ asset('img/excel.png') }}" width="45" height="40" alt="">
                                                </a>
                                                <a href="{{ route('account.contestants.create') }}?contest_id={{$data_single->id}}" class="btn btn-secondary btn-sm">
                                                    <i class="fas fa-upload"></i> Import Data
                                                </a>
                                            @endif
                                            
                                            <a href="{{ route('account.contestants.index') }}?contest_id={{$data_single->id}}" class="btn btn-success btn-sm">
                                                <i class="fas fa-eye"></i> View Contestants
                                            </a>
                                        </span>
                                    </td>

                                    {{-- <td>
                                        {{ \Carbon\Carbon::parse($data_single->start_date)->diffForHumans() }}
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $contest->render() }}
                @endif
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