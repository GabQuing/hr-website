<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up Page</title>
    <!-- Css Link -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Jquery Link -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- Jquery Modal -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('/img/digits_logo.png') }}">

</head>
<body>
    <!-- Register Content -->
    <section class="register">
        <form action="{{ route('register') }}" method="POST">
            {{ csrf_field() }}
            <div class="register_content">
                <!-- First Column -->
                <div class="register_logo">
                    <img src="{{ asset('/img/register_logo.jpg') }}" alt="">
                </div>
                <!-- Second Column -->
                <div class="register_form">
                    <div class="register_form_content">
                        <div class="register_form_content_center">
                            <h2 class="r_form_title">Sign up to HR Attendance Monitoring System</h2>
                            <div class="register_input_content">
                                <div class="d-flex">
                                    <div class="d-iblock">
                                        <label for="" >First Name <em></em></label>
                                        <input class="r_input string_only" type="text" name="first_name" placeholder="Enter your first name" oninput="convertToUppercase(this)" required >
                                    </div>
                                    <div class="d-iblock">
                                        <label for="" >Last Name</label>
                                        <input class="r_input string_only" type="text" name="last_name" placeholder="Enter your last name" oninput="convertToUppercase(this)" required>
                                    </div>
                                </div>
                            </div>
                            <div class="register_input_content">
                                <div class="d-flex">
                                    <div class="d-iblock">
                                        <label for="" >Mobile Number &nbsp; <em id="req_op">Required*</em></label>
                                        <input class="r_input" type="text" name="mobile_number" placeholder="09*********" pattern="[0-9]{4}[0-9]{3}[0-9]{4}" required>
                                    </div>  
                                    <div class="d-iblock">
                                        <label for="email" >Email  &nbsp; <em id="req_op">Optional*</em></label>
                                        <input class="r_input" type="text" name="email" placeholder="Enter your dtc email address">
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="d-iblock">
                                        @if ($errors->has('mobile_number'))
                                            <span class="text-danger">{{ $errors->first('mobile_number') }}</span>
                                        @endif 
                                    </div>
                                    {{-- <div class="d-iblock">
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div> --}}
                                </div>
                            </div>
                            <div class="register_input_content">
                                <label for="password" >Password</label>
                                <input class="r_input" type="password" name="password" placeholder="Enter password" required>
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="register_input_content">
                                <label for="password-confirm">Re-type Password</label>
                                <input class="r_input" type="password" name="password_confirmation" placeholder="Type your password again" required>
                            </div>
                            <div class="register_input_content">
                                <div class="d-flex">
                                    <input class="r_radio_btn" type="checkbox" required>
                                    <span >You agree with our <a class="register_links" href="#ex1" rel="modal:open">Terms of Service, and Privacy Policy.</a></span>                        
                                </div>
                                <!-- Terms of service modal -->
                                <div id="ex1" class="modal">
                                    <p>Terms of Service and Privacy Policy.</p>
                                    <br>
                                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Autem consectetur qui adipisci ipsam sint officia rem aspernatur vero aperiam corporis. Assumenda ratione quia laudantium cumque? Corporis obcaecati magnam, inventore vitae animi modi quia, omnis voluptas, dicta a architecto magni amet fugiat laboriosam id porro corrupti nihil doloribus est incidunt. Dolorum!</p>
                                    <br>
                                    <a href="#" rel="modal:close">Close</a>
                                </div>
                            </div>
                            <div class="register_input_content">
                                <span>Already a member? <a class="register_links" href="{{ url('/login') }}">Sign in.</a></span>
                            </div>
                            <div class="register_input_content">
                                <button type="submit" class="create_account">Create Account</button>
                                @if (session('success'))
                                    <a id="registration_successful" href="#register_success" rel="modal:open" style="visibility: hidden">
                                        success
                                    </a> 
                                    <div id="register_success" class="modal" style="text-align: center; color: green">
                                        <br><br>
                                        <p>Registration Success!. You can now Register your Face Biometric.</p>
                                        <br>
                                        <p><a style="text-decoration: none !important, color: aquamarine !important" href="{{ route('registerface', session('success')) }}">Register Here</a></p>
                                        <br><br>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <script>

        function convertToUppercase(element) {
            element.value = element.value.toUpperCase();
        }

        $('#registration_successful').trigger("click");
        $("#register_success").modal({
            escapeClose: true,
            clickClose: true,
            showClose: false
        });
        $(".string_only").on("input", function() {
            $(this).val($(this).val().replace(/[0-9]/g, ''));
        });
    </script>
</body>
</html>