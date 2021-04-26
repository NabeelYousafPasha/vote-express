@extends('account.layouts.default')
@section('title', 'My Contests')
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
                            <li class="breadcrumb-item"><a href="/account/dashboard">Dashboard / Contests</a></li>
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
                            <a href="{{ route('account.contest.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Create New {{ $title }}
                            </a>
                        </span>
                    </h2>
                </div>
                @if($data->isEmpty())
                <h3 class="text-center">You have not created any {{ $title }}.</h3>
                @else
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>SR #</th>
                                @foreach($table['fields'] as $key => $val)
                                {{-- <th>{{ text_format(key(collect($val)->toArray())) }}</th> --}}
                                <th>{{ $val ?? text_format($key) }}</th>
                                @endforeach
                                <th>Logo</th>
                                <th>Contestants</th>
                                <th>URL</th>
                                @if( Auth::user()->subscriptions()->first()->stripe_plan =="Premium")
                                    <th>iFrame-URL</th>
                                @endif
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

                                <td><img src="{{ asset('storage/'.$data_single->contest_logo) }}" width="80" height="60" alt=""></td>

                                <td>{{ count($data_single->Contestants) ?? '' }}</td>
                                <td>
                                    {{ route('contest.publish',$data_single->id) }}
                                </td>

                                @if( Auth::user()->subscriptions()->first()->stripe_plan =="Premium")
                                <td>
                                    <textarea class="iframearea" readonly name="" id="" cols="70" rows="3">{{ '<iframe src="'.route('iframe.publish', Crypt::encrypt($data_single->id)). '" style="position:fixed; top:0; left:0; bottom:0; right:0; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;"> </iframe>'}}</textarea>
                                    <button class="btn btn-sm btn-primary copyiframe" style="vertical-align: top">copy</button>
                                </td>
                                @endif
                                
                                <td>
                                    @php

                                     $route_param = array();
                                     $route_param[$key_name] = $data_single->$key_name;
                                    @endphp
                                    <span class="badge badge-dot mr-4">
                                        {{-- <a href="@if($route_name_show) {{ route($route_name_show,$route_param) }} @endif"><span class="badge adge badge-success">View</span></a> --}}
                                        <a href="{{ route('account.contest.publish',$data_single->id) }}"><span class="badge adge badge-primary">Publish</span></a>

                                        <a href="@if($route_name_edit) {{ route($route_name_edit,$route_param) }} @endif"><span class="badge adge badge-info">Edit</span></a>
                                        
                                        <a href="" onclick="event.preventDefault(); document.getElementById('delete-contest-{{ $data_single->id }}').submit();"><span class="badge badge-danger">Delete</span></a>

                                        <form action="{{ route('account.contest.destroy',$data_single->id) }}" method="POST" id="delete-contest-{{ $data_single->id }}" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" value="{{ $data_single->id }}" name="id">
                                       </form>
                                    </span>
                                </td>
                                <td>
                                    @if (!$data_single->Contestants->isEmpty()) 
                                        @if ($data_single->Contestants[0]->form_data ==null)
                                            
                                        @else
                                            <a href="{{ route('account.contest-form.manage') }}?contest={{$data_single->id}}">
                                            <span class="badge adge badge-success" >Build Form</span>
                                            </a>
                                        @endif
                                        
                                    @else
                                        <a href="{{ route('account.contest-form.manage') }}?contest={{$data_single->id}}">
                                            <span class="badge adge badge-success" >Build Form</span>
                                        </a>
                                    @endif
                                    <a href="{{route('account.contestants.index')}}">
                                        <span class="badge adge badge-primary" >Add Contestants</span>
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
<script>
    $(".copyiframe").click(function(){
        $(this).siblings('.iframearea').select();
        // $("textarea").select();
        document.execCommand('copy');
    });
</script>
@endsection