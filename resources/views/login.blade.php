<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('/img/Icon.png') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
</head>
<style>
    body{
        background: url(img/Background-Photo.png);
        background-size: cover;
        background-repeat: no-repeat;
        
    }
    .register{
        background-color: rgba(0, 0, 0, 0.5);
    }
    .register_input_content label,
    .forgot_text{
        color: rgb(255, 230, 230);
        
    }
    .create_account{
        background-color: #013450;
        border: 1px solid #013450;
    }
    .register_links{
        color: #06629a;
    }
    .register_input_content .r_input {
        width: 70%;
    }
    .register_form_content_container{
        /* background: transparent;
        border: 2px solid rgba(255, 255, 255, 0.015);
        backdrop-filter: blur(20px);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        border-radius:10px;
        padding: 30px 30px; */
    }
    

    </style>
<body>
    <!-- Register Content -->
    <section class="register">
        <form action="{{ route('login') }}" method="POST" autocomplete="off">
            @csrf
            <div class="register_content">
                <!-- First Column -->
                <div class="register_logo">
                </div>
                <!-- Second Column -->
                <div class="register_form">
                    <div class="register_form_content">
                        <div class="register_form_content_container">
                            <div class="register_form_content_center">
                                <h2 class="r_form_title">Lurtsema Communications HR Portal</h2>
                                <div class="register_input_content">
                                    <label for="" >Email Address</label>
                                    <input class="r_input" type="text" name="email" required>
                                    {{-- @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif --}}
                                </div>
                                <div class="register_input_content">
                                    <label for="" >Password</label>
                                    <input class="r_input" type="password" name="password" required>
                                    <div class="error_message">
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                        @if(session('rejected'))
                                            <span class="text-danger">
                                                {{ session('rejected') }}
                                            </span>
                                        @endif
                                        @if(session('forApproval'))
                                            <span class="text-danger">
                                                {{ session('forApproval') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="register_input_content">
                                    <span class="forgot_text">Forgot Password? <a class="register_links" href="{{ url('/contact_HR') }}">Contact HR.</a></span>
                                </div>
                                <div class="register_input_content">
                                    <button class="create_account">Login</button>
                                </div>
                                {{-- <div class="log_btn">
                                    <label style="color: #338384;"> <strong>TIME IN-OUT FACE BIOMETRIC</strong></label>
                                    <br>
                                    <a href="Attendance" id="redirect_attendance"><span class="material-symbols-outlined" id="redirect_attendance_icon">familiar_face_and_zone</span></a>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <script>

        
    </script>
</body>
</html>