<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.partials._head')
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat&display=swap');
        .progress {
            background-color: #d8d8d8;
            border-radius: 20px;
            position: relative;
            margin: 15px 0;
            height: 15px;
            width: 75%;
        }

        .progress-done {
            /* background: linear-gradient(to left, #F2709C, #FF9472); */
            background: linear-gradient(to right, goldenrod, yellow);

            /* box-shadow: 0 3px 3px -5px #F2709C, 0 2px 5px #F2709C; */
            box-shadow: 0 3px 3px -5px gold, 0 2px 5px gold;

            border-radius: 20px;
            color: black;
            font-weight: 700;
            font-size: 15px;
            /* color: #fff; */
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            width: 0;
            opacity: 0;
            transition: 1s ease 0.3s;
        }
        .circles{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .circles li{
            position: absolute;
            display: block;
            list-style: none;
            width: 20px;
            height: 20px;
            /* background: rgba(255, 255, 255, 0.2); */
            background: rgba(235, 187, 15, 0.2);

            animation: animate 25s linear infinite;
            bottom: -150px;
            
        }

        .circles li:nth-child(1){
            left: 25%;
            width: 80px;
            height: 80px;
            animation-delay: 0s;
        }


        .circles li:nth-child(2){
            left: 10%;
            width: 20px;
            height: 20px;
            animation-delay: 2s;
            animation-duration: 12s;
        }

        .circles li:nth-child(3){
            left: 70%;
            width: 20px;
            height: 20px;
            animation-delay: 4s;
        }

        .circles li:nth-child(4){
            left: 40%;
            width: 60px;
            height: 60px;
            animation-delay: 0s;
            animation-duration: 18s;
        }

        .circles li:nth-child(5){
            left: 65%;
            width: 20px;
            height: 20px;
            animation-delay: 0s;
        }

        .circles li:nth-child(6){
            left: 75%;
            width: 110px;
            height: 110px;
            animation-delay: 3s;
        }

        .circles li:nth-child(7){
            left: 35%;
            width: 150px;
            height: 150px;
            animation-delay: 7s;
        }

        .circles li:nth-child(8){
            left: 50%;
            width: 25px;
            height: 25px;
            animation-delay: 15s;
            animation-duration: 45s;
        }

        .circles li:nth-child(9){
            left: 20%;
            width: 15px;
            height: 15px;
            animation-delay: 2s;
            animation-duration: 35s;
        }

        .circles li:nth-child(10){
            left: 85%;
            width: 150px;
            height: 150px;
            animation-delay: 0s;
            animation-duration: 11s;
        }

        @keyframes animate {

            0%{
                transform: translateY(0) rotate(0deg);
                opacity: 1;
                border-radius: 0;
            }

            100%{
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
                border-radius: 50%;
            }

        }

        .btn-2{
            /* background-image: linear-gradient(90deg, #b48811 5%, #FFDF00 46%, #b48811 88%); */
            /* background-image: linear-gradient(45deg, #f8a239 5%, #ed7f08 46%, #f6570d 88%) !important; */
            
            border: transparent !important;
            color: gold !important;
        }

        /*------------------------
        /-------countdown---------*/
        .countdown {
            text-transform: uppercase;
            font-weight: bold;
        }

        .countdown span {
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
            font-size: 3rem;
            margin-left: 0.8rem;
        }

        .countdown span:first-of-type {
            margin-left: 0;
        }

        .countdown-circles {
            text-transform: uppercase;
            font-weight: bold;
        }

        .countdown-circles div {
            color: #ebbb0f !important;
        }

        .countdown-circles span {
            width: 80px;
            height: 80px;
            border-radius: 10%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }

        .countdown-circles span:first-of-type {
            margin-left: 0;
        }

        .topimgs{
            text-align: right;
        }

        .topavatar{
            width:13%;
            border: 5px solid #efe3e3;
        }

        .contestlogo{
            width: 13%;
        }

        /*-------------------------*/
        @media only screen and (max-width: 334px) {
            .countdown-circles span {
                width: 54px !important;
                height: 54px !important;
            }
            .countdown-circles .h1{
                font-size: 1.7rem !important;
            }
            .topimgs{
                text-align: center;
            }
            .topavatar{
                width:30%;
                border: 2px solid #efe3e3;
            }
            .contestlogo{
                width: 50%;
            }
        }

        @media only screen and (min-width: 334px) and (max-width: 375px) {
            .countdown-circles span {
                width: 60px !important;
                height: 60px !important;
            }
            .countdown-circles .h1{
                font-size: 1.7rem !important;
            }
            .topimgs{
                text-align: center;
            }
            .topavatar{
                width:30%;
                border: 2px solid #efe3e3;
            }
            .contestlogo{
                width: 50%;
            }
        }

        @media only screen and (min-width: 375px) and (max-width: 768px) {
            .countdown-circles span {
                width: 60px !important;
                height: 60px !important;
            }
            .countdown-circles .h1{
                font-size: 1.7rem !important;
            }
            .topimgs{
                text-align: center;
            }
            .topavatar{
                width:17%;
                border: 2px solid #efe3e3;
            }
            .contestlogo{
                width: 17%;
            }
        }

        @media only screen and (max-width: 614px) {
            .abs-avatar {
                position: relative !important;
                top: 40px !important;
            }
        }
        .abs-avatar {
                position: relative;
                top: 40px;
                margin: auto
        }
        .custom-avatar{
            border: 5px solid #efe3e3; 
            border-radius:10%; 
            border-color:gold
        }
        .btn-secondary{
            color: #1c4c6a;
            background-color: #ffffff;
            border-color: #6c757d;
        }

    </style>
</head>
<body>
    <span id="contest_id" style="display: none">{{ $contest->id }}</span>
    <!-- Page Loading #1e2a45;-->
    <div class="se-pre-con"></div>
        <div id="app" style="background: #1a1a1a; ">
            <ul class="circles">
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
            </ul>
            <!-- ======== Start Our Price ======== -->
            <div id="fluterframe">
            </div>
            <section class="our-price" id="price" style="padding: 70px 0;padding-top: 0;">

                <div class="container" style="max-width: 100%;">
                    <div class="row">

                        <div class="col-md-6">
                            <input id="end_date" type="date" value="{{ date('Y-m-d' , strtotime($contest->end_date)) }}" hidden>
                            <div id="clock" class="countdown-circles d-flex flex-wrap pt-2">
                                {{-- <div class="holder m-2"><span class="h1 font-weight-bold">%D</span> Day%!d</div>
                <div class="holder m-2"><span class="h1 font-weight-bold">%H</span> Hr</div>
                <div class="holder m-2"><span class="h1 font-weight-bold">%M</span> Min</div>
                <div class="holder m-2"><span class="h1 font-weight-bold">%S</span> Sec</div> --}}
                            </div>
                        </div>
                        <div class="col-md-6 topimgs pr-4">
                            @foreach ($contest->topfivecontestants as $contestant)
                                @if(isset($contestant->avatar))
                                    <img class="avatar avatar-sm topavatar rounded-circle mt-4" src="{{asset('storage/'.$contestant->avatar)}}"  alt="">
                                @else
                                    <img class="avatar avatar-sm topavatar rounded-circle mt-4" src="{{asset('storage/uploads/contestants/default-contestant.png')}}"  alt="">
                                @endif
                            {{-- <span class="pt-4 ml-auto">
                                <img class="avatar avatar-sm rounded-circle" src="{{asset('img/banklogo.png')}}" width="25%" height="25%" alt="">
                            </span> --}}
                            @endforeach
                            {{-- <span class="pt-4 ml-auto">
                                <img class="avatar avatar-sm rounded-circle" src="{{asset('img/banklogo.png')}}" width="25%" height="25%" alt="">
                            </span>
                            <span class="pt-4 ml-auto">
                                <img class="avatar avatar-sm rounded-circle" src="{{asset('img/banklogo.png')}}" width="25%" height="25%" alt="">
                            </span> --}}
                        </div>
                    </div>
                    {{-- <div class="text-white p-5 text-center" style="padding-top: 0 !important;
                    padding-bottom: 0 !important;">
                    </div> --}}

                </div>
                <div class="container text-center">

                    <div class="heading mt-3">
                        <h2 style="color: #ebbb0f">
                            <img class="contestlogo" src="{{asset('storage/'.$contest->contest_logo)}}" alt="">
                        </h2>
                    </div>
                    <div class="line"></div>
                    <div class="row">

                        <!-- Box-1 -->
                        @foreach ($contest->contestants as $contestant)
                            @if (!is_null($contest->contestants[0]->form_data))
                                @php
                                    $contestant_data=json_decode($contestant->form_data, true);
                                @endphp
                                <div class="col-md-4 mb-5 @if (count($contest->contestants) == 3) mx-auto @endif" >
                                    <div class="box" style="padding-top: 0;padding-bottom: 5px;overflow: hidden; background: #4A0000">
                                        {{-- <div class="row" style="height: 100px;background-image: linear-gradient(45deg, #f8a239 5%, #ed7f08 46%, #f6570d 88%);">
            
                                        </div> --}}
                                        <div class="row abs-avatar">
                                            @if(isset($contestant->avatar))
                                                <img class="avatar avatar-sm custom-avatar mx-auto" src="{{asset('storage/'.$contestant->avatar)}}" width="60%" alt="">
                                            @else
                                                <img class="avatar avatar-sm custom-avatar mx-auto" src="{{asset('storage/uploads/contestants/default-contestant.png')}}" width="60%" alt="">
                                            @endif
                                            <h3 class="mt-3 mx-auto" style="width: 100%; color:gold">{{ $contestant_data['firstName'] }}</h3>
                                        </div>
                                        <div class="row" style="margin-top: 3rem">
                                            <a style="margin-top: 19px;border-radius: 5px; background-color:black; color:gold" name="vote_btn" onclick="{{$contest->contest_type=='free' ? "updateVote($contestant->id)" : "selectpayment()"}}" href="#" {{$contest->contest_type=='paid' ? 'data-toggle=modal data-target=#paymentModal' : '' }} data-contestentid="{{ $contestant->id }}" data-contestid="{{ $contest->id }}" class="btn-2 mx-auto vote">Vote</a>
                                        </div>
                                        <div class="row" style="margin-top: 0.5rem;border-top: 1px solid #b0b0b0;">
                                            @if($contest->vote_count == "number")
                                                <p class="mx-auto" style="color:gold; margin-top: 1.5rem; font-size:1.5rem">{{ $contestant->votes }} Votes</p>
                                            @elseif($contest->vote_count == "percentage")
                                                <div class="progress mx-auto">
                                                    <span class="vote_count" style="display: none">{{ $contestant->votes }}</span>
                                                    <span class="votetopercent" style="display: none">{{ $contest->votetopercent }}</span>
                                                    <div class="progress-done" data-done="">
                                                        <span style="margin-left:min(35px)"></span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                            <div class="col-md-4 mb-5 @if ($loop->iteration == 4) mx-auto @endif" >
                                <div class="box" style="padding-top: 0;padding-bottom: 5px;overflow: hidden; background: #4A0000">
                                    <div class="row abs-avatar">
                                        @if(isset($contestant->avatar))
                                            <img class="avatar avatar-sm custom-avatar mx-auto" src="{{asset('storage/'.$contestant->avatar)}}" width="60%" alt="">
                                        @else
                                            <img class="avatar avatar-sm custom-avatar mx-auto" src="{{asset('storage/uploads/contestants/default-contestant.png')}}" width="60%" alt="">
                                        @endif
                                        <h3 class="mt-3 mx-auto" style="width: 100%; color:gold">{{ $contestant->nameame}}</h3>
                                    </div>
                                    <div class="row" style="margin-top: 3rem">
                                        <a style="margin-top: 19px;border-radius: 5px; background-color:black; color:gold" name="vote_btn" onclick="{{$contest->contest_type=='free' ? "updateVote($contestant->id)" : "selectpayment()"}}" href="#" {{$contest->contest_type=='paid' ? 'data-toggle=modal data-target=#paymentModal' : '' }} data-contestentid="{{ $contestant->id }}" data-contestid="{{ $contest->id }}" class="btn-2 mx-auto vote">Vote</a>
                                    </div>
                                    <div class="row" style="margin-top: 0.5rem;border-top: 1px solid #b0b0b0;">
                                        @if($contest->vote_count == "number")
                                            <p class="mx-auto" style="color:gold; margin-top: 1.5rem; font-size:1.5rem">{{ $contestant->votes }} Votes</p>
                                        @elseif($contest->vote_count == "percentage")
                                            <div class="progress mx-auto">
                                                <span class="vote_count" style="display: none">{{ $contestant->votes }}</span>
                                                <span class="votetopercent" style="display: none">{{ $contest->votetopercent }}</span>
                                                <div class="progress-done" data-done="">
                                                    <span style="margin-left:min(35px)"></span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                        
                        @endforeach
                    </div>
                </div>
            </section>
            <!-- ======== End Our Price ======== -->
        </div>
        <!-- Modal -->
        <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mx-auto" style="min-width: 50%;" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-image: linear-gradient(45deg, #f8a239 5%, #ed7f08 46%, #f6570d 88%);">
                        <h5 class="modal-title text-white" id="exampleModalLongTitle">Select Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3 mx-auto pl-2">
                                <label for="">Email : </label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="email form-control" name="email" placeholder="Email"/>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3 mx-auto pl-2">
                                <label for="">No of Votes : </label>
                            </div>
                            <div class="col-md-6">
                                <input type="number" class="no_of_votes form-control" name="no_of_votes" placeholder="Number of votes"/>    
                            </div>
                        </div>
                        <input type="hidden" class="contestent_id" name="contestent_id"/>
                        <input type="hidden" class="contest_id" name="contest_id"/>
                        <div class="row mt-4">    
                            <div class="col-md-5 mx-auto">
                                <button type="button" data-paymethod="flutter" class="btn btn-secondary payment">
                                    <a class="nav-link active text-center">
                                        <img width="75%" src="{{asset('img/flutterwave_logo_color.png')}}" alt="">
                                    </a>
                                </button>
                            </div>
                            <div class="col-md-5 mx-auto">
                                <button type="button" data-paymethod="paystack" class="btn btn-secondary payment" style="width: 100%">
                                    <a class="nav-link text-center" style="font-size: 1.2rem;">
                                        <i class="fas fa-layer-group"></i> 
                                        Paystack
                                    </a>
                                </button>
                            </div>
                            
                        </div>
                        <div class="row mt-4">
                            {{-- <div class="col-md-5 mx-auto">
                                <button type="button" data-paymethod="bitcoin" class="btn btn-secondary payment" style="width: 100%">
                                    <a class="nav-link text-center" style="font-size: 1.2rem;">
                                        <i class="fab fa-bitcoin" style="color: #deb839"></i>
                                         Bitcoin
                                    </a>
                                </button>
                            </div> --}}
                            @if($contest->contest_currency == "USD")
                            <div class="col-md-5 mx-auto">
                                <button type="button" data-paymethod="paypal" class="btn btn-secondary payment" style="width: 100%">
                                    <a class="nav-link text-center" style="font-size: 1.2rem;">
                                        <i class="fab fa-paypal" style="color: #3e93ef;"></i> 
                                        Paypal
                                    </a>
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('layouts.partials.footer') --}}

    @include('layouts.partials._scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>
    <script>
        $(document).ready(function(){
            /* if({{ (Session::has('errors')) }})
            {
                $('#myModal').modal('show');
            } */

            var end_date = $('#end_date').val();
            $('#clock').countdown(end_date).on('update.countdown', function(event) {
                var $this = $(this).html(event.strftime('' +
                '<div class="holder m-2"><span class="h1 font-weight-bold">%D</span> Day%!d</div>' +
                '<div class="holder m-2"><span class="h1 font-weight-bold">%H</span> Hr</div>' +
                '<div class="holder m-2"><span class="h1 font-weight-bold">%M</span> Min</div>' +
                '<div class="holder m-2"><span class="h1 font-weight-bold">%S</span> Sec</div>'));
            });
        });

        function updateVote(contestant_id)
        {
            //alert(contestant_id);
            if(contestant_id !== null)
            {
                $.ajax({
                    type: 'PUT',
                    url: '/account/vote-update/'+contestant_id,
                    data:{
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(res) {
                        Swal.fire(
                            'Thankyou!',
                            'Your Vote is added',
                            'success'
                        );
                    },
                    error: function(data) {
                        Swal.fire(
                            'Error!',
                            'Something went wrong ! ',
                            'error'
                        );
                    },
                    
                });
            }
        }



        $('.vote').click(function(){
            var contestent_id = $(this).data('contestentid');
            var contest_id = $(this).data('contestid');
            $('.contestent_id').val(contestent_id); 
            $('.contest_id').val(contest_id);
        });

        $('.payment').click(function(){
            var contestent_id = $('.contestent_id').val();
            var contest_id = $('.contest_id').val();
            var email = $('.email').val();
            var no_of_votes = $('.no_of_votes').val();
            var paymethod = $(this).data('paymethod');
            var paymenturl;
            
            switch (paymethod) {
                case 'flutter':
                    paymenturl='/payment/flutter';
                    break;
                case 'bitcoin':
                    paymenturl='/payment/bitcoin';
                    break;
                case 'paystack':
                    paymenturl='/payment/paystack';
                    break;
                case 'paypal':
                    paymenturl='/payment/paypal';
                    break;
            };
            console.log(email);
            if(email == ""){
                $('.email').css('border','1px solid red');
            }else{
                $('.email').css('border','1px solid grey');
            }
            if(no_of_votes == ""){
                $('.no_of_votes').css('border','1px solid red');
            }else{
                $('.no_of_votes').css('border','1px solid grey');
            }
            if(contestent_id == ""){
                alert("Contestent id is not present");
            }
            if(contest_id == ""){
                alert("Contest id is not present");
            }
            if(contestent_id !== "" && contest_id !== "" && email !== "" && no_of_votes !== "")
            {
                var arr = new Array();
                var record1 = {
                    'contestant_id':contestent_id,
                    'contest_id':contest_id,
                    'email':email,
                    'no_of_votes':no_of_votes
                    };
                arr.push(record1);

                $.ajax({
                    type: 'POST',
                    url: paymenturl,
                    data:{
                        _token: "{{ csrf_token() }}",
                        meta: JSON.stringify(arr),
                        contestant_id : contestent_id,
                        contest_id : contest_id,
                        email : email,
                        no_of_votes : no_of_votes,
                    },
                    beforeSend: function(){
                        $('.se-pre-con').css('display','block');
                    },
                    success: function(res) {
                        window.open(res,'_self')
                        // $.ajax({
                        //     type: 'GET',
                        //     url: '/checkpayment',
                        //     data:{
                        //         _token: "{{ csrf_token() }}",
                        //     },
                        //     beforeSend: function(){
                        //         alert('payment waiting');
                        //         $('.se-pre-con').css('display','block');
                        //     },
                        //     success: function(res) {
                        //         alert(res);
                        //     },
                        //     error: function(data) {
                        //         Swal.fire(
                        //             'Error!',
                        //             'Something went wrong ! ',
                        //             'error'
                        //         );
                        //     },
                        //     complete: function(){
                        //         $('.se-pre-con').css('display','none');
                        //     }
                        // });
                    },
                    error: function(data) {
                        Swal.fire(
                            'Error!',
                            'Something went wrong ! ',
                            'error'
                        );
                    },
                    complete: function(){
                        $('.se-pre-con').css('display','none');
                    }
                });
            }
        });

        function checkPayment()
        {
            $.ajax({
                    type: 'GET',
                    url: '/checkpayment',
                    data:{
                        _token: "{{ csrf_token() }}",
                    },
                    beforeSend: function(){
                        alert('payment waiting');
                        $('.se-pre-con').css('display','block');
                    },
                    success: function(res) {
                        alert("paid");
                    },
                    error: function(data) {
                        Swal.fire(
                            'Error!',
                            'Something went wrong ! ',
                            'error'
                        );
                    },
                    complete: function(){
                        $('.se-pre-con').css('display','none');
                    }
                });
        }
    </script>
    <script>
        // $(document).ready(function(){
        //     var contest = $('#contest_id').text();
        //     // alert(contest);
        //     $.ajax({
        //         type:'GET',
        //         url:'/admin/getVotePercentage',
        //         data:{
        //             contest:contest,
        //             _token:"{{ csrf_token() }}",
        //         },
        //         success: function(data){
        //             console.log(data);
        //         }
        //     })
        // });

        var progress = $('.progress-done');
        // const data = ["0","20","40","60","80","100"];
        progress.each(function(i,element){
            // console.log();
            // const random = Math.floor(Math.random() * data.length);
            let votecount = $(this).siblings('.vote_count').text();
            let votetopercent = $(this).siblings('.votetopercent').text();
            let percent = votecount / votetopercent;

            $(this).css('opacity',1);
            $(this).css('width',percent+"%");
            $(this).data('done',percent);
            $(this).children('span').text(percent+"%");


        });

        for (let i = 0; i < progress.length; i++) {
            

            // progress[i].style.opacity = 1;
            // progress[i].style.width=data[random]+"%";
            // progress[i].setAttribute('data-done',data[random]);
            // progress[i].childNodes[1].innerHTML = data[random]+"%";

        }
        
    </script>

</body>
</html>

