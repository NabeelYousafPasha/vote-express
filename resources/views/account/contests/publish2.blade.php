<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.partials._head')
    <style>
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
            background: rgba(255, 255, 255, 0.2);
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
            background-image: linear-gradient(45deg, #f8a239 5%, #ed7f08 46%, #f6570d 88%) !important;
            border: transparent !important;
            color: white !important;
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

        /*-------------------------*/

        @media only screen and (max-width: 614px) {
            .abs-avatar {
                position: absolute !important;
                top: 45px !important;
                left: 2.8rem !important;
            }
        }
        .abs-avatar {
                position: absolute;top: 45px;left: 9px;
        }

        .btn-secondary{
            color: #1c4c6a;
            background-color: #ffffff;
            border-color: #6c757d;
        }
    </style>
</head>
<body>
    <!-- Page Loading -->
    <div class="se-pre-con"></div>
        <div id="app" style="background: #1e2a45; ">
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
                    <div class="text-white p-5 text-center" style="padding-top: 0 !important;
                    padding-bottom: 0 !important;">
                        <div id="clock" class="countdown-circles d-flex flex-wrap pt-2"></div>
                    </div>
                </div>
                <div class="container text-center">
                    <div class="heading">
                        <h2 style="color: #ebbb0f">
                            {{-- <img src="{{asset('img/left-leaf.png')}}" width="5%" alt=""> --}}
                            <img src="{{asset('storage/'.$contest->contest_logo)}}" width="15%" alt="">
                            {{-- <img src="{{asset('img/right-leaf.png')}}" width="5%" alt=""> --}}

                            {{-- <img src="{{asset('img/left-leaf.png')}}" width="5%" alt="">{{ $contest->title }}<img src="{{asset('img/right-leaf.png')}}" width="5%" alt=""> --}}
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
                                <div class="col-md-3 mb-5 @if (count($contest->contestants) == 3) mx-auto @endif">
                                    <div class="box" style="padding-top: 0;padding-bottom: 5px;overflow: hidden;">
                                        <div class="row" style="height: 100px;background-image: linear-gradient(45deg, #f8a239 5%, #ed7f08 46%, #f6570d 88%);">
            
                                        </div>
                                        <div class="row abs-avatar">
                                            <img class="avatar avatar-sm rounded-circle mx-auto" style="border: 5px solid #efe3e3;border: 5px solid #efe3e3;" src="{{asset('storage/uploads/contestants').'/'.$contestant->avatar}}" width="50%" alt="">
                                            <h3 class="mt-3" style="width: 100%;">{{ $contestant_data['firstName'] }}</h3>
                                        </div>
                                        <div class="row" style="margin-top: 7rem">
                                            <a style="margin-top: 19px;border-radius: 5px;" name="vote_btn" onclick="{{$contest->contest_type=='free' ? "updateVote($contestant->id)" : "selectpayment()"}}" href="#" {{$contest->contest_type=='paid' ? 'data-toggle=modal data-target=#paymentModal' : '' }} data-contestentid="{{ $contestant->id }}" data-contestid="{{ $contest->id }}" class="btn-2 mx-auto vote">Vote</a>
                                        </div>
                                        <div class="row" style="margin-top: 0.5rem;border-top: 1px solid #b0b0b0;">
                                            <p class="mx-auto" style="color: green;margin-top: 1.5rem;">{{ $contestant->votes }}</p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="col-md-3 mb-5 @if ($loop->iteration == 4) mx-auto @endif">
                                    <div class="box" style="padding-top: 0;padding-bottom: 5px;overflow: hidden;">
                                        <div class="row" style="height: 100px;background-image: linear-gradient(45deg, #f8a239 5%, #ed7f08 46%, #f6570d 88%);">

                                        </div>
                                        <div class="row abs-avatar">
                                            <img class="avatar avatar-sm rounded-circle mx-auto" style="border: 5px solid #efe3e3;border: 5px solid #efe3e3;" src="{{asset('img/avatar.png')}}" width="50%" alt="">
                                            <h3 class="mt-3" style="width: 100%;">{{ $contestant->name }}</h3>
                                        </div>
                                        <div class="row" style="margin-top: 7rem">
                                            <a style="margin-top: 19px;border-radius: 5px;" name="vote_btn" onclick="{{$contest->contest_type=='free' ? "updateVote($contestant->id)" : "selectpayment()"}}" href="#" {{$contest->contest_type=='paid' ? 'data-toggle=modal data-target=#paymentModal' : '' }} class="btn-2 mx-auto">Vote</a>
                                        </div>
                                        <div class="row" style="margin-top: 0.5rem;border-top: 1px solid #b0b0b0;">
                                            <p class="mx-auto" style="color: green;margin-top: 1.5rem;">30%</p>
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
                                <button type="button" data-paymethod="flutter" class="btn btn-secondary payment"><a class="nav-link active text-center"><img width="75%" src="{{asset('img/flutterwave_logo_color.png')}}" alt=""></a>
                                </button>
                            </div>
                            <div class="col-md-5 mx-auto">
                                <button type="button" data-paymethod="bitcoin" class="btn btn-secondary payment" style="width: 100%">
                                    <a class="nav-link text-center" style="font-size: 1.2rem;"><i class="fab fa-bitcoin" style="color: #deb839"></i> Bitcoin</a>
                                </button>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-5 mx-auto">
                                <button type="button" data-paymethod="paystack" class="btn btn-secondary payment" style="width: 100%">
                                    <a class="nav-link text-center" style="font-size: 1.2rem;">
                                        <i class="fas fa-layer-group"></i> 
                                        Paystack
                                    </a>
                                </button>
                            </div>
                            <div class="col-md-5 mx-auto">
                                <button type="button" data-paymethod="paypal" class="btn btn-secondary payment" style="width: 100%">
                                    <a class="nav-link text-center" style="font-size: 1.2rem;"><i class="fab fa-paypal" style="color: #3e93ef;"></i> Paypal</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.partials.footer')

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

            $('#clock').countdown('2021/1/1').on('update.countdown', function(event) {
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
            // alert(contestent_id);
            // alert(contest_id);
            // alert(email);
            // alert(no_of_votes);
            // alert(paymethod);
            // alert(paymenturl);
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
                        // console.log(res);
                        // if(paymethod = 'flutter'){
                        //     alert('flutter');
                        //     $('body').html(res);
                        // }else{
                        //     alert('others');
                            window.open(res,'_self')
                        // }
                        // $('body').empty();
                        // $('body').html(res);
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

        // function selectpayment()
        // {
        //     $('#paymentModal').toggle();
        // }
    </script>

</body>
</html>

