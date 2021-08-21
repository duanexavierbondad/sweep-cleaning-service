<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style_admin.css')}}">
    <title> SWEEP </title>
</head>
<body class="login_body">
    <div class="login_con">
        <div class="row" style="margin-top:45px">
            <h4 class="signin_label">Sign In</h4>
            <form action="{{ route('customer.customer_check') }}" method="post">
                @if(Session::get('fail'))
                    <div class="alert alert-danger">
                        {{ Session::get('fail') }}
                    </div>
                @endif

                @csrf
                <div class="form-group">
                    <input type="text" class="form-control login_fields" name="email" placeholder="Email Address" value="{{ old('email') }}">
                    <span class="text-danger">@error('email'){{ $message }} @enderror</span>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control login_fields" name="password" placeholder="Password">
                    <span class="text-danger">@error('password'){{ $message }} @enderror</span>
                </div>
                <button type="submit" class="login_btn">Login</button>
                <br>
                <a class="register_link_btn" href="{{ route('customer.customer_register') }}"> I don't have an Account, Create New</a>
        </div>
    </div>
</body>
</html>