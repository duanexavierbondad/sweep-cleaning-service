<?php
    use App\Models\Booking;
    use App\Models\Customer;
    use App\Models\Service;
    use App\Models\Price;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Customer Transactions</title>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript">
            $(document).ready(function(){
                $('.menu-toggle').click(function(){
                    $('nav').toggleClass('active')
                })
            })
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style_customer.css')}}">
</head>
<body>
    <header>
        <div class="logo"> 
            SWEEP 
        </div>
        <nav>
            <ul>
                <li ><a href="customer_dashboard">Home</a></li>
                <li><a href="customer_services">Services</a></li>
                <li  class="active"><a href="customer_transaction">Transaction</a></li>
                <li><a href="customer_history">History</a></li>
                <div class="customer_notif_icon">
                    <button class="btn dropdown-toggle dropdown_notif_icon" type="button" id="menu2" data-toggle="dropdown" >
                        <i class="bi bi-bell"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Notification 1</a>
                    <a class="dropdown-item" href="#">Notification 2</a>
                </div>
                <div class="profile_btn">
                    <button class="btn dropdown-toggle" type="button" id="menu1" data-toggle="dropdown" >
                        <img src="/img/user.png" class="profile_img">
                        <span class="caret"></span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="customer_profile">Profile</a>
                    <a class="dropdown-item" href="{{ route('auth.logout') }}">Logout</a>
                    </div>
                </div>
            </ul>
        </nav>
        <div class="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></div>
    </header>
    <div class="customer_search_con">
        <form action="/action_page.php">
            <input type="text" placeholder="Search" name="search" class="customer_search_field">
        </form>
    </div>
    <div class="col-2 d-flex customer_trans_title_con">
        <div>
            <h1 class="customer_cards_title">BOOKINGS</h1> 
        </div>
    </div>

    <?php
        $customer_id = Customer::Where('user_id', $LoggedUserInfo['user_id'] )->value('customer_id');
        $booking_data = Booking::Where('customer_id', $customer_id )->get();
    ?>
    @foreach($booking_data as $key => $value)
    <?php
        $service_data = Service::Where('service_id', $value->service_id )->get();
        $price = Price::Where('property_type', $value->property_type )->get();
    ?>
    <div class="customer_trans_con">
        <div class="column col_customer_trans">
            <div class="row row_customer_trans">
                <div class="card card_customer_trans p-4">
                    <div class="d-flex">
                        <img src="/img/broom.png" class="customer_trans_broom_img p-1">
                        @foreach($service_data as $key => $data)
                        @foreach($price as $key => $price_data)
                        <div class="d-flex flex-column">
                            <h5 class="customer_trans_status">{{ $value->status }}</h5>
                            <h3 class="customer_trans_title">{{ $data->service_name}}</h3>
                            <h6 class="customer_trans_date_1_1">{{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}</h6>
                            <h6 class="customer_trans_price_1">P{{ $price_data->price }}</h6>
                            <div class="d-flex view_details_con">
                                <button type="button" class="btn btn-link customer_view_details_btn" data-toggle="modal" data-target="#exampleModalLong10">
                                    DETAILS
                                </button>
                                <button type="button" class="btn btn-block btn-primary pay_btn" data-toggle="modal" data-target="#exampleModalLong1010"> 
                                    Pay 
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModalLong1010" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <!-- Modal content-->
                                        <div class="modal-content customer_trans_modal_content_inside_inside">
                                            <div class="modal-header customer_trans_modal_header_inside_inside">
                                                <div class="p-3 modal_inside_inside_con">
                                                    <h3 class="customer_trans_title_pay">{{ $data->service_name}}</h3>
                                                    <h6 class="customer_trans_price_pay_1">Total Amount: P{{ $price_data->price }}</h6>
                                                    <div class="d-flex payments_con">
                                                        <img src="/img/gcash.png" class="gcash_img">
                                                        <img src="/img/paypal.png" class="paypal_img">
                                                    </div> 
                                                    <div class="d-flex cancel_confirm_pay_con">
                                                        <button type="button" class="btn btn-block btn-primary cancel_btn" data-dismiss="modal"> CANCEL </button>
                                                        <button type="button" class="btn btn-block btn-primary confirm_btn"> CONFIRM </button>
                                                    </div>  
                                                </div>
                                                <button type="button" class="close pl-2" data-dismiss="modal">&times;</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModalLong10" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <!-- Modal content-->
                                    <div class="modal-content p-4 customer_trans_modal_content">
                                        <div class="modal-header customer_trans_modal_header">
                                        <div class="d-flex pt-5">
                                            <img src="/img/broom.png" class="customer_trans_broom_2_1_img p-1">
                                            <div class="d-flex flex-column">
                                                <h4 class="customer_trans_modal_title">{{ $data->service_name}}</h4>
                                                <h6 class="customer_trans_modal_date_1_1">{{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}</h6>
                                                <h6 class="customer_trans_modal_amount_1">Total Amount: P{{ $price_data->price }}</h6>
                                            </div>
                                        </div>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body d-flex p-4">
                                            <div class="customer_trans_modal_body_1_con">
                                            <p class="customer_trans_description">
                                                {{ $data->description}}                                            </p>
                                            <ul class="customer_package_list">
                                                <li><b>Equipment:</b> {{ $data->equipment}}</li>
                                                <br>
                                                <li><b>Materials:</b> {{ $data->material}}</li>
                                                <br>
                                                <li><b>Personal Protection:</b> {{ $data->personal_protection}}</li>
                                                <br>
                                                <li><b>Property Type:</b> {{ $value->property_type}}</li>    
                                                <li><b>Cleaners:</b> {{ $price_data->number_of_cleaner}}</li>     
                                            </ul>
                                            </div>
                                        </div>
                                        <div class="modal-footer customer_trans_modal_footer">
                                            <button type="button" class="btn btn-block btn-primary big_cancel_btn" data-toggle="modal" data-target="#exampleModalLong1011">
                                                CANCEL
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModalLong1011" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <!-- Modal content-->
                                                    <div class="modal-content customer_trans_modal_content_inside">
                                                        <div class="modal-header customer_trans_modal_header_inside">
                                                            <div class="p-3 customer_trans_modal_inside_con">
                                                                <h3 class="cancel_booking_question">Are you sure you want to cancel your booking?</h3>
                                                                <div class="d-flex no_yes_con">
                                                                    <button type="button" class="btn btn-block btn-primary no_btn" data-dismiss="modal"> NO </button>
                                                                    <button type="button" class="btn btn-block btn-primary yes_btn" data-toggle="modal" data-target="#exampleModalLong10111"> 
                                                                        YES 
                                                                    </button>
                                                                </div>
                                                                <!-- Modal -->
                                                                <div class="modal fade" id="exampleModalLong10111" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <!-- Modal content-->
                                                                        <div class="modal-content customer_trans_modal_content_inside_inside">
                                                                            <div class="modal-header customer_trans_modal_header_inside_inside">
                                                                                <div class="customer_trans_modal_inside_con">
                                                                                    <h3 class="provide_reason_title">Provide Reason</h3>
                                                                                    <div class="provide_reason_con">
                                                                                        <form action="/action_page.php">
                                                                                            <textarea type="text" id="reason" class="provide_reason_field"></textarea>
                                                                                        </form>
                                                                                    </div>
                                                                                    <div class="d-flex cancel_confirm_con">
                                                                                        <button type="button" class="btn btn-block btn-primary cancel_btn" data-dismiss="modal"> CANCEL </button>
                                                                                        <button type="button" class="btn btn-block btn-primary confirm_btn"> CONFIRM </button>
                                                                                    </div>
                                                                                </div>
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>     
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endforeach
    @endforeach
</body>
</html>