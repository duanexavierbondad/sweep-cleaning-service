<?php
    use App\Models\Booking;
    use App\Models\Customer;
    use App\Models\Service;
    use App\Models\Price;
    use App\Models\User;
    use App\Models\Cleaner;
    use App\Models\Assigned_cleaner;
?>

@extends('customer/customer-nav/head_extention_customer-transactions') 

@section('content')
    
<head>
    <link href="{{ asset('css/customer_trans.css') }}" rel="stylesheet">
    <title>
        Customer Transaction Page
    </title>
</head>
<body>
    <div class="row head">
        <div class="col-md-8">
            <div class="service_title">
                <h1 class="customer_cards_title">
                    BOOKINGS
                </h1> 
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <?php
            $customer_id = Customer::Where('user_id', $LoggedUserInfo['user_id'] )->value('customer_id');
            $booking_data = Booking::Where('customer_id', $customer_id )->Where('status','!=', 'Declined' )->Where('status', '!=','Completed')->Where('status', '!=','Cancelled')->get();
        ?>
        @foreach($booking_data as $key => $value)
            <?php
                $booking_id = Booking::where('booking_id', $value->booking_id )->value('booking_id');
                $service_data = Service::Where('service_id', $value->service_id )->get();
                $price = Price::Where('property_type', $value->property_type )->Where('service_id', $value->service_id )->get();
            ?>
        <div class="card  mb-3" style="width: 25rem;">
            <div class="row no-gutters">
             
                    @foreach($service_data as $key => $data)
                        @foreach($price as $key => $price_data)
                            <div class="card-body"> 
                                <div class="status">
                                    <h5 class="customer_trans_status">
                                        {{ $value->status }}
                                    </h5>
                                </div>
                                <div class="card_body">
                                    <h3 class="service_title_trans">
                                        {{ $data->service_name }}
                                    </h3>
                                </div>
                                <div> 
                                    <h6 class="booking_date">
                                        <b>Transaction ID:</b> {{ $booking_id }}
                                    </h6>
                                </div>
                                
                                <table class="table table-striped user_info_table">
                                    <tbody>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Schedule:
                                            </th>
                                            <td class="user_table_data">
                                                {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                                            </td>
                                        </tr>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Property:
                                            </th>
                                            <td class="user_table_data">
                                                {{ $value->property_type}}
                                            </td>
                                        </tr>
                                        <tr class="user_table_row">
                                            <th scope="row" class="user_table_header">
                                                Price:
                                            </th>
                                            <td class="user_table_data">
                                                P{{ $price_data->price }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="buttons">
                                    <div class="byt float-right">
                                        <button type="button" class="btn btn-primary pay_btn" data-toggle="modal" data-target="#exampleModalLong10-{{ $value->booking_id }}">
                                            DETAILS
                                        </button>
                                        @if($value->status == "Pending" || $value->is_paid == false) 
                                        <button type="button" class="btn btn-primary pay_btn"  onclick="document.location='{{ route('customer_pay', $value->booking_id) }}'"> 
                                            Pay 
                                        </button>
                                        @endif
                                        @if($value->status == "Done")               
                                        <button type="button" class="btn btn-primary rate_btn" onclick="document.location='{{ route('customer_rating', $value->booking_id) }}'"> 
                                            Rate 
                                        </button>
                                        @endif
                                    </div>
                                </div>
                  </div>
            </div>
                        <div class="modal fade" id="exampleModalLong10-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true"> <!-- Modal -->
                            <div class="modal-dialog" role="document">
                                <div class="modal-content p-4 customer_trans_modal_content"> <!-- Modal Content -->
                                    <div class="modal-header customer_trans_modal_header">
                                            <img src="/img/broom.png" class="customer_trans_broom_2_1_img p-1">
                                            <div class="d-flex flex-column">
                                                <h4 class="customer_trans_modal_title">
                                                    {{ $data->service_name}}
                                                </h4>
                                                <h6 class="customer_trans_modal_date_1_1">
                                                    {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                                                </h6>
                                                <h6 class="customer_trans_modal_amount_1">
                                                    Total Amount: P{{ $price_data->price }}
                                                </h6>
                                            </div>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                        <div class="modal-body d-flex p-4">
                                            <div class="customer_trans_modal_body_1_con">
                                            <p class="customer_trans_description">
                                                {{ $data->service_description}}                                            
                                            </p>
                                            <ul class="customer_package_list">
                                                <li>
                                                    <b>Equipment:</b> {{ $data->equipment }}
                                                </li>
                                                <br>
                                                <li>
                                                    <b>Materials:</b> {{ $data->material }}
                                                </li>
                                                <br>
                                                <li>
                                                    <b>Personal Protection:</b> {{ $data->personal_protection }}
                                                </li>
                                                <br>
                                                <li>
                                                    <b>Property Type:</b> {{ $value->property_type }}
                                                </li> 
                                                <?php
                                                     $id = Assigned_cleaner::Where('booking_id', $value->booking_id )->Where('status', '!=', 'Declined')->Where('status', '!=', 'Pending')->get();
                                                ?>
                                                <br>    
                                                <li>
                                                    <b>Cleaners:</b>
                                                </li> 
                                                @if($id != null)
                                                @foreach($id as $cleaner)
                                                <?php

                                                    $user_id = Cleaner::Where('cleaner_id', $cleaner->cleaner_id )->value('user_id');
                                                    $full = User::Where('user_id', $user_id )->value('full_name');

                                                ?>
                                                <li class="list_booking_info">
                                                    <b>Name:</b> {{ $full }}
                                                </li>
                                                @endforeach  
                                                @endif    
                                            </ul>
                                            </div>
                                        </div>
                                        <div class="modal-footer customer_trans_modal_footer">
                                        @if($value->status != "On-Progress" && $value->status != "Done") 
                                            <button type="button" class="btn btn-block btn-primary big_cancel_btn" data-toggle="modal" data-target="#canceltransaction-{{ $value->booking_id }}" >
                                                CANCEL
                                            </button>
                                        @endif
                                        </div>
                                </div> <!-- End of Modal Content --> 
                            </div>
                        </div> <!-- End of Modal -->
                                            <div class="modal fade" id="canceltransaction-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">  <!-- Modal -->
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content customer_trans_modal_content_inside"> <!-- Modal Content -->
                                                        <div class="modal-header customer_trans_modal_header_inside">
                                                            <div class="p-3 customer_trans_modal_inside_con">
                                                                <h3 class="cancel_booking_question">
                                                                    Are you sure you want to cancel your booking?
                                                                </h3>
                                                                <form action="{{ route('updateStatus') }}" method="post">
                                                                @if(Session::get('success'))
                                                                    <div class="alert alert-success">
                                                                        {{ Session::get('success') }}
                                                                    </div>
                                                                @endif

                                                                @if(Session::get('fail'))
                                                                    <div class="alert alert-danger">
                                                                        {{ Session::get('fail') }}
                                                                    </div>
                                                                @endif

                                                                @csrf
                                                                <input type="hidden" name="booking_id" value="{{ $value->booking_id }}">
                                                                   
                                                                <div class="d-flex no_yes_con">
                                                                    <button type="button" class="btn btn-block btn-primary no_btn" data-dismiss="modal"> 
                                                                        NO 
                                                                    </button>
                                                                    <button type="submit" class="btn btn-block btn-primary yes_btn" name="status" value="Cancelled"> 
                                                                        YES 
                                                                    </button>
                                                                </div>
                                                                </form>
                                                            </div>
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                    </div> <!-- End of Modal Content -->
                                                </div>
                                            </div> <!-- End of Modal -->
                    @endforeach
                @endforeach
        </div>
    @endforeach
    </div>
    <div class="footer">
        <div class="sweep-title">
            SWEEP © 2021. All Rights Reserved.
        </div>
</div>
</body>
@endsection