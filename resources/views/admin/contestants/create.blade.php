@extends('admin.layouts.default')

@section('styles')

@endsection

@section('admin.breadcrumb')
    <li class='breadcrumb-item active'>Create Contestant</li>
@endsection

@section('admin.content')
<div class="container-fluid mt--6">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
    <div class="card">
        <!-- Card header -->
        <div class="card-header">
            <h2 class="mb-2"><i class="fas fa-ticket-alt"></i> Create New {{ $title }}</h2>
            <a href="{{ route('admin.contestants.index')}}" class="btn btn-primary btn-sm">
                <i class="fa fa-arrow-left"></i> Back
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

            <form class="form-horizontal offset-sm-2" role="form" method="POST" action="{{route('admin.contestants.store')}}" enctype="multipart/form-data">
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
    <script type='text/javascript'>
    
        $(document).ready(function(){
        
        })
    </script>
@endsection