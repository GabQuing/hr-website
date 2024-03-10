@extends('layouts.side_top_content' , ['title' => 'My Leaves'])

@section('module_name', 'My Leaves')

@section('content')

    <style>
        .modal-box{
            max-width: 75rem !important;
        }
    </style>

    <div class="modal-center" style="display: none">
        <div class="modal-box">
            <div class="modal-content">
                <form wire:submit="editUser">
                    @csrf
                    <div style="overflow-x: auto; width: 100%;">
                        <table class="custom_normal_table">
                            <tbody>
                                <tr>
                                    <td colspan="4">
                                        <h3 class="f-weight-bold"><i class="fa-solid fa-eye"></i> Leave Application Form</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Leave Type:</p>
                                        <select class="u-input" name="" id="" required>
                                            <option value="">Sick</option>
                                            <option value="">Vacation</option>
                                        </select>
                                    </td>        
                                </tr>
                                <tr>                   
                                    <td>
                                        <p>From:</p>
                                        <input class="u-input" name="end_date" type="date" required>
                                    </td>                           
                                    <td>
                                        <p>To:</p>
                                        <input class="u-input" name="end_date" type="date" required>
                                    </td>                                                 
                                </tr>
                                <tr>
                                    <td>
                                        <p>With Pay No of Days</p>
                                        <span>0</span>
                                    </td>
                                    <td>
                                        <p>Without Pay No of Days</p>
                                        <span>0</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <p>Reason</p>
                                        <input class="u-input-border-boottom" name="reason" type="text" placeholder="Enter Reason" required>
                                    </td>                            
                                </tr>
                                <tr>
                                    <td>
                                        <p>Date Breakdown:</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Biometric Logs</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="u-flex-space-between">
                        <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default" id="btn-close" type="button">Close</button>
                        <button class="u-t-white u-fw-b u-btn u-bg-accent u-m-10 u-border-1-default" id="btn-close" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="u-box u-box-shadow-medium" style="overflow: hidden">
        <form method="POST" action="{{route('generateTable')}}">
            @csrf
            <input type="text" name="employeeId" value="{{ auth()->user()->id }}" style="display: none;">
            <div class="u-bg-primary u-p-15" >
                <h4 class="u-t-center u-t-white u-fw-b">My Leaves</h4>
            </div>
            <div class="u-m-10">
                <table class="custom_normal_table">
                    <tbody>
                        <tr>
                            <td>
                                <div style="display: flex; flex-wrap: wrap;">
                                    <h5 class="my_official_businesses_header my_official_businesses_header_active" id="mob-pending">Pending/Resubmit for editing</h5>
                                    <h5 class="my_official_businesses_header" id="mob-approve">Approved</h5>
                                    <h5 class="my_official_businesses_header" id="mob-rejected">Rejected/Canceled</h5>
                                </div>
                            </td>
                            <td>
                                <div class="u-flex-end">
                                    <button class="u-btn u-t-white u-bg-primary" style="display: block;" id="my_official_business_add" type="button">
                                        <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 16px; font-weight: bold;">
                                            add
                                        </span>
                                        Add
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <table class="custom_normal_table u-m-10">
                <tbody>
                    <tr>
                        <td>
                            <h5 class="u-fw-b">Current Leave Credits</h5>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table class="custom_normal_table u-m-10">
                <tbody>
                    <tr>
                        <td>
                            <h5 class="u-fw-b u-t-gray">Leave Type</h5>
                        </td>
                        <td>
                            <h5 class="u-fw-b u-t-gray">Credits</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5 class="u-fw-b u-t-gray">Birthday : Default Birthday leave policy</h5>
                        </td>
                        <td>
                            <h5 class="u-fw-b u-t-gray">0</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5 class="u-fw-b u-t-gray">Vacation : Default Vacation leave policy</h5>
                        </td>
                        <td>
                            <h5 class="u-fw-b u-t-gray">0</h5>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <div class="u-m-10">
                <table class="custom_normal_table">
                    <tbody>
                        @if (session('success'))
                            <tr>
                                <td>
                                    <h5 class="u-fw-b" style="color: green; display:block;">{{ session('success') }}</h5>
                                </td>
                            </tr>
                        @endif
                        <tr class="">
                            <td><h5 class="u-fw-b">My Request - Pending</h5></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mob-pending-table u-m-10" style="overflow-x: auto;">
                <table class="u-responsive-table">
                    <thead>
                        <tr class="f-weight-bold u-t-gray">
                            <td><h5 class="f-weight-bold">Status</h5></td>
                            <td><h5 class="f-weight-bold">Date Filed</h5></td>
                            <td><h5 class="f-weight-bold">Location</h5></td>
                            <td><h5 class="f-weight-bold">Date From</h5></td>
                            <td><h5 class="f-weight-bold">Date To</h5></td>
                            <td><h5 class="f-weight-bold">Time From</h5></td>
                            <td><h5 class="f-weight-bold">Time To</h5></td>
                            <td><h5 class="f-weight-bold">Purpose</h5></td>
                            <td><h5 class="f-weight-bold">Actions</h5></td>
                        </tr>
                    </thead>
                    <tbody>
           
                    </tbody>
                </table>
            </div>
            <div class="mob-approve-table u-m-10" style="overflow-x: auto;">
                <table class="u-responsive-table">
                    <thead>
                        <tr class="f-weight-bold u-t-gray">
                            <td><h5 class="f-weight-bold">Status</h5></td>
                            <td><h5 class="f-weight-bold">Date Filed</h5></td>
                            <td><h5 class="f-weight-bold">Location</h5></td>
                            <td><h5 class="f-weight-bold">Date From</h5></td>
                            <td><h5 class="f-weight-bold">Date To</h5></td>
                            <td><h5 class="f-weight-bold">Time From</h5></td>
                            <td><h5 class="f-weight-bold">Time To</h5></td>
                            <td><h5 class="f-weight-bold">Purpose</h5></td>
                            <td><h5 class="f-weight-bold">Date Approved</h5></td>
                        </tr>
                    </thead>
                    <tbody>
             
                    </tbody>
                </table>
            </div>
            <div class="mob-rejected-table u-m-10" style="overflow-x: auto;">
                <table class="u-responsive-table">
                    <thead>
                        <tr class="f-weight-bold u-t-gray">
                            <td><h5 class="f-weight-bold">Status</h5></td>
                            <td><h5 class="f-weight-bold">Date Filed</h5></td>
                            <td><h5 class="f-weight-bold">Location</h5></td>
                            <td><h5 class="f-weight-bold">Date From</h5></td>
                            <td><h5 class="f-weight-bold">Date To</h5></td>
                            <td><h5 class="f-weight-bold">Time From</h5></td>
                            <td><h5 class="f-weight-bold">Time To</h5></td>
                            <td><h5 class="f-weight-bold">Purpose</h5></td>
                            <td><h5 class="f-weight-bold">Date Rejected/Canceled</h5></td>
                        </tr>
                    </thead>
                    <tbody>
       
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    {{-- <div class="my_leaves_content" style="display: none;">
        <div class="my_leaves_main_content">
            <div class="my_official_business_header" >
                <p class="header_title_h2">My Leaves</p>
            </div>
            <div class="current_leave_credit">
                <div class="current_leave_credit_header">
                    <span>Current Leave Credits</span>
                    <button class="u-btn u-bg-accent u-t-white" id="my_official_business_add" type="button">
                        <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 16px; font-weight: bold; color: white;">
                            add
                        </span>
                        Add
                    </button>
                </div>
                <div class="current_leave_credit_content">
                    <div class="leave_type">
                        <label style="font-weight: 600;">Leave Type</label>
                        <span style="font-weight: 600;">Credits</span>
                    </div>
                    <div class="leave_type">
                        <label>Birthday : Default Birthday leave policy</label>
                        <span>0</span>
                    </div>
                    <div class="leave_type">
                        <label>Vacation : Default Vacation leave policy</label>
                        <span>0</span>
                    </div>
                </div>
                <div class="my_official_businesses" style="margin: 20px 0;">
                    <span class="my_official_businesses_header">Pending/Resubmit for editing</span>
                    <span class="my_official_businesses_header">Approved</span>
                    <span class="my_official_businesses_header">Rejected/Cancelled</span>
                </div>
            </div>
        </div>
    </div> --}}

@section('script_content')
    <script>
        $('.my_leaves_content').fadeIn('slow');

        $('.mob-approve-table').hide();
        $('.mob-rejected-table').hide();

        $('#mob-pending').on('click', function(){
            hideTable($(this), 'Pending');
            $('.mob-pending-table').show();
        })

        $('#mob-approve').on('click', function(){
            hideTable($(this), 'Approved');
            $('.mob-approve-table').show();
        })

        $('#mob-rejected').on('click', function(){
            hideTable($(this), 'Rejected');
            $('.mob-rejected-table').show();
        })

        $('#my_official_business_add').on('click', function(){
            $('.modal-center').show();
        })

        $('#btn-close').on('click', function(){
            $('.modal-center').hide();
        })

        function hideTable(button, title){
            $('.mob-pending-table').hide();
            $('.mob-approve-table').hide();
            $('.mob-rejected-table').hide();
            $('.my_official_businesses_header_active').removeClass('my_official_businesses_header_active');
            $('.request-title').text(title);
            button.addClass('my_official_businesses_header_active');
        }
    </script>
@endsection
@endsection