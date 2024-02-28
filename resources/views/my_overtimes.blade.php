@extends('layouts.side_top_content', ['title' => 'My Overtimes'])

@section('module_name', 'My Overtimes')

@section('content')

<style>
    .modal-box{
        max-width: 75rem !important;
    }
</style>

<div class="modal-center" style="display: none;">
    <div class="modal-box">
        <div class="modal-content">
            <form wire:submit="editUser">
                @csrf
                <div style="overflow-x: auto; width: 100%;">
                    <table class="custom_normal_table">
                        <tbody>
                            <tr>
                                <td colspan="4">
                                    <h3 class="f-weight-bold"><i class="fa-solid fa-eye"></i> Overtime Application Form</h3>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Shift:</p>
                                    <span>REST DAY</span>
                                </td>
                                <td>
                                    <p>Biometric Logs</p>
                                    <span>No Logs</span>
                                </td>                            
                                <td>
                                    <p>OT:</p>
                                    <span>NO OT</span>
                                </td>                            
                                <td>
                                    <p>OT Minutes:</p>
                                    <span>0</span>
                                </td>                            
                            </tr>
                            <tr>
                                <td>
                                    <p>Day:</p>
                                    <input class="u-input-border-boottom" name="reason" type="text" placeholder="Day..." readonly>
                                </td>
                                <td>
                                    <p>Shift Date:</p>
                                    <input class="u-input-border-boottom" type="date" readonly>
                                </td>
                                <td>
                                    <p>Shift From:</p>
                                    <input class="u-input-border-boottom" type="time" readonly>
                                </td>
                                <td>
                                    <p>To:</p>
                                    <input class="u-input-border-boottom" type="time" readonly>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <h3 class="f-weight-bold"><i class="fa-solid fa-eye"></i> Overtime Details</h3>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <p>OT Classification:</p>
                                    <select class="u-input" name="ot_classification" required>
                                        <option value="">Normal OT</option>
                                        <option value="">Early OT</option>
                                    </select>
                                </td> 
                                <td>
                                    <p>Start:</p>
                                    <input class="u-input" name="start_date" type="date" placeholder="Enter Location" required>
                                </td>                           
                                <td>
                                    <p>End:</p>
                                    <input class="u-input" name="end_date" type="date" placeholder="Enter Location" required>
                                </td>                           
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <p>Indicate Ticket Number (If Applicable) and Reason</p>
                                    <input class="u-input-border-boottom" name="reason" type="text" placeholder="Enter Reason" required>
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
<div class="my_official_business_content" style="display: none">
    <div class="my_official_business_main_content u-bg-white">
        <div class="my_official_business_header">
            <p class="header_title_h2">My Official Businesses</p>
        </div>
        <div class="my_official_businesses u-m-15">
            <div style="display: flex; flex-wrap: wrap;">
                <h5 class="my_official_businesses_header my_official_businesses_header_active" id="mob-pending">Pending/Resubmit for editing</h5>
                <h5 class="my_official_businesses_header" id="mob-approve">Approved</h5>
                <h5 class="my_official_businesses_header" id="mob-rejected">Rejected/Cancelled</h5>
            </div>
            <button  class="u-btn u-bg-accent u-t-white" style="display: block; margin-top: 12px;" id="my_official_business_add" type="button">
                <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 16px; font-weight: bold;">
                    add
                </span>
                Add OT
            </button>
        </div>
        <div class="my_official_business_request_pending u-m-15">
            <h5 style="font-weight: bold;">My Request - <span class="request-title">Pending</span></h5>
        </div>
        <div class="mob-pending-table u-m-15" style="overflow-x: auto; border-radifus: 0.5rem;">
            <table class="u-responsive-table">
                <tr class="f-weight-bold">
                    <td><h6 class="f-weight-bold">Status</h6></td>
                    <td><h6 class="f-weight-bold">Date Filed</h6></td>
                    <td><h6 class="f-weight-bold">Location</h6></td>
                    <td><h6 class="f-weight-bold">Date From</h6></td>
                    <td><h6 class="f-weight-bold">Date To</h6></td>
                    <td><h6 class="f-weight-bold">Time From</h6></td>
                    <td><h6 class="f-weight-bold">Time To</h6></td>
                    <td><h6 class="f-weight-bold">Purpose</h6></td>
                    <td><h6 class="f-weight-bold">Actions</h6></td>
                </tr>
                <tr>
                    <td><h6>Status</h6></td>
                    <td><h6>Date Filed</h6></td>
                    <td><h6>Location</h6></td>
                    <td><h6>Date From</h6></td>
                    <td><h6>Date To</h6></td>
                    <td><h6>Time From</h6></td>
                    <td><h6>Time To</h6></td>
                    <td><h6>Purpose</h6></td>
                    <td>
                        <div class="d-flex;">
                            <button type="button" class="u-action-btn u-bg-danger">
                                <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 20px; font-weight: bold;">
                                    delete
                                </span>
                            </button>
                            <button type="button" class="u-action-btn u-bg-primary">
                                <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 20px; font-weight: bold;">
                                    edit
                                </span>
                            </button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="mob-approve-table u-m-15" style="overflow-x: auto; border-radius: 0.5rem;">
            <table class="u-responsive-table">
                <tr class="f-weight-bold">
                    <td><h6 class="f-weight-bold">Status</h6></td>
                    <td><h6 class="f-weight-bold">Date Filed</h6></td>
                    <td><h6 class="f-weight-bold">Location</h6></td>
                    <td><h6 class="f-weight-bold">Date From</h6></td>
                    <td><h6 class="f-weight-bold">Date To</h6></td>
                    <td><h6 class="f-weight-bold">Time From</h6></td>
                    <td><h6 class="f-weight-bold">Time To</h6></td>
                    <td><h6 class="f-weight-bold">Purpose</h6></td>
                    <td><h6 class="f-weight-bold">Date Approved</h6></td>
                </tr>
                <tr>
                    <td><h6>Status</h6></td>
                    <td><h6>Date Filed</h6></td>
                    <td><h6>Location</h6></td>
                    <td><h6>Date From</h6></td>
                    <td><h6>Date To</h6></td>
                    <td><h6>Time From</h6></td>
                    <td><h6>Time To</h6></td>
                    <td><h6>Purpose</h6></td>
                    <td><h6>Date Approved</h6></td>
                </tr>
            </table>
        </div>
        <div class="mob-rejected-table u-m-15" style="overflow-x: auto; border-radius: 0.5rem;">
            <table class="u-responsive-table">
                <tr class="f-weight-bold">
                    <td><h6 class="f-weight-bold">Status</h6></td>
                    <td><h6 class="f-weight-bold">Date Filed</h6></td>
                    <td><h6 class="f-weight-bold">Location</h6></td>
                    <td><h6 class="f-weight-bold">Date From</h6></td>
                    <td><h6 class="f-weight-bold">Date To</h6></td>
                    <td><h6 class="f-weight-bold">Time From</h6></td>
                    <td><h6 class="f-weight-bold">Time To</h6></td>
                    <td><h6 class="f-weight-bold">Purpose</h6></td>
                    <td><h6 class="f-weight-bold">Reject/Cancel Reason</h6></td>
                    <td><h6 class="f-weight-bold">Date Rejected/Cancelled</h6></td>
                </tr>
                <tr>
                    <td><h6>Status</h6></td>
                    <td><h6>Date Filed</h6></td>
                    <td><h6>Location</h6></td>
                    <td><h6>Date From</h6></td>
                    <td><h6>Date To</h6></td>
                    <td><h6>Time From</h6></td>
                    <td><h6>Time To</h6></td>
                    <td><h6>Purpose</h6></td>
                    <td><h6>Reject/Cancel Reason</h6></td>
                    <td><h6>Date Rejected/Cancelled</h6></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div style="clear: both;"></div>

    @section('script_content')
        <script>
            $('.my_official_business_content').fadeIn('slow');

            $('.user_accounts_table').fadeIn('slow');

            $('.my_official_business_content').fadeIn('slow');

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