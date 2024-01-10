@extends('layouts.side_top_content')

@section('module_name', 'My Overtimes')

@section('content')

<div class="my_official_business_content" style="display: none;">
    <div class="my_official_business_main_content">
        <div class="my_official_business_header" >
            <p class="header_title_h2">My Overtimes</p>
        </div>
        <div class="my_official_businesses">
            <span class="my_official_businesses_header">Pending/Resubmit for editing</span>
            <span class="my_official_businesses_header">Approved</span>
            <span class="my_official_businesses_header">Rejected/Cancelled</span>
            <a href="" style="display: block; margin-top: 12px;" class="my_official_business_add">
                <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 16px; font-weight: bold;">
                    add
                </span>
                Add OT
            </a>
        </div>
        <div class="my_official_business_request_pending">
            <p>Request Pending</p>
        </div>
        <div class="my_official_business_request_pending_content" style="visibility: hidden;">
            <div class="request_pending">
                <label for="">Date Filed</label>
                <p></p>
            </div>
            <div class="request_pending">
                <label for="">Date Filed</label>
                <p></p>
            </div>
            <div class="request_pending">
                <label for="">Location</label>
                <p></p>
            </div>
            <div class="request_pending">
                <label for="">Date From</label>
                <p></p>
            </div>
            <div class="request_pending">
                <label for="">Date To</label>
                <p></p>
            </div>
            <div class="request_pending">
                <label for="">Time From</label>
                <p></p>
            </div>
            <div class="request_pending">
                <label for="">Time To</label>
                <p></p>
            </div>
            <div class="request_pending">
                <label for="">Purpose</label>
                <p></p>
            </div>
            <div class="request_pending">
                <label for="">Actions</label>
                <p>
                    <a href="" class="request_pending_btn" id="request_pending_btn_update">Update</a><a href="" class="request_pending_btn" id="request_pending_btn_cancel">Cancel</a>
                </p>
                
            </div>
        </div>
    </div>
</div>
<div style="clear: both;"></div>

    @section('script_content')
        <script>
            $('.my_official_business_content').fadeIn('slow');
        </script>
    @endsection
@endsection