@extends('layouts.side_top_content', ['title' => 'My Overtimes'])

@section('module_name', 'My Overtimes')

@section('content')

<style>
    .modal-box{
        max-width: 75rem !important;
    }
</style>

<div x-data="{ openTab: '{{ $openTab }}' }">
    <div class="modal-center add-ot-form" style="display: none;">
        <div class="modal-box">
            <div class="modal-content">
                <form method="POST" action="{{ route('submitOT') }}" class="add-form" autocomplete="off" id="add-form">
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
                                        <p>Date:</p>
                                        <input class="u-input-border-boottom shift-date" type="date" name="shift_date" value="" max="{{ $server_date }}" id="shift_date" required>
                                    </td>
                                    <td>
                                        <p>Day:</p>
                                        <input class="u-input-border-boottom day-name" type="text" value="" readonly>
                                    </td>
                                    <td>
                                        <p>Shift From:</p>
                                        <input class="u-input-border-boottom shift-from" name="shift_from" value="" placeholder="" type="time" readonly>
                                    </td>
                                    <td>
                                        <p>Shift To:</p>
                                        <input class="u-input-border-boottom shift-to" name="shift_to" value="" placeholder="" type="time" readonly>
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
                                            <option value="" selected disabled>Select OT classification</option>
                                            <option value="Normal OT">Normal OT</option>
                                            <option value="Rest Day OT">Rest Day OT</option>
                                            <option value="Holiday OT">Holiday OT</option>
                                        </select>
                                    </td> 
                                    <td>
                                        <p>Start:</p>
                                        <input class="u-input start-time" name="start_time" value="" placeholder="" type="time" readonly required>
                                    </td>                           
                                    <td>
                                        <p>End:</p>
                                        <input class="u-input end-time" name="end_time" type="time" required>
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
                    <div class="warning-note" style="display: none;">
                        <p class="u-t-danger u-fw-b u-fs-16 u-m-10">Note: Please clock in first today before filing your overtime.</p>
                    </div>
                    <div class="u-flex-space-between">
                        <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default" id="btn-close" type="button">Close</button>
                        <button class="u-t-white u-fw-b u-btn u-bg-accent u-m-10 u-border-1-default submit-btn-ot" id="btn-close" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-center edit-ot-form" id="edit-ot-form" style="display: none;">
        <div class="modal-box">
            <div class="modal-content">
                <form method="POST" class="edit-form" autocomplete="off" id="edit-form">
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
                                        <p>Date:</p>
                                        <input class="u-input-border-boottom shift-date" type="date" name="shift_date" value="" max="{{ $server_date }}" id="shift_date" required>
                                    </td>
                                    <td>
                                        <p>Day:</p>
                                        <input class="u-input-border-boottom day-name" type="text" value="" readonly>
                                    </td>
                                    <td>
                                        <p>Shift From:</p>
                                        <input class="u-input-border-boottom shift-from" name="shift_from" value="" placeholder="" type="time" readonly>
                                    </td>
                                    <td>
                                        <p>Shift To:</p>
                                        <input class="u-input-border-boottom shift-to" name="shift_to" value="" placeholder="" type="time" readonly>
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
                                        <select class="u-input ot-classification" name="ot_classification" required>
                                            <option value="" selected disabled>Select OT classification</option>
                                            <option value="Normal OT">Normal OT</option>
                                            <option value="Rest Day OT">Rest Day OT</option>
                                            <option value="Holiday OT">Holiday OT</option>
                                        </select>
                                    </td> 
                                    <td>
                                        <p>Start:</p>
                                        <input class="u-input start-time" name="start_time" value="" placeholder="" type="time" readonly required>
                                    </td>                           
                                    <td>
                                        <p>End:</p>
                                        <input class="u-input end-time" name="end_time" type="time" required>
                                    </td>                           
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <p>Indicate Ticket Number (If Applicable) and Reason</p>
                                        <input class="u-input-border-boottom ot-reason" name="reason" type="text" placeholder="Enter Reason" required>
                                    </td>                            
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="warning-note" style="display: none;">
                        <p class="u-t-danger u-fw-b u-fs-16 u-m-10">Note: Please clock in first today before filing your overtime.</p>
                    </div>
                    <div class="u-flex-space-between">
                        <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default" id="btn-close-edit" type="button">Close</button>
                        <button class="u-t-white u-fw-b u-btn u-bg-accent u-m-10 u-border-1-default submit-btn-ot" id="btn-edit-submit" type="submit">Submit</button>
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
                                    <h5 @click="openTab = 'pending'" :class="openTab == 'pending' ? 'my_official_businesses_header_active' : ''" class="my_official_businesses_header" id="mob-pending">Pending/Resubmit for editing</h5>
                                    <h5 @click="openTab = 'approved'" :class="openTab == 'approved' ? 'my_official_businesses_header_active' : ''" class="my_official_businesses_header" id="mob-approve">Approved</h5>
                                    <h5 @click="openTab = 'rejected_canceled'" :class="openTab == 'rejected_canceled' ? 'my_official_businesses_header_active' : ''" class="my_official_businesses_header" id="mob-rejected">Rejected/Canceled</h5>
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
                            <td><h5 class="u-fw-b">My Request - <span id="status-label" x-text="
                                openTab == 'pending' ? 'Pending' : openTab == 'approved' ? 'Approved' : openTab == 'rejected_canceled' ? 'Rejected/Canceled' : ''
                            ">Pending</span></h5></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div x-show="openTab === 'pending'" x-transition class="mob-pending-table u-m-10" style="overflow-x: auto;">
                <table class="u-responsive-table">
                    <thead>
                        <tr class="f-weight-bold u-t-gray">
                            <td><h5 class="f-weight-bold">Status</h5></td>
                            <td><h5 class="f-weight-bold">Date Filed</h5></td>
                            <td><h5 class="f-weight-bold">Date</h5></td>
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
                                <td><h5>{{ date('F d Y', strtotime($pending_log->created_at))}}</h5></td>
                                <td><h5>{{ date('F d Y', strtotime($pending_log->shift_date))}}</h5></td>
                                <td><h5>{{ $pending_log->shift_from ? date('g:ia', strtotime($pending_log->shift_from)) : ''}}</h5></td>
                                <td><h5>{{ $pending_log->shift_to ? date('g:ia', strtotime($pending_log->shift_to)) : ''}}</h5></td>
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
                {{ $pending_logs->links() }}
                <p>Showing {{ $pending_logs->firstItem() ?? 0 }} to {{ $pending_logs->lastItem() ?? 0 }} of {{ $pending_logs->total() }} items.</p>    
            </div>
            <div x-show="openTab === 'approved'" x-transition class="mob-approve-table u-m-10" style="overflow-x: auto;">
                <table class="u-responsive-table">
                    <thead>
                        <tr class="f-weight-bold u-t-gray">
                            <td><h5 class="f-weight-bold">Status</h5></td>
                            <td><h5 class="f-weight-bold">Date Filed</h5></td>
                            <td><h5 class="f-weight-bold">Date</h5></td>
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
                                <td><h5>{{ date('F d Y', strtotime($approved_log->created_at))}}</h5></td>
                                <td><h5>{{ date('F d Y', strtotime($approved_log->shift_date)) }}</h5></td>
                                <td><h5>{{ $approved_log->shift_from ? date('g:ia', strtotime($approved_log->shift_from)) : ''}}</h5></td>
                                <td><h5>{{ $approved_log->shift_to ? date('g:ia', strtotime($approved_log->shift_to)) : ''}}</h5></td>
                                <td><h5>{{ date('g:ia', strtotime($approved_log->time_start)) }}</h5></td>
                                <td><h5>{{ date('g:ia', strtotime($approved_log->time_end))}}</h5></td>
                                <td><h5>{{ $approved_log->reason }}</h5></td>
                                <td><h5>{{ date('M d Y h:i a', strtotime($approved_log->approved_at))}}</h5></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $approved_logs->links() }}
                <p>Showing {{ $approved_logs->firstItem() ?? 0 }} to {{ $approved_logs->lastItem() ?? 0 }} of {{ $approved_logs->total() }} items.</p>    
            </div>
            <div x-show="openTab === 'rejected_canceled'" x-transition class="mob-rejected-table u-m-10" style="overflow-x: auto;">
                <table class="u-responsive-table">
                    <thead>
                        <tr class="f-weight-bold u-t-gray">
                            <td><h5 class="f-weight-bold">Status</h5></td>
                            <td><h5 class="f-weight-bold">Date Filed</h5></td>
                            <td><h5 class="f-weight-bold">Date</h5></td>
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
                            <td><h5>{{ date('F d Y', strtotime($rejected_canceled_log->created_at))}}</h5></td>
                            <td><h5>{{ date('F d Y', strtotime($rejected_canceled_log->shift_date)) }}</h5></td>
                            <td><h5>{{ $rejected_canceled_log->shift_from ? date('g:ia', strtotime($rejected_canceled_log->shift_from)) : ''}}</h5></td>
                            <td><h5>{{ $rejected_canceled_log->shift_to ? date('g:ia', strtotime($rejected_canceled_log->shift_to)) : ''}}</h5></td>
                            <td><h5>{{ date('g:ia', strtotime($rejected_canceled_log->time_start)) }}</h5></td>
                            <td><h5>{{ date('g:ia', strtotime($rejected_canceled_log->time_end))}}</h5></td>
                            <td><h5>{{ $rejected_canceled_log->reason }}</h5></td>
                            <td><h5>{{ date('M d Y h:i a', strtotime($rejected_canceled_log->rejected_at) ?: strtotime($rejected_canceled_log->cancelled_at)) }}</h5></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $rejected_canceled_logs->links() }}
                <p>Showing {{ $rejected_canceled_logs->firstItem() ?? 0 }} to {{ $rejected_canceled_logs->lastItem() ?? 0 }} of {{ $rejected_canceled_logs->total() }} items.</p>    
            </div>
        </form>
    </div>
