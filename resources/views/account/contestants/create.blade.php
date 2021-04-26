@extends('account.layouts.default')
@section('title',  $titles)

@section('styles')
    <link rel='stylesheet' href='https://unpkg.com/formiojs@latest/dist/formio.full.min.css'>
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
                            <li class="breadcrumb-item"><a href="/account/dashboard">Dashboard / Contestants / Create</a></li>
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
    <div class="card">
        <!-- Card header -->
        <div class="card-header">
            <h2 class="mb-0"><i class="fas fa-ticket-alt"></i> Create New {{ $title }}</h2>
            <a href="{{ URL::previous() }}" class="btn btn-primary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
        <!-- Card body -->
        <div class="card-body">
                @if (count($errors)>0)
                    <div class="alert alert-danger">
                        Upload validation error
                        <br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            <form class="form-horizontal offset-sm-2" role="form" method="POST" action="{{route('account.contestants.store')}}" enctype="multipart/form-data">
                {!! csrf_field() !!}

                <div class="form-group" style="width: 50%;display: none">
                    <input value="{{$contest->id}}" name="contest_id" type="hidden">
                </div>

                {{-- @component('text',['name' => 'title'])@endcomponent --}}
                <div class="form-group" style="width: 50%" id="importBtn">
                    <label for="exampleFormControlSelect1">Upload Contestants data</label>
                    <div class="form-control">
                        <input class="text-primary" type="file" name="contestants_file" id="">
                    </div>
                </div>
                
                <div id="formDataShow" style="display: none">
                    <div id='builder'></div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 col-md-offset-6">
                        <button type="submit" class="btn btn-primary">
                           </i>Submit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src='https://unpkg.com/formiojs@latest/dist/formio.full.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
    <script type='text/javascript'>
    
        $(document).ready(function(){
            /* $('[name="contest_id"]').on('change',function(){
                var formData=$(this).children('option:selected').attr('formData');
                
                if (formData !== '') {
                    var contest_id=$(this).children('option:selected').val();
                    console.log(contest_id);
                    if (contest_id !== '') {
                        $('#importBtn').css('display','none');
                        $.ajax({
                            url:'{{route('account.contest.getForm')}}',
                            method: 'get',
                    
                            data: {
                                _token: "{{ csrf_token() }}",
                                contest_id: contest_id
                            },
                            success: function(result){
                                console.log(result);
                                
                                Formio.createForm(document.getElementById('builder'), result);
                            },
                            error: function(data) {
                                console.log(data);
                            }
                        });
                        $('#formDataShow').css('display','');
                    }
                    
                } else {
                    $('#importBtn').css('display','');
                    $('#formDataShow').css('display','none');
                }
            }) */
        })
    </script>
@endsection