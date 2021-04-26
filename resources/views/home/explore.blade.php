@extends('layouts.app')
@section('styles')
    <style>
        .our-price .box h4 span {
            font-size: 22px;
            color:black !important;
        }
        .thead{
            border:1px solid black;
            /* border-top-right-radius: 10px; */
            /* border-top-left-radius: 10px; */
            /* border-collapse: separate !important;  */
            font-weight: bold
        }
    </style>
@endsection
@section('content')

    <!-- ======== Start Our Price ======== -->
    <section class="our-price" id="price">
        <div class="container text-center">
            <div class="heading">
                
                <h2>Live Contests</h2>
            </div>
            <div class="line"></div>
            <div class="row box">
                <div class="col-md-12 mx-auto">
                    {{-- <div class="box"> --}}
                        <table class="table">
                            <thead class="thead">
                                <tr>
                                    <td>Serial #</td>
                                    <td>Contest Image</td>
                                    <td>Contest Title</td>
                                    <td>Contest Type</td>
                                    <td>Contest End Date</td>
                                    <td>Contest Link</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($contest as $item)
                                    
                                    <tr>
                                        <td>{{ $count++ }}
                                            
                                        </td>
                                        <td style="width: 30%">
                                            <img src="{{asset('storage/'.$item->contest_logo)}}" width="50%" alt="">
                                        </td>
                                        <td style="width: 20%">
                                            <h3>{{ $item->title }}</h3>
                                        </td>
                                        <td style="width: 20%">
                                            <h3>{{ $item->contest_type }}</h3>
                                        </td>
                                        <td style="width: 20%">
                                            <h3>{{ date('d-m-Y',strtotime($item->end_date)) }}</h3>
                                        </td>
                                        <td style="width: 20%">
                                            {{-- @if(isset($item->owner) && $item->owner->role->slug == "admin-root") --}}
                                                {{-- <a href="{{ route('admin.contest.publish',$item->id) }}" class="btn-1" style="margin-top:0px">Go to contest</a> --}}
                                            {{-- @elseif(isset($item->owner) && $item->owner->role->slug == "admin") --}}
                                                <a href="{{ route('contest.publish',$item->id) }}" class="btn-1" style="margin-top:0px">Go to contest</a>
                                            {{-- @endif --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </section>
    <!-- ======== End Our Price ======== -->
@endsection
