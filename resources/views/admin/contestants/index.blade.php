@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item active'>Contest</li>
@endsection

@section('admin.content')
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card card-default">
                <div class="card-header border-0">
                    <h2 class="mb-2"> <i class="fa fa-calendar" style="margin-right: 5px"></i>Contests
                        {{-- <span class="float-right">
                            <a href="{{ route('account.contestants.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Create New {{ $title }}
                            </a>
                        </span> --}}
                    </h2>
                    <a href="{{ route('admin.contest.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    @if($contest->isEmpty())
                        <h3 class="text-center">You have not created any Contest.</h3>
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
                                            
                                            <span >
                                                @if (!is_null($data_single->form_data))
                                                    <a href="{{ route('admin.contest.getForm') }}?contest_id={{$data_single->id}}" class="btn btn-primary btn-sm">
                                                        <i class="fa fa-plus"></i> Form Entry
                                                    </a>
                                                @else
                                                    <a href="{{ route('admin.contestants.create') }}?contest_id={{$data_single->id}}" class="btn btn-secondary btn-sm">
                                                        <i class="fa fa-upload"></i> Import Data
                                                    </a>
                                                @endif
                                                
                                                <a href="{{ route('admin.contestants.index') }}?contest_id={{$data_single->id}}" class="btn btn-success btn-sm">
                                                    <i class="fa fa-eye"></i> View Contestants
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