</div>



    @section('script_content')
        <script>
            const userSchedules = {!! json_encode($user_schedules) !!}

            $('.shift-date').on('change', function() {
                const value = $(this).val();
                const form = $(this).parents('form');
                const date = new Date(`${value}`);
                const dayName = date.toLocaleString('en-us', { weekday: 'long', timeZone: 'UTC' });
                const sched = userSchedules.find(sched => sched.work_day === dayName);
                const isRestDay = sched.rest_day;
                const workFrom = sched.work_from;
                const workTo = sched.work_to;
                const startTime = sched.work_to;
                form.find('.shift-from').val(workFrom);
                form.find('.shift-to').val(workTo);
                form.find('.day-name').val(dayName);
                form.find('.start-time').val(startTime);
                form.find('.end-time').val('');

                const serverDate = "{{ $server_date }}";
                const hasClockInToday = "{{ $has_clock_in_today }}" == '1';
                const dateValue = form.find('.shift-date').val();
                if (dateValue === serverDate && !hasClockInToday && !isRestDay) {
                    form.find('.warning-note').show();
                    form.find('.submit-btn-ot').attr('disabled', true);
                    form.find('.submit-btn-ot').css('opacity', '0.7');
                } else {
                    form.find('.warning-note').hide();
                    form.find('.submit-btn-ot').attr('disabled', false);
                    form.find('.submit-btn-ot').css('opacity', '1');
                }

                if (isRestDay) {
                    form.find('.start-time').attr('readonly', false);
                } else {
                    form.find('.start-time').attr('readonly', true);
                }
            });

            // $('.add-form, .edit-form').on('submit', function(e) {
            //     e.preventDefault();
            //     const serverDate = "{{ $server_date }}";
            //     const hasClockInToday = "{{ $has_clock_in_today }}" == '1';
            //     const dateValue = $(this).find('.shift-date').val();
            //     if (dateValue === serverDate && !hasClockInToday) {
            //         $(this).find('.warning-note').show();
            //         return false;
            //     }
            //     $(this).find('.warning-note').hide();
            //     this.submit();
            // });


            $('.my_official_business_content').fadeIn('slow');

            $('.user_accounts_table').fadeIn('slow');

            $('.my_official_business_content').fadeIn('slow');

            $('.mob-approve-table').hide();
            $('.mob-rejected-table').hide();


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
                        const form = $('.edit-form');
                        let submitUrl = "{{ route('my_overtimes.update', 'entryId') }}";
                        submitUrl = submitUrl.replace('entryId', response.id);
                        form.find('.shift-date').val(response.shift_date);
                        form.find('.shift-date').trigger('change');
                        form.find('.start-time').val(response.time_start);
                        form.find('.end-time').val(response.time_end);
                        form.find('.ot-classification').val(response.ot_classification);
                        form.find('.ot-reason').val(response.reason);
                        // form.find('#edit_day_name').val(response.day_name);
                        // form.find('#edit_shift_from').val(response.shift_from);
                        // form.find('#edit_shift_to').val(response.shift_to);
                        // form.find('#edit_time_start').val(response.time_start);
                        // form.find('#edit_time_end').val(response.time_end);
                        // form.find('#edit_ot_classification').val(response.ot_classification);
                        // form.find('#edit_reason').val(response.reason);
                        $('.edit-ot-form').show(); 
                        form.attr('action', submitUrl);
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
        </script>
    @endsection
@endsection