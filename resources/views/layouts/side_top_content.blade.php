<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'HR Portal' }}</title>
    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Google Icon -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=block" />
    <!-- ChartJs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('/img/Icon.png') }}">
    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- DataTable --}}
    <link rel="stylesheet" text="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.7/css/responsive.dataTables.min.css">
    {{-- Jquery Modal --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    {{-- Sweet Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
    {{-- Utilities --}}
    <link rel="stylesheet" href="{{ asset('css/utilities.css') }}">

</head>
@yield('css')

<body>
    <!-- Side Navbar -->
    @auth
    <section>
        <div class="toggle_middle">
            <span class="material-symbols-outlined menu_middle" style="color: white">menu</span>
        </div>
        <!-- Top Navbar -->
        <div class="main_content">
            <div style="padding: 0 20px;">
                <div class="top_navbar">
                    @if ( Request::segment(1) == 'dashboard1')
                        <div>
                            <p class="header_title_h1" id="typing_text"></p>
                            <p class="header_title_child">@yield('module_name')</p>
                        </div>
                        {{-- <div class="message_div">
                            <header>
                                <h2>Announcement</h2>
                            </header>
                            <ul class="message_box">
                                <li class="chat incoming"> 
                                    <span class="material-symbols-outlined">smart_toy</span>
                                    <p>Hello there </p>
                                </li>
                                <li class="chat outgoing"> 
                                    <p> hi there </p>
                                </li>
                            </ul>
                            <div class="message_input">
                                <textarea placeholder="enter a message" name="" id=""></textarea>
                                <span class="material-symbols-outlined " style="color: black">send</span>
                            </div>
                        </div> --}}
                    @else
                        <p class="header_title_h1">Lurtsema Communications Human Resource Portal</p>
                        <p class="header_title_child">@yield('module_name')</p>
                    @endif
                </div>
                <br>
                    @yield('content')
            </div>
            <div style="flex: 1; margin-bottom: 25px;"></div>
            <div class="footer">
                {{-- <h6>&copy; 2024 BPG Bois. All rights reserved.</h6> --}}
            </div>
        </div>

        <!-- End of Top Navbar -->
        <div class="sidenav_parent">
            <div class="sidenav">
                <span class="material-symbols-outlined toggle" style="color: white">menu</span>
                <a href="{{ route('dashboard') }}">
                    <div class="sidenav_logo">
                        <img src="{{ asset('/img/logo_white.png') }}" alt="" loading="lazy">
                    </div>
                </a>
                <div class="sidenav_user_info">
                    <form method="POST" id="photoForm" enctype="multipart/form-data">   
                        @csrf
                        <div class="user_picture">
                            <label for="user_photo" id="photo_label">
                            @if (auth()->user()->img == null)
                                    <img src="{{ asset('img/user.png') }}" alt="" id="img_user_photo" loading="lazy">
                                @else
                                    <img src="{{ asset('profile_picture/img/'.auth()->user()->img ) }}" alt="" id="img_user_photo" loading="lazy">
                            @endif
                            </label>
                            <input type="file" id="user_photo" name="user_photo" style="display:none" accept="image/jpeg,image">
                        </div>
                    </form>
                    <div id="photo_error" style="display: none">
                        <p style="color: rgb(232, 112, 112); font-size: 12px">Accepts jpeg/jpg only</p>
                    </div>
                    <div class="user_info">
                        <p style="font-size: 16px; margin-bottom: 5px; color: #ffffff;">{{ auth()->user()->name }}</p>
                        <p style="font-size: 12px;  color: #d0dbdb;">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <div class="sidenav_links">
                    <ul>
                        @if ( Request::segment(1)  == 'dashboard1')
                            <li class="active" id="current_link">
                            @else
                            <li class="active">
                        @endif
                                <img src="{{ asset('img/icon-img/home.png') }}" alt="">
                                {{-- <span class="material-symbols-outlined sidenav_icon">home</span> --}}
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                        @role('employee')
                            @if ( Request::segment(1)  == 'my_attendance')
                                <li class="active" id="current_link">
                                @else
                                <li class="active">
                            @endif                        
                                    {{-- <span class="material-symbols-outlined">calendar_month</span> --}}
                                <img src="{{ asset('img/icon-img/calendar.png') }}" alt="">
                                    <a href="{{ route('attendance') }}">Attendance</a>
                                </li>
                            @if ( Request::segment(1)  == 'my_activity_logs')
                                <li class="active" id="current_link">
                                @else
                                <li class="active">
                            @endif                        
                            <img src="{{ asset('img/icon-img/list.png') }}" alt="">
                            <a href="{{ route('activitylogs') }}">Activity Logs</a>
                                </li>
                            @if ( Request::segment(1)  == 'my_official_business')
                                <li class="active" id="current_link">
                                @else
                                <li class="active">
                            @endif                        
                                    <img src="{{ asset('img/icon-img/edit_calendar.png') }}" alt="">
                                    <a href="{{ route('officialbusiness') }}">My Official Business</a>
                                </li>
                            @if ( Request::segment(1)  == 'my_overtimes')
                                <li class="active" id="current_link">
                                @else
                                <li class="active">
                            @endif
                                    {{-- <span class="material-symbols-outlined">edit_square</span> --}}
                                    <img src="{{ asset('img/icon-img/note_edit.png') }}" alt="">
                                    <a href="{{ route('overtimes') }}">My Overtimes</a>
                                </li>
                            {{-- @if ( Request::segment(1)  == 'my_undertimes')
                                <li class="active" id="current_link">
                                @else
                                <li class="active">
                            @endif
                                    <img src="{{ asset('img/icon-img/square_edit.png') }}" alt="">
                                    <a href="{{ route('undertimes') }}">My Undertimes</a>
                                </li> --}}
                            @if ( Request::segment(1)  == 'my_leaves')
                                <li class="active" id="current_link">
                                @else
                                <li class="active">
                            @endif
                                    {{-- <span class="material-symbols-outlined">edit_location_alt</span> --}}
                                    <img src="{{ asset('img/icon-img/leaves.png') }}" alt="">
                                    <a href="{{ route('leaves') }}">My Leaves</a>
                                </li>
                            @if ( Request::segment(1)  == 'payroll')
                                <li class="active" id="current_link">
                                @else
                                <li class="active">
                            @endif
                                    {{-- <span class="material-symbols-outlined">payments</span> --}}
                                    <img src="{{ asset('img/icon-img/cash.png') }}" alt="">
                                    <a href="{{ route('payroll') }}">My Payroll</a>
                                </li>
                            @if ( Request::segment(1)  == 'my_benefits')
                                <li class="active" id="current_link">
                                @else
                                <li class="active">
                            @endif
                                    {{-- <span class="material-symbols-outlined">payments</span> --}}
                                    <img src="{{ asset('img/icon-img/benefit.png') }}" alt="">
                                    <a href="{{ route('benefits') }}">My Benefits</a>
                                </li>
                        @endrole
                        @role('admin||hr')
                            @if ( Request::segment(1)  == 'user_accounts')
                                <li class="active" id="current_link">
                                @else
                                <li class="active">
                            @endif
                            {{-- <span class="material-symbols-outlined">rule</span> --}}
                            <img src="{{ asset('img/icon-img/list.png') }}" alt="">
                            <a href="{{ route('user_accounts') }}">Employee Accounts</a>
                                </li>  
                            @if ( Request::segment(1)  == 'approve_accounts')
                                <li class="active" id="current_link">
                                @else
                                <li class="active">
                            @endif
                                    {{-- <span class="material-symbols-outlined">person_add</span> --}}
                                    <img src="{{ asset('img/icon-img/user_setting.png') }}" alt="">
                                    <a href="{{ route('approve_accounts') }}">Employee Registration</a>
                                </li>  
                            @if ( Request::segment(1)  == 'employee_informations')
                                <li class="active" id="current_link">
                                @else
                                <li class="active">
                            @endif
                                    {{-- <span class="material-symbols-outlined">support_agent</span> --}}
                                    <img src="{{ asset('img/icon-img/employee_list.png') }}" alt="">
                                    <a href="{{ route('employee_informations') }}">Employee Information</a>
                                </li>
                            @if ( Request::segment(1)  == 'log_user_access')
                                <li class="active" id="current_link">
                                @else
                                <li class="active">
                            @endif
                                    {{-- <span class="material-symbols-outlined">list_alt</span> --}}
                                    <img src="{{ asset('img/icon-img/document.png') }}" alt="">
                                    <a href="{{ route('log_user_access') }}">Employee Activity Logs</a>
                                </li>
                            @if ( Request::segment(1)  == 'employee_attendance')
                                <li class="active" id="current_link">
                                @else
                                <li class="active">
                            @endif                        
                                    {{-- <span class="material-symbols-outlined">calendar_month</span> --}}
                                <img src="{{ asset('img/icon-img/calendar.png') }}" alt="">
                                    <a href="{{ route('employee_attendance') }}">Employee Attendances</a>
                                </li>
                            @if ( Request::segment(1)  == 'employee_request')
                                <li class="active" id="current_link">
                                @else
                                <li class="active">
                            @endif
                                    {{-- <span class="material-symbols-outlined">list_alt</span> --}}
                                    <img src="{{ asset('img/icon-img/document.png') }}" alt="">
                                    <a href="{{ route('employee_request') }}">Employee Requests</a>
                                </li> 
                            @if ( Request::segment(1)  == 'employee_leave')
                                <li class="active" id="current_link">
                                @else
                                <li class="active">
                            @endif
                                    <img src="{{ asset('img/icon-img/leaves.png') }}" alt="">
                                    <a href="{{ route('employee_leaves') }}">Employee Leaves</a>
                                </li> 
                            @if ( Request::segment(1)  == 'employee_payroll')
                                <li class="active" id="current_link">
                                @else
                                <li class="active">
                            @endif
                                    {{-- <span class="material-symbols-outlined">payments</span> --}}
                                    <img src="{{ asset('img/icon-img/cash.png') }}" alt="">
                                    <a href="{{ route('employee_payroll') }}">Employee Payroll</a>
                                </li>
                            @if ( Request::segment(1)  == 'employee_benefit')
                                <li class="active" id="current_link">
                                @else
                                <li class="active">
                            @endif
                                    {{-- <span class="material-symbols-outlined">payments</span> --}}
                                    <img src="{{ asset('img/icon-img/benefit.png') }}" alt="">
                                    <a href="{{ route('employee_benefit') }}">Employee Benefit</a>
                                </li>
                            @if ( Request::segment(1)  == 'schedule_profile')
                                <li class="active" id="current_link">
                                @else
                                <li class="active">
                            @endif
                                    {{-- <span class="material-symbols-outlined">pending_actions</span>     --}}
                                    <img src="{{ asset('img/icon-img/note_schedule.png') }}" alt="">
                                    <a href="{{ route('schedule_profile') }}">Schedule Profiles</a>
                                </li> 
                        @endrole
                            @if ( Request::segment(1)  == 'policy_procedure')
                                <li class="active" id="current_link">
                            @else
                                <li class="active">
                            @endif
                                <img src="{{ asset('img/icon-img/policy.png') }}" alt="">
                                {{-- <span class="material-symbols-outlined sidenav_icon">home</span> --}}
                                <a href="{{ route('policy_procedure') }}">Policies & Procedures</a>
                                </li>
                    </ul>
                </div>
                <div class="user_info_logout">
                    <a class="user_info_link" href="{{ route('profile') }}">Profile</a>
                    <p style="font-size: 14px; margin-top: 20px;"><a href="{{ route('logout') }}" id="logout" style="color: #ffffff; text-decoration: none;">Logout</a></p>
                </div>
            </div>
        </div>
    </section>
    <script>

        $(document).ready(function(){
            
            $('.active').on('click', function() {
                $(this).find('a')[0].click();
            });
            
            $('.toggle').click(function(){
                $('.sidenav_parent').fadeToggle(function(){
                    $('.main_content').css('margin','auto');
                    $('.toggle_middle').css('visibility', 'visible');
                });
            });

            $('.toggle_middle').click(function(){  
                $('.toggle_middle').css('visibility', 'hidden');
                $('.sidenav_parent').fadeToggle(function(){
                    let viewport = $(window).width();
                    if(viewport >600){
                        $('.main_content').css('margin-left','290px');
                    }else{
                        $('.main_content').css('margin-left','auto');
                    }
                });
            });        
            $(window).resize(function(){
                var viewport = $(window).width();
                if(viewport < 650){
                    $('.main_content').css('margin-left','auto');
                }else{
                    let sidenav = $('.sidenav').is(':visible');
                    if(sidenav){
                        $('.main_content').css('margin-left','290px');
                    }
                }
            })

            // Typing animation
            $(function() {
                var text = "Welcome To Lurtsema Communications Human Resource Portal";
                var index = 0;
                var typingTimer = setInterval(function() {
                $('#typing_text').append(text[index++]);
                if (index === text.length) {
                    clearInterval(typingTimer);
                }
                }, 35)
            });

            $('#photoForm').on('change', function(event){
                event.preventDefault()

                var formData = new FormData();
                formData.append('photo', $('#user_photo')[0].files[0]);
                formData.append('_token', '{{ csrf_token() }}');

                if ($('#user_photo')[0].files[0].type != "image/jpeg") {
                    $('#photo_error').show();
                } else {
                    $('#photo_error').hide();
                }

                $.ajax({
                    url: '{{ route('upload_img') }}',
                    type: 'POST',
                    data: formData, 
                    dataType: 'json',
                    contentType: false, // required for processing file data
                    processData: false, // required for processing file data
                    success: function(response){

                        // Add a unique parameter to the image source URL
                        var timestamp = new Date().getTime();
                        $('#img_user_photo').attr('src', '{{ asset('profile_picture/img/') }}' + '/' + response.photo_name + '?' + timestamp);

                        let timerInterval
                        Swal.fire({
                        html: 'Your profile picture has been updated successfully',
                        timer: 1200,
                        timerProgressBar: false,
                        didOpen: () => {
                            Swal.showLoading()
                            const b = Swal.getHtmlContainer().querySelector('b')
                            timerInterval = setInterval(() => {
                            b.textContent = Swal.getTimerLeft()
                            }, 100)
                        },
                        willClose: () => {
                            clearInterval(timerInterval)
                        }
                        }).then((result) => {
                        /* Read more about handling dismissals below */
                        if (result.dismiss === Swal.DismissReason.timer) {
                            console.log('I was closed by the timer')
                        }
                        })

                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            });

            if ("{{ session('page_denied') }}".length){
        
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    customClass: {
                        toast: 'bottom-0 end-0',
                    },
                });

                Toast.fire({
                    icon: 'warning',
                    title: "You don't have access to this page.",
                })
            }



                })

    </script>

    @yield('script_content')
@endauth
</body>
</html>