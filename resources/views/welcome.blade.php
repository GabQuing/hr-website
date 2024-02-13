<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HR Attendance System</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('/img/Icon.png') }}">

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
    .img_container {
    height: auto;
    width: 100%;
    padding: 20px 20px, 0px 20px;
    margin-top: auto; /* Move to the bottom */
}
    .img_container img{
        width: 100%
    }
    .img_container_logo{
        max-width: 70%;
        width: 400px;
        padding: 20px 20px 0px 20px;
        margin-top: 20px;
    }
    .img_container_logo_black{
        max-width: 100%;
        width: 400px;
        padding: 20px 20px 0px 20px;
        margin-top: 20px;
    }
    .img_container_logo img {
    width: 100%; /* set the desired width */
    }
    .img_container_logo_black img {
    width: 100%; /* set the desired width */
    }
    .welcome_text,
    .aboard_text{
        font-size: 70px;
        font-weight: 700;
        color: #47A5C4;
        text-align: center;
        letter-spacing: 5px;
        margin: -25px;
    }
    .aboard_text{
        color: #0F1F27;
    }
    .employee_text{
        font-size: 60px;
        color: #0F1F27;
        font-weight: 600;
        text-align: center;
    }
    .welcome_description{
        padding: 20px 50px 0px 50px;
        text-align: center;
    }
    @media only screen and (max-width: 1273px) {
        .welcome_text,
        .aboard_text{
            font-size: 60px;
            margin: -15px;
        }
        .employee_text{
            font-size: 50px;
        }
    }
    @media only screen and (max-width: 1160px) {
        .welcome_content{
            flex-direction: column;
        }
        .welcome_content_header{
            flex-direction: row;
        }
        .img_container{
            width: 50%
        }
        .welcome_content_body{
            width: 100%;
            padding: 100px;

        }
    }
    @media only screen and (max-width: 653px) {
        .welcome_content_body{
            padding: 20px 0px 0px 0px;
        }
        .welcome_text,
        .aboard_text{
            font-size: 50px;
            margin: -15px;
        }
        .employee_text{
            font-size: 40px;
        }
        .img_container_logo,
        .img_container_logo_black{
            margin-top: 0px;
        }
    }

    @media only screen and (max-width: 394px) {
        .welcome_content_body{
            padding: 20px 0px 0px 0px;
        }
        .welcome_description{
        padding: 20px 20px 0px 20px;
    }
        .welcome_text,
        .aboard_text{
            font-size: 40px;
            margin: -5px;
        }
        .employee_text{
            font-size: 30px;
        }
        .img_container_logo,
        .img_container_logo_black{
            margin-top: 0px;
        }
    }
</style>

<body>
    <section>
        <div class="welcome_content">
            <div class="welcome_content_header">
                <div class="img_container_logo">
                    <img src="{{ asset('img/logo_white.png') }}" alt="">
                </div>
                <div class="img_container">
                    <img src="{{ asset('img/bossman.png') }}" alt="">
                </div>
            </div>
            <div class="welcome_content_body">
                {{-- <div class="img_container_logo_black">
                    <img src="{{ asset('img/logo_black.png') }}" alt="">
                </div>
                <br> --}}
                <div class="welcome_title">
                    <div class="welcome_text">
                        <span>WELCOME</span>
                    </div>
                    <div class="aboard_text">
                        <span>ABOARD!</span>
                    </div>
                    {{-- <div class="employee_text">
                        <span>TO OUR EMPLOYEE!</span>
                    </div> --}}
                </div>
                <br>
                <div class="welcome_description">
                    <div>
                        <p>Thank you for logging in for the very first time to our HR Attendance System. We will be using this website to keep track of our daily attendance, monitor schedule profiles, and manage employee information. The system will help the administration stay connected with their employees. Please press 'Get Started' to proceed with changing your password.</p>
                    </div>
                </div>
                <div class="home_btns">
                    @if (Route::has('login'))
                        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                            @auth
                                <br>
                                <a href="{{ route('newProfile', auth()->user()->id) }}" class="h_btn">Get Started</a>
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