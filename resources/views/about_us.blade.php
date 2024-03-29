<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="{{ asset('js/sweep.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.gonoogleapis.com/css2?family=Raleway&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nav.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/4fc7b0e350.js" crossorigin="anonymous"></script>
    <link href="{{ asset('css/jobs.css') }}" rel="stylesheet">
</head>
<body>
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
                    <!-- Center Of Navbar -->
                    <ul class="navbar-nav mx-auto">
                        <a id="home" class="nav-link" href="/" role="button">Home</a>
                        <a id="services" class="nav-link" href="services" role="button">Services</a>
                        <a id="jobs" class="nav-link" href="jobs" role="button">Jobs</a>
                        <a id="about_us" class="nav-link active" href="about_us" role="button">About Us</a>
                        <a id="contact_us" class="nav-link" href="contact_us" role="button">Contact Us</a>
                    </ul>

                    <ul class="navbar-nav d-flex">
                        <!-- Authentication Links -->
                        @if (Route::has('customer.customer_login'))
                        <a class="btn login_btn" href="{{ route('customer.customer_login') }}">{{ __('Login') }}</a>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <div class="banner-container">
        <div class="banner">
            <div class="text">
                <h1>
                    About Us
                </h1>
                <p>
                    Relax! Have a worry-free lifestyle
                </p>
            </div>
            <div class="image">
                <img src="/images/jobs/jobs-header.png" class="img-fluid">
            </div>
        </div>
    </div>

    <div class="more-info">
        <div class="row2">
            <div class="services">
                <h2 class="title2">
                    For a cleaner, fresher home. Always!
                </h2>
                <p class="for-you-text">
                    Sweep is a local start-up enterprise based in Naga City. Founded by three students with the goal in mind to make sure everyone would live and work in a clean, safe, and enjoyable environment. <br>
                </p>
                <p class="for-you-text">
                    Specializing in various cleaning and assisting services, that would help lessen people’s burden by providing an extra set of hands enabling them to carry on with their lives with ease.
                </p>
            </div>
            <div class="col-6">
                <img src="images/jobs/headhome.png" class="img-fluid">
            </div>
        </div>
    </div>

    <div class="download">
        <div class="row3">
            <div class="dcont">
                <h2 class="dtitle">
                    Download our App
                </h2>
                <p class="d-text">
                    Download the app and get your homes clean with just a click of a button. Now available on the Google Play Store.
                </p>
                <a class="btn btn-primary down_btn" href="{{ 'about_us' }}">{{ __('Download Now') }}</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="sweep-title">
            SWEEP © 2021. All Rights Reserved.
        </div>
    </div>
</body>
