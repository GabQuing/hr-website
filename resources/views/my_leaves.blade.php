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

    <div class="my_leaves_content" style="display: none;">
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
    </div>

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