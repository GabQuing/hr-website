<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DTC Attendance System</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('/img/digits_logo.png') }}">

</head>
<style>
    
    *{
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    .section{
        height: 100vh;
    }

    
</style>

<body>
    <section>
        <div class="welcome_content">
            <div class="welcome_content_header">
                <img src="{{ asset('img/Sign_up_picture.jpg') }}" alt="">
            </div>
            <div class="welcome_content_body">
                <div class="welcome_content_body_header">
                    <p>Welcome To DTC Attendance Monitoring System</p>
                </div>
                <div class="welcome_content_body_description">
                    <p> The Attendance Monitoring System uses cutting-edge face recognition attendance system, 
                        designed to streamline your attendance tracking and management process. 
                        Our system utilizes advanced facial recognition technology to accurately 
                        capture employee attendance in real-time, eliminating the need for manual 
                        timekeeping and reducing errors.
                    </p>
                </div>
                <div class = "welcome_content_instruction">
                    <div class = "welcome_column1">
                        <img src="{{ asset('img/changePassword.jpg') }}" alt="">
                        <div class="content_description">
                            <div class="content_description_header">
                                <strong>Step One: Password Settings</strong>
                            </div>
                            <div class="contenct_description_body">
                                You will need to change the temporary password of your account, the new password must be at least more than 8 characters.
                            </div>
                        </div>
                    </div>
                    <div class = "welcome_column2">
                        <img src="{{ asset('img/registerFace.jpg') }}" alt="">
                        <div class="content_description">
                            <div class="content_description_header">
                                <strong>Step Two: Face Biometric</strong>
                            </div>
                            <div class="contenct_description_body">
                                You will need to register your facial structure so the system can identify your face biometric and register your time logs.
                            </div>
                        </div>
                    </div>
                    <div class = "welcome_column3">
                        <img src="{{ asset('img/waitApproval.jpg') }}" alt="">
                        <div class="content_description">
                            <div class="content_description_header">
                            <strong>Step Three: Admin's Approval</strong>
                            </div>
                            <div class="contenct_description_body">
                                All requests from the DTC Attendance System are being monitored by the Admins. All information will be checked before using the Face Recognition Time log System.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="home_btns">
                    @if (Route::has('login'))
                        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                            @auth
                                <br>
                                <a href="{{ route('newProfile', auth()->user()->id) }}" class="h_btn">Continue</a>
                            @else
                                <br>
                                <a href="{{ route('login') }}" class="h_btn">Login Here</a>
                                {{-- <a href="{{ route('register') }}" class="h_btn">Register Here</a> --}}
                            @endauth
                        </div>
                    @endif
                </div>
                <div class="welcome_content_body_cardbox">
                </div>
            </div>
        </div>
    </section>
</body>
</html>