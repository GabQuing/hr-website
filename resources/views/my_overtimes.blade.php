@extends('layouts.side_top_content')

@section('module_name', 'My Overtimes')

@section('content')

<style>
    .modal{
        max-width: 600px;
    }
</style>

<div class="modal" id="add_ot_modal">
    <form method="POST" action="">
    @csrf
        <div class="modal_body" >
            <input type="text" name="employeeName" value="{{ auth()->user()->employee_name }}" style="display: none;"> 
            <div class="container_title">
                <p class="header_title_h2">Overtime Request Form</p>
            </div>
            <div class="summary_report">
                <div class="sr_from_date">
                    <label for="">Shift Date:</label>
                    <input type="date" name="from_date" id="from_date" value="" required>
                </div>
                <div class="sr_from_date">
                    <label for="">Shift From:</label>
                    <input type="time" name="from_time" id="from_time" value="" required>
                </div>
                <div class="sr_to_date">
                    <label for="">Shift To:</label>
                    <input type="time" name="to_time" id="to_time" value="" required>
                </div>
                <div class="sr_to_date">
                    <label for="">Reason:</label>
                    <input type="input" name="to_time" id="to_time" value="" required>
                </div>
            </div>
            <div class="datebtn">
                <button type="submit" class="date_generate">Submit Form</button>
            </div>
        </div>
    </form>
</div>

<div class="my_official_business_content" style="display: none;">
    <div class="my_official_business_main_content">
        <div class="my_official_business_header" >
            <p class="header_title_h2">My Overtimes</p>
        </div>
        <div class="my_official_businesses">
            <span class="my_official_businesses_header">Pending/Resubmit for editing</span>
            <span class="my_official_businesses_header">Approved</span>
            <span class="my_official_businesses_header">Rejected/Cancelled</span>
            <a href="#add_ot_modal" rel="modal:open" style="display: block; margin-top: 12px;" class="my_official_business_add">
                <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 16px; font-weight: bold;">
                    add
                </span>
                Add OT
            </a>
        </div>
        <div class="my_official_business_request_pending">
            <p>Request Pending</p>
        </div>
        <div class="user_accounts_table">
            <table id="myTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Status</th>
                        <th>Actions</th>            
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Name</th>
                        <th>Email</th>
                        {{-- <th>Approval Status</th> --}}
                        <th>Role</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Status</th>     
                        <th>Actions</th>     
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div style="clear: both;"></div>

    @section('script_content')
        <script>
            $('.my_official_business_content').fadeIn('slow');

            $('.user_accounts_table').fadeIn('slow');

        </script>
    @endsection
@endsection