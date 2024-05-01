@extends('layouts.side_top_content', ['title' => 'My Overtimes'])

@section('module_name', 'My Overtimes')

@section('content')

<style>
    .modal-box{
        max-width: 75rem !important;
    }
</style>

<div class="modal-center add-ot-form" style="display: none;">
    <div class="modal-box">
        <div class="modal-content">
            <form method="POST" action="{{ route('submitOT') }}">
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
                                    <span>{{ $employee_schedule ?? "No Schedule" }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Day:</p>
                                    <input class="u-input-border-boottom" type="text" value="{{ $serverCurrentDay }}" readonly>
                                </td>
                                <td>
                                    <p>Shift Date:</p>
                                    <input class="u-input-border-boottom" type="date" name="shift_date" value="{{ $serverDateTime->format('Y-m-d') }}" id="shift_date" readonly>
                                </td>
                                <td>
                                    <p>Shift From:</p>
                                    <input class="u-input-border-boottom" name="shift_from" value="{{ $shift_from }}" placeholder="{{ $shift_from }}" type="time" readonly>
                                </td>
                                <td>
                                    <p>Shift To:</p>
                                    <input class="u-input-border-boottom" name="shift_to" value="{{ $shift_to }}" placeholder="{{ $shift_to }}" type="time" readonly>
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
                                        <option selected value="Normal OT">Normal OT</option>
                                    </select>
                                </td> 
                                <td>
                                    <p>Start:</p>
                                    <input class="u-input" name="start_time" value="{{ $shift_to }}" placeholder="{{ $shift_to }}" type="time" readonly>
                                </td>                           
                                <td>
                                    <p>End:</p>
                                    <input class="u-input" name="end_time" type="time" required>
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
<div class="modal-center edit-ot-form" id="edit-ot-form" style="display: none;">
    <div class="modal-box">
        <div class="modal-content">
            <form method="POST" >
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
                                    <p>Day:</p>
                                    <input class="u-input-border-boottom" type="text" id="edit_day_name" value="" readonly>
                                </td>
                                <td>
                                    <p>Shift Date:</p>
                                    <input class="u-input-border-boottom" type="date" name="shift_date" value="" id="edit_shift_date" readonly>
                                </td>
                                <td>
                                    <p>Shift From:</p>
                                    <input class="u-input-border-boottom" name="shift_from" value=""  id="edit_shift_from" type="time" readonly>
                                </td>
                                <td>
                                    <p>Shift To:</p>
                                    <input class="u-input-border-boottom" name="shift_to" value=""  id="edit_shift_to"type="time" readonly>
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
                                    <input class="u-input-border-boottom" name="ot_classification" value="" id="edit_ot_classification" type="text" readonly>
                                </td> 
                                <td>
                                    <p>Start:</p>
                                    <input class="u-input" name="start_time" value="" id="edit_time_start"  type="time" readonly>
                                </td>                           
                                <td>
                                    <p>End:</p>
                                    <input class="u-input" name="end_time" type="time" id="edit_time_end" required>
                                </td>                           
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <p>Indicate Ticket Number (If Applicable) and Reason</p>
                                    <input class="u-input-border-boottom" name="reason" id="edit_reason"type="text" placeholder="Enter Reason" required>
                                </td>                            
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="u-flex-space-between">
                    <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default" id="btn-close-edit" type="button">Close</button>
                    <button class="u-t-white u-fw-b u-btn u-bg-accent u-m-10 u-border-1-default" id="btn-edit-submit" type="submit">Submit</button>
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
            <h4 class="u-t-center u-t-white u-fw-b">My Overtimes</h4>
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
                                    Add OT
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>    

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
                    <tr class="u-t-gray">
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
                        <td><h5 class="f-weight-bold">Shift From</h5></td>
                        <td><h5 class="f-weight-bold">Shift To</h5></td>
                        <td><h5 class="f-weight-bold">Time Start</h5></td>
                        <td><h5 class="f-weight-bold">Time End</h5></td>
                        <td><h5 class="f-weight-bold">Purpose</h5></td>
                        <td><h5 class="f-weight-bold">Actions</h5></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pending_logs as $pending_log)
                        <tr>
                            <td><h5>{{ $pending_log->status }}</h5></td>
                            <td><h5>{{ date('F d Y', strtotime($pending_log->shift_date))}}</h5></td>
                            <td><h5>{{ date('g:ia', strtotime($pending_log->shift_from))}}</h5></td>
                            <td><h5>{{ date('g:ia', strtotime($pending_log->shift_to)) }}</h5></td>
                            <td><h5>{{ date('g:ia', strtotime($pending_log->time_start)) }}</h5></td>
                            <td><h5>{{ date('g:ia', strtotime($pending_log->time_end)) }}</h5></td>
                            <td><h5>{{ $pending_log->reason }}</h5></td>
                            <td>
                                <div class="d-flex;">
                                    <button type="button" class="u-action-btn u-bg-primary btn-edit" data-entry-id="{{ $pending_log->id }}" data-href="{{ route('editOT', $pending_log->id) }}">
                                        <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 20px; font-weight: bold;">
                                            edit
                                        </span>
                                    </button>
                                    <button type="button" class="u-action-btn u-bg-danger btn-cancel" data-entry-id="{{ $pending_log->id }}" data-href="{{ route('deleteOT', $pending_log->id) }}" >
                                        <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 20px; font-weight: bold;">
                                            delete
                                        </span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mob-approve-table u-m-10" style="overflow-x: auto;">
            <table class="u-responsive-table">
                <thead>
                    <tr class="f-weight-bold u-t-gray">
                        <td><h5 class="f-weight-bold">Status</h5></td>
                        <td><h5 class="f-weight-bold">Date Filed</h5></td>
                        <td><h5 class="f-weight-bold">Shift From</h5></td>
                        <td><h5 class="f-weight-bold">Shift To</h5></td>
                        <td><h5 class="f-weight-bold">Time Start</h5></td>
                        <td><h5 class="f-weight-bold">Time End</h5></td>
                        <td><h5 class="f-weight-bold">Purpose</h5></td>
                        <td><h5 class="f-weight-bold">Date Approved</h5></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($approved_logs as $approved_log)
                        <tr>
                            <td><h5>{{ $approved_log->status }}</h5></td>
                            <td><h5>{{ date('F d Y', strtotime($approved_log->shift_date)) }}</h5></td>
                            <td><h5>{{ date('g:ia', strtotime($approved_log->shift_from)) }}</h5></td>
                            <td><h5>{{ date('g:ia', strtotime($approved_log->shift_to)) }}</h5></td>
                            <td><h5>{{ date('g:ia', strtotime($approved_log->time_start)) }}</h5></td>
                            <td><h5>{{ date('g:ia', strtotime($approved_log->time_end))}}</h5></td>
                            <td><h5>{{ $approved_log->reason }}</h5></td>
                            <td><h5>{{ date('M d Y h:i a', strtotime($approved_log->approved_at))}}</h5></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mob-rejected-table u-m-10" style="overflow-x: auto;">
            <table class="u-responsive-table">
                <thead>
                    <tr class="f-weight-bold u-t-gray">
                        <td><h5 class="f-weight-bold">Status</h5></td>
                        <td><h5 class="f-weight-bold">Date Filed</h5></td>
                        <td><h5 class="f-weight-bold">Shift From</h5></td>
                        <td><h5 class="f-weight-bold">Shift To</h5></td>
                        <td><h5 class="f-weight-bold">Time Start</h5></td>
                        <td><h5 class="f-weight-bold">Time End</h5></td>
                        <td><h5 class="f-weight-bold">Purpose</h5></td>
                        <td><h5 class="f-weight-bold">Date Rejected/Cancelled</h5></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rejected_canceled_logs as $rejected_canceled_log)
                    <tr>
                        <td><h5>{{ $rejected_canceled_log->status }}</h5></td>
                        <td><h5>{{ date('F d Y', strtotime($rejected_canceled_log->shift_date)) }}</h5></td>
                        <td><h5>{{ date('g:ia', strtotime($rejected_canceled_log->shift_from)) }}</h5></td>
                        <td><h5>{{ date('g:ia', strtotime($rejected_canceled_log->shift_to)) }}</h5></td>
                        <td><h5>{{ date('g:ia', strtotime($rejected_canceled_log->time_start)) }}</h5></td>
                        <td><h5>{{ date('g:ia', strtotime($rejected_canceled_log->time_end))}}</h5></td>
                        <td><h5>{{ $rejected_canceled_log->reason }}</h5></td>
                        <td><h5>{{ date('M d Y h:i a', strtotime($rejected_canceled_log->rejected_at) ?: strtotime($rejected_canceled_log->cancelled_at)) }}</h5></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </form>
