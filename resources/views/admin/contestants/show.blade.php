@extends('admin.layouts.default')

@section('admin.breadcrumb')
    <li class='breadcrumb-item active'>Contestants</li>
@endsection

@section('admin.content')

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

<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card card-default">
                <div class="card-header border-0">
                    <h2 class="mb-2"> <i class="fa fa-calendar"></i>{{ $titles }}
                    </h2>
                    <a href="{{ route('admin.contestants.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
                <div class="card-body">
                    @if($dataa->isEmpty())
                    <h3 class="text-center">You have not created any {{ $title }}.</h3>
                    @else
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>SR #</th>
                                    @if (!is_null($dataa[0]->form_data))
                                        @foreach(json_decode($dataa[0]->form_data, true) as $key => $daata)
                                            @if($key !== 'submit')
                                                <th>{{ $key }}</th>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach($table['fields'] as $key => $val)
                                            {{-- <th>{{ text_format(key(collect($val)->toArray())) }}</th> --}}
                                            <th>{{ $val ?? text_format($key) }}</th>
                                        @endforeach
                                    @endif
                                    <th>Avatar</th>
                                    <th>Add Votes</th>

                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dataa as $index => $data_single)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        @if (!is_null($dataa[0]->form_data))
                                            @foreach(json_decode($data_single->form_data, true) as $key => $entry)
                                                @if($key == 'address')
                                                    <td>{{ $entry['formatted_address'] }}</td>
                                                @elseif($key == 'tags')
                                                    <td>
                                                        @foreach (explode(",",$entry) as $t)
                                                            <span class="badge adge badge-info">{{ $t }}</span>
                                                        @endforeach
                                                    </td>
                                                @elseif($key == 'submit')
                                                    
                                                @else
                                                    <td>{{ $entry }}</td>
                                                @endif

                                            @endforeach
                                        @else
                                            
                                            <td>{{ $data_single->name }}</td>
                                            <td>{{ $data_single->email }}</td>
                                            <td>{{ $data_single->phone }}</td>
                                            <td>{{ $data_single->avatar}}</td>
                                            <td>{{ $data_single->contest_id }}</td>
                                            <td>{{$data_single->votes}}</td>
                                        @endif

                                        <td>
                                            @if(!is_null($data_single->avatar))
                                                <img src="{{ asset('storage/'.$data_single->avatar) }}" width="15%" alt="">
                                            @else
                                                <img src="{{ asset('storage/uploads/contestants/default-contestant.png') }}" width="15%" alt="">
                                            @endif
                                            <form style="display: inline-block" class="avatarform" action="{{ route('admin.contestants.upload.avatar') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input style="display: inline-block" type="file" name="avatar" class="form-control" style="width:50%">
                                                <input style="display: inline-block" type="hidden" name="contestant_id" value="{{$data_single->id}}">
                                                <button style="display: inline-block" class="btn btn-primary btn-sm upload-avatar">Upload</button>
                                            </form>
                                        </td>

                                        <td>
                                            <form style="display: inline-block" class="avatarform" action="{{ route('admin.contestants.add.votes') }}" method="POST">
                                                @csrf
                                                <span>{{$data_single->votes}} + </span>
                                                <input style="display: inline-block" type="number" name="added_votes" value="" class="form-control" style="width:20%">
                                                <input style="display: inline-block" type="hidden" name="contestant_id" value="{{$data_single->id}}">
                                                <button style="display: inline-block" class="btn btn-primary btn-sm upload-avatar">Add</button>
                                            </form>
                                        </td>

                                        <td>
                                            @php

                                            $route_param = array();
                                            $route_param[$key_name] = $data_single->$key_name;
                                            @endphp
                                            <span class="btn-group">
                                                
                                                <a class="btn btn-primary" href="@if($route_name_edit) {{ route($route_name_edit,$route_param) }}?queryy={{!is_null($dataa[0]->form_data)? 'form_data' : 'uploaded_data'}} @endif"><i class="fa fa-edit "></i></a>

                                                <form action="{{ route('admin.contestant.destroy',$data_single->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" type="submit"><i class="fa fa-trash-o "></i></b>
                                                </form>
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
                    {{ $dataa->render() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection