@extends('account.layouts.default')

@section('content')

<div class="header pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="/account/dashboard">Dashboard</a></li>
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
        <div class="col-xl-3 col-md-6">
            <div class="card bg-gradient-primary border-0">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0 text-white">Contestants</h5>
                            <span class="h2 font-weight-bold mb-0 text-white">{{ $contestants }}</span>
                            <div class="progress progress-xs mt-3 mb-0">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="30" aria-valuemin="0"
                                    aria-valuemax="100" style="width: 100%;"></div>
                            </div>
                        </div>
                        {{-- <div class="col-auto">
                            <button type="button" class="btn btn-sm btn-neutral mr-0" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div> --}}
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <a href="#" class="btn btn-sm btn-danger text-nowrap text-white font-weight-600">See details</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-gradient-info border-0">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total Votes</h5>
                            <span class="h2 font-weight-bold mb-0 text-white">{{ $no_of_votes }}</span>
                            <div class="progress progress-xs mt-3 mb-0">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="50" aria-valuemin="0"
                                    aria-valuemax="100" style="width: 100%;"></div>
                            </div>
                        </div>
                        {{-- <div class="col-auto">
                            <button type="button" class="btn btn-sm btn-neutral mr-0" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div> --}}
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <a href="#!" class="btn btn-sm btn-success text-nowrap text-white font-weight-600">See details</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-gradient-danger border-0">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0 text-white">Added votes</h5>
                            <span class="h2 font-weight-bold mb-0 text-white">{{ $no_of_votes - $paid_votes }}</span>
                            <div class="progress progress-xs mt-3 mb-0">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="80" aria-valuemin="0"
                                    aria-valuemax="100" style="width: 100%;"></div>
                            </div>
                        </div>
                        {{-- <div class="col-auto">
                            <button type="button" class="btn btn-sm btn-neutral mr-0" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div> --}}
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <a href="#!" class="btn btn-sm btn-primary text-nowrap text-white font-weight-600">See details</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-gradient-default border-0">
                <!-- Card body -->
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0 text-white">Total Amount</h5>
                            <span class="h2 font-weight-bold mb-0 text-white">{{ $amount }}</span>
                            <div class="progress progress-xs mt-3 mb-0">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="90" aria-valuemin="0"
                                    aria-valuemax="100" style="width: 100%;"></div>
                            </div>
                        </div>
                        {{-- <div class="col-auto">
                            <button type="button" class="btn btn-sm btn-neutral mr-0" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div> --}}
                    </div>
                    <p class="mt-3 mb-0 text-sm">
                        <span id="paymentdetails" style="cursor: pointer" class="btn btn-sm btn-warning text-nowrap text-white font-weight-600">See details</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="card">
            <div class="card-header bg-transparent">
            <div class="row align-items-center">
                <div class="col">
                <h6 class="text-uppercase text-muted ls-1 mb-1">Performance</h6>
                <h5 class="h3 mb-0">Total orders</h5>
                </div>
            </div>
            </div>
            <div class="card-body">
            <!-- Chart -->
                <div class="chart">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                                        
                    <div class="loader"></div>

                    <canvas id="chart-bars1" class="chart-canvas chartjs-render-monitor" width="341" height="350" style="display: block; width: 341px; height: 350px;">
                    
                    </canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="paymentdetailmodal" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
    <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h6 class="modal-title" id="modal-title-default">Payment Datils</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
              <div class="col-md-6 text-center"><strong>Payment Methods</strong></div>
              <div class="col-md-6 text-center"><strong>Total Amount Earned</strong></div>
          </div>
          <hr class="mt-1 mb-4">
          <div id='details'>

          </div>
        </div>
        <div class="modal-footer">
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
          <button type="button" class="btn btn-link  ml-auto" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
    $('#paymentdetails').click(function(){
        $.ajax({
            type: 'get',
            url: '/payment/getdetails',
            data:{
                _token: "{{ csrf_token() }}",
            },
            success: function(data) {
                $('#details').empty();
                data.forEach(element => {
                    $('#details').append('<div class="row"><div class="col-md-6 text-center">'+element.gateway+'</div><div class="col-md-6 text-center">'+element.totalamount+" "+element.currency+'</div></div><hr class="m-1">');
                });
                $('#paymentdetailmodal').modal();
            },
            error: function() {
                $('#details').html("<div class='col-md-6 text-center' style='color:red'>There is some error</div>");
                $('#paymentdetailmodal').modal();
            },
        }); 
    });
</script>
<script>
    $(document).ready(function(){
        $.ajax({
            type: 'post',
            url: '/account/getdashboardsalesdata',
            data:{
                _token: "{{ csrf_token() }}",
            },
            beforeSend: function(){
                $('.loader').css('display','block');
            },
            success: function(data)
            {
                // alert(data.length);
                var months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
                var ngnarray = new Array();
                var usdarray = new Array();
                var ngnamount = new Array();
                var usdamount = new Array();

                for (let i = 0; i < data.length; i++) {
                    if(data[i].currency == "NGN"){
                        ngnarray.push(data[i]);
                    }
                }

                for (let i = 0; i < data.length; i++) {
                    if(data[i].currency == "USD"){
                        usdarray.push(data[i]);
                    }
                }

                let index = 0; let m = 0;
                while(m<12){
                    if ((ngnarray[index]) && (ngnarray[index].month == months[m]) ){
                        ngnamount.push(ngnarray[index].totalamount);
                        index++; m++;
                    }else{
                        ngnamount.push(0);
                        m++;
                    }
                }

                index = 0; m = 0;
                while(m<12){
                    if ((usdarray[index]) && (usdarray[index].month == months[m]) ){
                        usdamount.push(usdarray[index].totalamount);
                        index++; m++;
                    }else{
                        usdamount.push(0);
                        m++;
                    }
                }
                
                new Chart(document.getElementById("chart-bars1"), {
                    type: 'line',
                    data: {
                        labels: months,
                        datasets: [
                            {
                                label: "NGN",
                                backgroundColor: "rgba(0, 0, 255, 0.3)",
                                borderColor: "blue",
                                data: ngnamount,
                                pointBackgroundColor: 'midnightblue',
                                pointRadius: 5,
                            },
                            {
                                label: "USD",
                                backgroundColor: "rgba(0, 255, 0, 0.3)",
                                borderColor: "green",
                                data: usdamount,
                                pointBackgroundColor: 'darkgreen',
                                pointRadius: 5,
                            }
                        ]
                    },
                    options: {
                        title: {
                            display: true,
                            text: 'Total Income (Month)'
                        }
                    }
                });
            },
            complete: function(){
                $('.loader').css('display','none');
            }
        });
    })
</script>
@endsection