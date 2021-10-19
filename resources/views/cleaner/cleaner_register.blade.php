<!DOCTYPE html>
<html lang="en">
<head>
    <title>    
        Cleaner Register 
    </title>
    <meta charset="utf-8">
    <meta name="viewpoint" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <!-- Scripts -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/4fc7b0e350.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/cleaner_reg.css')}}">
</head>
<body class="reg_cleaner_body">
    <div class="register_con_cleaner">
        <h4 class="register_label">
            Create an Account
        </h4>
        <!-- Form for Cleaner Registration Account -->
        <form action="{{ route('cleaner.cleaner_save') }}" method="post" enctype="multipart/form-data">
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
            <div class="user-details">
                <div class="input-div">
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <h5>Full Name</h5>
                        <input type="text" class="input" name="full_name" value="{{ old('full_name') }}">
                        <span class="text-danger">
                            @error('full_name'){{ $message }} @enderror
                        </span>
                    </div>
                </div>
                <div class="input-div">
                    <div class="icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <h5>Age</h5>
                        <input type="number" class="input" name="age" value="{{ old('age') }}">
                        <span class="text-danger">
                            @error('age'){{ $message }} @enderror
                        </span>
                    </div>
                </div>                    
                <div class="input-div">
                    <div class="icon">
                        <i class="fas fa-address-card"></i>
                    </div>
                    <div>
                        <h5>Address</h5>
                        <input type="text" class="input" name="address" value="{{ old('address') }}">
                        <span class="text-danger">
                            @error('address'){{ $message }} @enderror
                        </span>
                    </div>
                </div>
                <div class="input-div">
                    <div class="icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h5>Email</h5>
                        <input type="text" class="input" name="email" value="{{ old('email') }}">
                        <span class="text-danger">
                            @error('email'){{ $message }} @enderror
                        </span>
                    </div>
                </div>
                <div class="input-div">
                    <div class="icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h5>Contact Number</h5>
                        <input type="text" class="input" name="contact_number" value="{{ old('contact_number') }}">
                        <span class="text-danger">
                            @error('contact_number'){{ $message }} @enderror
                        </span>
                    </div>
                </div>
                <div class="input-div">
                    <div class="icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div>
                        <h5>Password</h5>
                        <input type="password" class="input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        <span class="text-danger">
                            @error('password'){{ $message }} @enderror
                        </span>
                    </div>
                </div> 
                <div class="input-div">
                    <div class="icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div>
                        <h5>Confirm Password</h5>
                        <input id="password" type="password" class="input @error('password') is-invalid @enderror" name="password_confirmation" required autocomplete="current-password">
                        <span class="text-danger">
                            @error('password'){{ $message }} @enderror
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="upload_label">
                        Profile Picture
                    </label>
                    <input type="file" name="profile_picture" class="form-control upload_file">
                    <span class="text-danger">
                        @error('profile_picture'){{ $message }} @enderror
                    </span>
                </div>
                <div class="id-cont">
                    <h5>Acceptable Valid ID's:</h5>
                    <p>UMID, Driver'sLicense, Philhealth Card, SSS ID, Passport, School ID, PhilSys ID</p>
                </div> 
                <div class="form-group">
                    <label class="upload_label">
                        Valid ID
                    </label>
                    <input type="file" name="valid_id" class="form-control upload_file">
                    <span class="text-danger">
                        @error('valid_id'){{ $message }} @enderror
                    </span>
                </div>
                <div class="req-cont">
                    <h5>Acceptable Documents:</h5>
                    <p>NSO Birth Certificate, Barangay Clearance, NBI Clearance, Police Clearance, or Matriculation Form (If currently enrolled)</p>
                    <p style="font-size: 14px;">Please indicate the type of document you uploaded down on the description box below.</p>
                </div> 
                <div class="form-group">
                    <label class="upload_label">
                        Requirement
                    </label>
                    <input type="file" name="requirement" class="form-control upload_file">
                    <span class="text-danger">
                        @error('requirement'){{ $message }} @enderror
                    </span>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control reg_fields" name="description" placeholder="Description" value="{{ old('description') }}">
                    <span class="text-danger">
                        @error('description'){{ $message }} @enderror
                    </span>
                </div>
            </div>
            <button type="submit" class="register_cleaner_btn">
                Sign Up
            </button>
        </form>
        <br>
        <a class="login_link_btn" href="{{ route('cleaner.cleaner_login') }}"> 
            I already have an account, Sign In
        </a>
    </div>
    <script type="text/javascript" src="{{ asset('js/register.js')}}"></script>
</body>
</html>