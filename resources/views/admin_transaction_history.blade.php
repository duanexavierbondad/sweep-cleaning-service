<?php
    use App\Models\Booking;
    use App\Models\Customer;
    use App\Models\Service;
    use App\Models\Price;
    use App\Models\Address;
    use App\Models\User;
    use App\Models\Cleaner;
    use App\Models\Notification;
    use App\Models\Assigned_cleaner;
    use App\Models\Review;
    use App\Models\Cleaner_review;
    use App\Models\Service_review;
?>
@extends('head_extention_admin')

@section('content')
<title>
    Admin Transaction History Page
</title>

<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<link rel="stylesheet" type="text/css" href="{{ asset('css/style_admin.css')}}">
<script src="{{ asset('js/app.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/toast.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/notif.css')}}">

<div id="app">
    <nav class="navbar navbar-expand-lg navbar-light sweep-nav shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brandname" href="{{ url('/') }}">
                SWEEP
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <a href="admin_dashboard" class="nav-link">
                        Home
                    </a>
                    <a class="nav-link" href="admin_services" role="button">
                        Services
                    </a>
                    <a class="nav-link" href="admin_transaction" role="button" id="active">
                        Transactions
                    </a>
                    <a class="nav-link" href="admin_user" role="button">
                        User
                    </a>
                    <a class="nav-link" href="admin_payroll" role="button">
                        Payroll
                    </a>
                    <a class="nav-link" href="admin_reports" role="button">
                        Reports
                    </a>
                    <li class="nav-item dropdown" id="admin">
                        <?php
                            $notifCount = Notification::where('isRead', false)->where('user_id', null)->count();
                            $notif = Notification::where('isRead', false)->where('user_id', null)->orderBy('id', 'DESC')->get();
                        ?>
                        <a id="navbarDropdown admin" class="nav-link" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fa fa-bell"></i>
                            @if($notifCount != 0)
                            <span class="badge alert-danger pending">{{$notifCount}}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right notification" aria-labelledby="navbarDropdown">
                            @forelse ($notif as $notification)
                            <a class="dropdown-item read" id="refresh" href="/{{$notification->location}}/{{$notification->id}}">
                                {{ $notification->message}}
                            </a>

                            @empty
                            <a class="dropdown-item">
                                No record found
                            </a>
                            @endforelse
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ $LoggedUserInfo['email'] }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" data-dismiss="modal" data-toggle="modal" data-target="#logout">
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<body>
    <?php
        $booking_data = Booking::Where('status', 'Completed')->orWhere('status', 'Declined')->orWhere('status', 'Cancelled')->orderBy('updated_at', 'DESC')->get();
        $transaction_count = Booking::Where('status', 'Pending')->orWhere('status', 'In-Progress')->orWhere('status', 'Accepted')->orWhere('status', 'Done')->count();
        $history_count = Booking::Where('status', 'Completed')->orWhere('status', 'Declined')->orWhere('status', 'Cancelled')->count();
    ?>
    <div class="row">
        <!-- Sub Header -->
        <a class="user_type_btn" href="admin_transaction">
            TRANSACTION
            <p class="total_value">
                ({{ $transaction_count }})
            </p>
        </a>
        <a class="user_type_btn" id="active" href="admin_transaction_history">
            HISTORY
            <p class="total_value">
                ({{ $history_count }})
            </p>
        </a>
    </div>

    <div class="trans_his_con">
        <!-- Transaction History Table -->
        <table class="table table-responsive-md table-hover" id="history_table">
            <thead class="row_title">
                <tr class="table_trans_his_row">
                    <th scope="col" class="user_table_trans_his_header">
                        Customer Name
                    </th>
                    <th scope="col" class="user_table_trans_his_header">
                        Service Name
                    </th>
                    <th scope="col" class="user_table_trans_his_header">
                        Service Fee
                    </th>
                    <th scope="col" class="user_table_trans_his_header">
                        Mode of Payment
                    </th>
                    <th scope="col" class="user_table_trans_his_header">
                        Status
                    </th>
                    <th scope="col" class="user_table_trans_his_header">
                    </th>
                </tr>
            </thead>
            <tbody>

                @foreach($booking_data as $key => $value)

                <?php
                    $service = Service::Where('service_id', $value->service_id)->get();
                    $userID = Customer::Where('customer_id', $value->customer_id)->value('user_id');
                    $address = Address::Where('customer_id', $value->customer_id)->value('address');
                    $user = User::Where('user_id', $userID)->get();
                ?>
                @foreach($service as $key => $service_data)

                <?php
                    $price = Price::Where('property_type', $value->property_type)->Where('service_id', $value->service_id)->get();
                ?>
                @foreach($price as $key => $price_data)
                @foreach($user as $key => $user_data)

                <tr class="table_trans_his_row">
                    <th class="user_table_data">
                        {{ $user_data -> full_name }}
                    </th>
                    <td class="user_table_data">
                        {{ $service_data -> service_name }}
                    </td>
                    <td class="user_table_data">
                        ₱{{ $price_data -> price }}
                    </td>
                    <td class="user_table_data">
                        {{ $value -> mode_of_payment }}
                    </td>
                    <td class="user_table_data">
                        {{ $value -> status }}
                    </td>
                    <td class="user_table_data">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#details-{{ $value->booking_id }}">
                            View Details
                    </td>
                    </button>

                    <div class="modal fade" id="details-{{ $value->booking_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                        <!-- Modal -->
                        <div class="modal-dialog" role="document">
                            <div class="modal-content p-3 trans_modal_content">
                                <!-- Modal Content-->
                                <div class="modal-header trans_modal_header">
                                    <div class="d-flex pt-5">
                                        <i class="bi bi-card-checklist check_icon_inside"></i>
                                        <h4 class="modal_service_title_trans">
                                            {{ $service_data->service_name }}
                                        </h4>
                                    </div>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <ul class="customer_detail">
                                    <li>
                                        <b>Customer:</b>
                                    </li>
                                    <li class="list_booking_info">
                                        <b>Name:</b> {{ $user_data->full_name }}
                                    </li>
                                    <li class="list_booking_info">
                                        <b>Contact Number:</b> {{ $user_data->contact_number }}
                                    </li>
                                    <li class="list_booking_info">
                                        <b>Address:</b> {{ $address }}
                                    </li>
                                    <br>
                                    <li>
                                        <b>Service:</b>
                                    </li>
                                    <li class="list_booking_info">
                                        <b>Date:</b> {{ date('F d, Y', strtotime($value->schedule_date)) }} {{ date('h:i A', strtotime($value->schedule_time)) }}
                                    </li>
                                    <?php
                                        $price = Price::Where('property_type', $value->property_type)->Where('service_id', $value->service_id)->get();
                                    ?>
                                    @foreach($price as $price_data)
                                    <li class="list_booking_info">
                                        <b>Cleaner/s:</b> {{ $price_data->number_of_cleaner}}
                                    </li>
                                    <li class="list_booking_info">
                                        <b>Property Type:</b> {{ $value->property_type}}
                                    </li>
                                    <li class="list_booking_info">
                                        <b>Status:</b> {{ $value->status }}
                                    </li>
                                    <li class="list_booking_info">
                                        <b>Price:</b> ₱{{ $price_data->price }}
                                    </li>
                                    <br>
                                    <li>
                                        <b>Payment:</b>
                                    </li>
                                    <li class="list_booking_info">
                                        <b>Mode of Payment:</b> {{ $value->mode_of_payment }}
                                    </li>
                                    @if ( $value->mode_of_payment == 'Paypal')
                                    <li class="list_booking_info">
                                        <b>Paypal ID:</b> {{ $value->paypal_id }}
                                    </li>
                                    @endif
                                    @if ( $value->is_paid == true)
                                    <li class="list_booking_info">
                                        <b>Status:</b> Paid
                                    </li>
                                    @endif
                                    <br>
                                    <?php
                                        $id = Assigned_cleaner::Where('booking_id', $value->booking_id)->Where('status', '!=', 'Declined')->Where('status', '!=', 'Pending')->get();
                                    ?>
                                    <li>
                                        <b>Cleaners:</b>
                                    </li>
                                    @if($id != null)
                                    @foreach($id as $cleaner)
                                    <?php
                                        $user_id = Cleaner::Where('cleaner_id', $cleaner->cleaner_id)->value('user_id');
                                        $full = User::Where('user_id', $user_id)->value('full_name');
                                    ?>
                                    <li class="list_booking_info">
                                        <b>Name:</b> {{ $full }}
                                    </li class="list_booking_info">
                                    <?php
                                        $reviewId = Review::where('booking_id', $value->booking_id)->where('review_type', 'Cleaner')->get();
                                    ?>
                                    @if($reviewId != null)
                                    @foreach($reviewId as $review)

                                    <?php
                                        $total = Cleaner_review::where('review_id', $review->review_id)->where('cleaner_id', $cleaner->cleaner_id)->value('rate');
                                    ?>
                                    @if($total != null)


                                    </li>
                                    <div class="starRate">
                                        <?php
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($total >= $i) {
                                                    echo "<i class='fa fa-star' style='color:yellow'></i>"; //fas fa-star for v5
                                                } else {
                                                    echo "<i class='fa fa-star-o'></i>"; //far fa-star for v5
                                                }
                                            }

                                            $comment = Cleaner_review::where('review_id', $review->review_id)->where('cleaner_id', $cleaner->cleaner_id)->value('comment');
                                        ?>
                                    </div>
                                    <li class="list_booking_info">
                                        <b>Comment:</b> {{$comment}}
                                    </li>
                                    @endif
                                    @endforeach
                                    @endif

                                    <li>
                                        <b>Service Feedback:</b>
                                    </li>
                                    <li class="list_booking_info">

                                        <?php
                                            $review_id = Review::where('booking_id', $value->booking_id)->where('review_type', 'Service')->value('review_id');
                                        ?>
                                        @if($review_id != null)
                                    </li>
                                    <div class="starRate">
                                        <?php
                                            $total = Service_review::where('review_id', $review_id)->value('rate');

                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($total >= $i) {
                                                    echo "<i class='fa fa-star' style='color:yellow'></i>"; //fas fa-star for v5
                                                } else {
                                                    echo "<i class='fa fa-star-o'></i>"; //far fa-star for v5
                                                }
                                            }

                                            $comment = Service_review::where('review_id', $review_id)->value('comment');
                                        ?>
                                    </div>
                                    <li class="list_booking_info">
                                        <b>Comment:</b> {{$comment}}
                                        @endif
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </tr>

                @endforeach
                @endforeach
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div> <!-- End of Transaction History Table -->

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

    <!-- Datatables Scripts -->
    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap4.min.js"></script>

    <!-- Datatable -->
    <script>
        $(document).ready(function() {
            $('#history_table').DataTable();
        });
    </script>

    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('21a2d0c6b21f78cd3195', {
            cluster: 'ap1'
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 8000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        var channel = pusher.subscribe('my-channel');
        channel.bind('admin-notif', function(data) {

            var result = data.messages;

            Toast.fire({
                animation: true,
                icon: 'success',
                title: JSON.stringify(result),
            })

            var pending = parseInt($('#admin').find('.pending').html());
            if (pending) {
                $('#admin').find('.pending').html(pending + 1);
            } else {
                $('#admin').find('.pending').html(pending + 1);
            }
            $('#refresh').load(window.location.href + " #refresh");
        });
    </script>

    <!-- Scripts -->
    <div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <div class="icon">
                        <i class="fa fa-sign-out-alt"></i>
                    </div>
                    <div class="title">
                        Are you sure you want to logout?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                        No
                    </button>
                    <button type="button" class="btn btn-danger" onclick="document.location='{{ route('auth.logout') }}'">
                        Yes
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
@endsection