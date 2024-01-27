<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Setting</title>
    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('/img/icon.png') }}">
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/change-password.css') }}">
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
    <section class="register-section">
        <div class="register-box">
            <form method="POST" action="{{ !session('success') ? route('new_password', $user_info->id) : '' }}">
                @csrf
                <div class="register-header {{ session('success') ? 'rh-active1' : '' }}">
                    <div class="register-header-process u-fw-b {{ session('success') ? 'rh-not-active' : 'rh-active' }}">
                        <div class="register-number">
                            <span>1</span>
                            <h5>Update Your Password</h5>
                        </div>
                    </div>
                    <div class="register-header-process u-fw-b">
                        <div class="register-number">
                            <span>2</span>
                            <h5>Password Updated</h5>
                        </div>
                    </div>
                </div>
                <div class="register-content">
                    @if (!session('success'))
                        <div class="register-content-header">
                            <h3 class="u-fw-b u-c-light-gray">Step 1</h3>
                            <h4 class="u-fw-b u-c-dark-gray">Change Your Password</h4>
                            <h5 class="u-fw-b u-c-gray">After your successful registration, you may now change your password.</h5>
                        </div>
                        <br>
                        <div class="register-form">
                            <div class="d-flex">
                                <div class="form-input">
                                    <h5 class="register-label u-fw-b" for="">First Name <span class="c-danger">*</span></h5>
                                    <input class="register-input" type="text" name="first_name" value="{{ $user_info->first_name }}" placeholder="Enter your first name" readonly>
                                </div>
                                <div class="form-input">
                                    <h5 class="register-label u-fw-b" for="">Last Name <span class="c-danger">*</span></h5>
                                    <input class="register-input" type="text" name="last_name"  value="{{ $user_info->last_name }}" placeholder="Enter your last name" readonly>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="form-input">
                                    <h5 class="register-label u-fw-b" for="">Email <span class="c-danger">*</span></h5>
                                    <input class="register-input" type="email" name="email" value="{{ $user_info->email }}" readonly>
                                </div>
                                <div class="form-input">
                                    <h5 class="register-label u-fw-b" for="">Mobile Number <span class="c-danger">*</span></h5>
                                    <input class="register-input" type="text" name="mobile_number"  placeholder="09*********" pattern="[0-9]{4}[0-9]{3}[0-9]{4}" required>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="form-input">
                                    <h5 class="register-label u-fw-b" for="">New Password <span class="c-danger">*</span></h5>
                                    <input class="register-input" type="password" name="password" placeholder="Enter password" required>
                                    @if ($errors->has('password'))
                                        <h6 class="c-danger">{{ $errors->first('password') }}</h6>
                                    @endif                        
                                </div>
                                <div class="form-input">
                                    <h5 class="register-label u-fw-b" for="">Confirm Password <span class="c-danger">*</span></h5>
                                    <input class="register-input" type="password" name="password_confirmation" placeholder="Type your password again" required>
                                    @if ($errors->has('password_confirmation'))
                                        <h6 class="c-danger">{{ $errors->first('password_confirmation') }}</h6>
                                    @endif                        
                                </div>
                            </div>
                            <div class="d-flex" style="margin-top: 5px">
                                <span>
                                    <input class="r_radio_btn" style="position: relative; top: 1px;" type="checkbox" required>
                                    You agree with our <a class="register_links" href="#ex1" rel="modal:open">Terms of Service, and Privacy Policy.</a>
                                </span>                        
                            </div>
                            <!-- Terms of service modal -->
                            <div id="ex1" class="modal">
                                <p>Terms of Service and Privacy Policy.</p>
                                <br>
                                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Autem consectetur qui adipisci ipsam sint officia rem aspernatur vero aperiam corporis. Assumenda ratione quia laudantium cumque? Corporis obcaecati magnam, inventore vitae animi modi quia, omnis voluptas, dicta a architecto magni amet fugiat laboriosam id porro corrupti nihil doloribus est incidunt. Dolorum!</p>
                                <br>
                                <a href="#" rel="modal:close">Close</a>
                            </div>
                            <button class="" id="btn-continue">Submit</button>
                        </div>
                        @else
                            <div class="register-content-header">
                                <h4 class="u-fw-b u-c-dark-gray">Password Updated ✅</h4>
                                <br>
                                <img src="{{ asset('img/document.png') }}" alt="" style="margin: auto; object-fit: contain; width: 100%; max-width: 100px;">
                                <br>
                                <h5 class="u-c-gray u-fw-b" style="width: 100%; max-width: 580px; text-align: center;">
                                    Your account is now under review by our admin team. Please await approval. If you have any questions, feel free to reach out to our support team.
                                </h5>
                                <br>
                            </div>
                    @endif
                </div>
            </form>
        </div>
    </section>

    <script>

        function convertToUppercase(element) {
            element.value = element.value.toUpperCase();
        }

        function preventBack() {
            window.history.forward();
        }
        window.onunload = function() {
            null;
        };
        setTimeout("preventBack()",0);

        // Check if the page was refreshed
        if ("{{ $user_info->biometric_register == 1 }}" && performance.navigation.type === 1) {
            // Redirect to the login page
            window.location.href = '{{ route("login") }}';
        }


        // $('#registration_successful').trigger("click");
        // $("#register_success").modal({
        //     escapeClose: true,
        //     clickClose: true,
        //     showClose: false
        // });
        // $(".string_only").on("input", function() {
        //     $(this).val($(this).val().replace(/[0-9]/g, ''));
        // });
        // if ("{{ session('success') }}"){
        //     setTimeout(function(){
        //         window.location.href = "{{ route('logout') }}"
        //     }, 2000);
        // }
        

    </script>
</body>
</html>