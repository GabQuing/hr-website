@extends('layouts.side_top_content')

@section('module_name', 'My Leaves')

@section('content')

    <div class="my_leaves_content" style="display: none;">
        <div class="my_leaves_main_content">
            <div class="my_official_business_header" >
                <p class="header_title_h2">My Leaves</p>
            </div>
            <div class="current_leave_credit">
                <div class="current_leave_credit_header">
                    <span>Current Leave Credits</span>
                    <a href="" class="my_official_business_add">
                        <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 16px; font-weight: bold; color: white;">
                            add
                        </span>
                        Add
                    </a>
                </div>
                <div class="current_leave_credit_content">
                    <div class="leave_type">
                        <label style="font-weight: 600;">Leave Type</label>
                        <span style="font-weight: 600;">Credits</span>
                    </div>
                    <div class="leave_type">
                        <label>Sick : Default Sick leave policy</label>
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
    </script>
@endsection
@endsection