</div>

{{-- <div class="my_official_business_content" style="display: none">
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
            <div>
                @if (session('success'))
                    <br>
                    <span style="color: green; display:block;">{{ session('success') }}</span>
                @endif
            </div>
        </div>
        <div class="my_official_business_request_pending u-m-15">
            <h5 style="font-weight: bold;">My Request - <span class="request-title">Pending</span></h5>
        </div>
        <div class="mob-pending-table u-m-15" style="overflow-x: auto; border-radifus: 0.5rem;">
            <table class="u-responsive-table">
                <thead>
                    <tr class="f-weight-bold">
                        <td><h6 class="f-weight-bold">Status</h6></td>
                        <td><h6 class="f-weight-bold">Date Filed</h6></td>
                        <td><h6 class="f-weight-bold">Shift From</h6></td>
                        <td><h6 class="f-weight-bold">Shift To</h6></td>
                        <td><h6 class="f-weight-bold">Time Start</h6></td>
                        <td><h6 class="f-weight-bold">Time End</h6></td>
                        <td><h6 class="f-weight-bold">Purpose</h6></td>
                        <td><h6 class="f-weight-bold">Actions</h6></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pending_logs as $pending_log)
                        <tr>
                            <td><h6>{{ $pending_log->status }}</h6></td>
                            <td><h6>{{ $pending_log->shift_date }}</h6></td>
                            <td><h6>{{ $pending_log->shift_from }}</h6></td>
                            <td><h6>{{ $pending_log->shift_to }}</h6></td>
                            <td><h6>{{ $pending_log->time_start }}</h6></td>
                            <td><h6>{{ $pending_log->time_end }}</h6></td>
                            <td><h6>{{ $pending_log->reason }}</h6></td>
                            <td>
                                <div class="d-flex;">
                                    <button type="button" class="u-action-btn u-bg-primary btn-edit" data-entry-id="{{ $pending_log->id }}" data-href="{{ route('editOT', $pending_log->id) }}">
                                        <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 20px; font-weight: bold;">
                                            edit
                                        </span>
                                    </button>
                                    <button type="button" class="u-action-btn u-bg-danger btn-cancel" data-entry-id="{{ $pending_log->id }}" data-href="{{ route('deleteOT', $pending_log->id) }}" >
                                        <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 20px; font-weight: bold;">
                                            delete
                                        </span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mob-approve-table u-m-15" style="overflow-x: auto; border-radius: 0.5rem;">
            <table class="u-responsive-table">
                <thead>
                    <tr class="f-weight-bold">
                        <td><h6 class="f-weight-bold">Status</h6></td>
                        <td><h6 class="f-weight-bold">Date Filed</h6></td>
                        <td><h6 class="f-weight-bold">Shift From</h6></td>
                        <td><h6 class="f-weight-bold">Shift To</h6></td>
                        <td><h6 class="f-weight-bold">Time Start</h6></td>
                        <td><h6 class="f-weight-bold">Time End</h6></td>
                        <td><h6 class="f-weight-bold">Purpose</h6></td>
                        <td><h6 class="f-weight-bold">Date Approved</h6></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($approved_logs as $approved_log)
                        <tr>
                            <td><h6>{{ $approved_log->status }}</h6></td>
                            <td><h6>{{ $approved_log->shift_date }}</h6></td>
                            <td><h6>{{ $approved_log->shift_from }}</h6></td>
                            <td><h6>{{ $approved_log->shift_to }}</h6></td>
                            <td><h6>{{ $approved_log->time_start }}</h6></td>
                            <td><h6>{{ $approved_log->time_end }}</h6></td>
                            <td><h6>{{ $approved_log->reason }}</h6></td>
                            <td><h6>{{ $approved_log->approved_at }}</h6></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mob-rejected-table u-m-15" style="overflow-x: auto; border-radius: 0.5rem;">
            <table class="u-responsive-table">
                <thead>
                    <tr class="f-weight-bold">
                        <td><h6 class="f-weight-bold">Status</h6></td>
                        <td><h6 class="f-weight-bold">Date Filed</h6></td>
                        <td><h6 class="f-weight-bold">Shift From</h6></td>
                        <td><h6 class="f-weight-bold">Shift To</h6></td>
                        <td><h6 class="f-weight-bold">Time Start</h6></td>
                        <td><h6 class="f-weight-bold">Time End</h6></td>
                        <td><h6 class="f-weight-bold">Purpose</h6></td>
                        <td><h6 class="f-weight-bold">Date Rejected/Cancelled</h6></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rejected_canceled_logs as $rejected_canceled_log)
                    <tr>
                        <td><h6>{{ $rejected_canceled_log->status }}</h6></td>
                        <td><h6>{{ $rejected_canceled_log->shift_date }}</h6></td>
                        <td><h6>{{ $rejected_canceled_log->shift_from }}</h6></td>
                        <td><h6>{{ $rejected_canceled_log->shift_to }}</h6></td>
                        <td><h6>{{ $rejected_canceled_log->time_start }}</h6></td>
                        <td><h6>{{ $rejected_canceled_log->time_end }}</h6></td>
                        <td><h6>{{ $rejected_canceled_log->reason }}</h6></td>
                        <td><h6>{{ $rejected_canceled_log->rejected_at ?? $rejected_canceled_log->cancelled_at }}</h6></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div> --}}

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
                $('.add-ot-form').show();
            })

            $('#btn-close').on('click', function(){
                $('.add-ot-form').hide();
            })

            $('#btn-close-edit').on('click', function(){
            $('.edit-ot-form').hide();
            })


            $('.btn-edit').click(function(e){
                e.preventDefault();
                const entryId = $(this).data('entry-id');
                const url = $(this).attr('href');
                let editUrl = "{{ route('editOT', 'entryId') }}";
                const newUrl = editUrl.replace('entryId', entryId);
                console.log(newUrl);
                $.ajax({
                    url: newUrl,   
                    dataType: 'json',
                    type: 'GET',
                    success: function(response) {
                        let submitUrl = "{{ route('my_overtimes.update', 'entryId') }}";
                        submitUrl = submitUrl.replace('entryId', response.id);
                        $('#edit_shift_date').val(response.shift_date);
                        $('#edit_day_name').val(response.day_name);
                        $('#edit_shift_from').val(response.shift_from);
                        $('#edit_shift_to').val(response.shift_to);
                        $('#edit_time_start').val(response.time_start);
                        $('#edit_time_end').val(response.time_end);
                        $('#edit_ot_classification').val(response.ot_classification);
                        $('#edit_reason').val(response.reason);
                        $('.edit-ot-form').show(); 
                        $('form').attr('action', submitUrl);
                        console.log(response);
                    },
                    error: function(error) {
                    console.log(error);
                    }
                });
            });

            $('.btn-cancel').click(function(e) {
            e.preventDefault();
            const entryId = $(this).data('entry-id');
            const url = $(this).attr('href');
            let editUrl = "{{ route('deleteOT', 'entryId') }}";
            const newUrl = editUrl.replace('entryId', entryId);
            console.log(newUrl);
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                reverseButtons: true,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Remove It!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: newUrl,   
                    dataType: 'json',
                    type: 'GET',
                        success: function(response) {
                            Swal.fire(
                                'Removed!',
                                'The OT request has been canceled.',
                                'success'
                            )
                            .then(() => {
                                location.reload(); // Refresh the browser
                            });
                        },
                        error: function(error) {
                        console.log(error);
                        }
                    });
                }
            });
        });



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