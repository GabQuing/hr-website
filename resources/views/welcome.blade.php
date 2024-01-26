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
    .img_container{
    height: auto;
    width: 100%;
    padding: 20px;
    }
    .img_container img{
        width: 100%
    }
    .welcome_title{
        margin-bottom: 5px;
    }
    .welcome_text,
    .aboard_text{
        font-size: 100px;
        font-weight: 700;
        color: #47A5C4;
        text-align: center;
        letter-spacing: 8px;
        margin: -25px;
    }
    .aboard_text{
        color: #0F1F27;
    }
    .employee_text{
        font-size: 80px;
        color: #0F1F27;
        letter-spacing: 8px;
        font-weight: 650;
    }
    .welcome_description{
        padding: 50px 150px 0px 150px;
        text-align: center;
    }
</style>

<body>
    <section>
        <div class="welcome_content">
            <div class="welcome_content_header">
                <div class="img_container">
                    <img src="{{ asset('img/bossman.png') }}" alt="">
                </div>
            </div>
            <div class="welcome_content_body">
                <div class="welcome_title">
                    <div class="welcome_text">
                        <span>WELCOME</span>
                    </div>
                    <div class="aboard_text">
                        <span>ABOARD</span>
                    </div>
                    <div class="employee_text">
                        <span>OUR EMPLOYEE!</span>
                    </div>
                </div>
                <div class="welcome_description">
                    <div>
                        <p>Thank you for log in for the very first time to our HR attendance System. We will be using this website to keep in check our daily attendances, monitor our schedule profiles and employee information. The system will help the administration stay connected to their employee. Please press "Get Started" to proceed in changing the password.  </p>
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