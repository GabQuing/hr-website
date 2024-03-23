@extends('layouts.side_top_content' , ['title' => 'My Leaves'])

@section('module_name', 'My Leaves')

@section('content')

    <style>
        .modal-box{
            max-width: 75rem !important;
        }
    </style>

    <div class="modal-center add-leave-form" style="display: none">
        <div class="modal-box">
            <div class="modal-content">
                <form method="POST" action="{{ route('submitLeave') }}">
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
                                        <select class="u-input" name="leave_type" id="" required>
                                            <option value="" selected disabled>None selected</option>
                                            <option value="BIRTHDAY">BIRTHDAY</option>
                                            <option value="VACATION">VACATION</option>
                                        </select>
                                    </td>        
                                    <td>
                                        <p>Duration:</p>
                                        <select class="u-input" name="duration" id="" required>
                                            <option value="" selected disabled>None selected</option>
                                            <option value="WHOLEDAY">WHOLEDAY</option>
                                            <option value="HALFDAY">HALFDAY</option>
                                        </select>
                                    </td>        
                                </tr>
                                <tr>                   
                                    <td>
                                        <p>From:</p>
                                        <input class="u-input" name="leave_from" type="date" required>
                                    </td>                           
                                </tr>
                                <tr>
                                    <td>
                                        <p>Birthday : Default Birthday leave policy</p>
                                        <span>{{ $employee_leaves->sick_credit ?? 0}}</span>
                                    </td>
                                    <td>
                                        <p>Vacation : Default Vacation leave policy</p>
                                        <span>{{ $employee_leaves->vacation_credit ?? 0 }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Alaska Current Date:</p>
                                        <span>{{ $serverCurrentDay }}, {{ $serverFormattedDate }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <p>Reason</p>
                                        <input class="u-input-border-boottom" name="reason" type="text" placeholder="Enter Reason" required>
                                    </td>                            
                                </tr>
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


    <div class="modal-center edit-leave-form"  id="edit-leave-form" style="display: none">
        <div class="modal-box">
            <div class="modal-content">
                <form method="POST">
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
                                        <select class="u-input" name="leave_type" id="edit_leave_type" required>
                                            <option value="" selected disabled>None selected</option>
                                            <option value="BIRTHDAY">BIRTHDAY</option>
                                            <option value="VACATION">VACATION</option>
                                        </select>
                                    </td>        
                                    <td>
                                        <p>Duration:</p>
                                        <select class="u-input" name="duration" id="edit_duration" required>
                                            <option value="" selected disabled>None selected</option>
                                            <option value="WHOLEDAY">WHOLEDAY</option>
                                            <option value="HALFDAY">HALFDAY</option>
                                        </select>
                                    </td>        
                                </tr>
                                <tr>                   
                                    <td>
                                        <p>From:</p>
                                        <input class="u-input" name="leave_from" id="edit_leave_from" type="date" required>
                                    </td>                           
                                </tr>
                                <tr>
                                    <td>
                                        <p>Birthday Leave Credits:</p>
                                        <span id="blc"></span>
                                    </td>
                                    <td>
                                        <p>Vacation Leave Credits:</p>
                                        <span id="vlc"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <p>Reason</p>
                                        <input class="u-input-border-boottom" name="reason" id="edit_reason" type="text" placeholder="Enter Reason" required>
                                    </td>                            
                                </tr>
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
                            <h5 class="u-fw-b u-t-gray">{{ $employee_leaves->sick_credit ?? 0}}</h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h5 class="u-fw-b u-t-gray">Vacation : Default Vacation leave policy</h5>
                        </td>
                        <td>
                            <h5 class="u-fw-b u-t-gray">{{ $employee_leaves->vacation_credit ?? 0 }}</h5>
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
                            <td><h5 class="f-weight-bold">Leave Type</h5></td>
                            <td><h5 class="f-weight-bold">Leave From</h5></td>
                            <td><h5 class="f-weight-bold">Duration</h5></td>
                            <td><h5 class="f-weight-bold">Purpose</h5></td>
                            <td><h5 class="f-weight-bold">Actions</h5></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pending_logs as $pending_log)
                            <tr>
                                <td><h5>{{ $pending_log->status }}</h5></td>
                                <td><h5>{{ $pending_log->created_at->format('Y-m-d')}}</h5></td>
                                <td><h5>{{ $pending_log->leave_type }}</h5></td>
                                <td><h5>{{ $pending_log->leave_from }}</h5></td>
                                <td><h5>{{ $pending_log->duration }}</h5></td>
                                <td><h5>{{ $pending_log->reason }}</h5></td>
                                <td>
                                    <div class="d-flex;">
                                        <button type="button" class="u-action-btn u-bg-primary btn-edit" data-entry-id="{{ $pending_log->id }}" data-href="{{ route('editLeave', $pending_log->id) }}">
                                            <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 20px; font-weight: bold;">
                                                edit
                                            </span>
                                        </button>
                                        <button type="button" class="u-action-btn u-bg-danger btn-cancel" data-entry-id="{{ $pending_log->id }}" data-href="{{ route('deleteLeave', $pending_log->id) }}" >
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
                            <td><h5 class="f-weight-bold">Leave Type</h5></td>
                            <td><h5 class="f-weight-bold">Leave From</h5></td>
                            <td><h5 class="f-weight-bold">Duration</h5></td>
                            <td><h5 class="f-weight-bold">Purpose</h5></td>
                            <td><h5 class="f-weight-bold">Date Approved</h5></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($approved_logs as $approved_log)
                            <tr>    
                                <td><h5>{{ $approved_log->status }}</h5></td>
                                <td><h5>{{ $approved_log->created_at->format('Y-m-d')}}</h5></td>
                                <td><h5>{{ $approved_log->leave_type }}</h5></td>
                                <td><h5>{{ $approved_log->leave_from }}</h5></td>
                                <td><h5>{{ $approved_log->duration }}</h5></td>
                                <td><h5>{{ $approved_log->reason }}</h5></td>
                                <td><h5>{{ $approved_log->approved_at}}</h5></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mob-rejected-table u-m-10" style="overflow-x: auto;">
                <table class="u-responsive-table">
                    <thead>
                        <tr class="f-weight-bold u-t-gray">
                            <tr class="f-weight-bold u-t-gray">
                                <td><h5 class="f-weight-bold">Status</h5></td>
                                <td><h5 class="f-weight-bold">Date Filed</h5></td>
                                <td><h5 class="f-weight-bold">Leave Type</h5></td>
                                <td><h5 class="f-weight-bold">Leave From</h5></td>
                                <td><h5 class="f-weight-bold">Duration</h5></td>
                                <td><h5 class="f-weight-bold">Purpose</h5></td>
                                <td><h5 class="f-weight-bold">Date Rejected/Canceled</h5></td>
                            </tr>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rejected_canceled_logs as $rejected_canceled_log)
                            <tr>
                                <td><h5>{{ $rejected_canceled_log->status }}</h5></td>
                                <td><h5>{{ $rejected_canceled_log->created_at->format('Y-m-d')}}</h5></td>
                                <td><h5>{{ $rejected_canceled_log->leave_type }}</h5></td>
                                <td><h5>{{ $rejected_canceled_log->leave_from }}</h5></td>
                                <td><h5>{{ $rejected_canceled_log->duration }}</h5></td>
                                <td><h5>{{ $rejected_canceled_log->reason }}</h5></td>
                                <td><h5>{{ $rejected_canceled_log->rejected_at ?? $rejected_canceled_log->cancelled_at}}</h5></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
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
            $('.add-leave-form').show();
        })

        $('#btn-close').on('click', function(){
            $('.add-leave-form').hide();
        })
        $('#btn-close-edit').on('click', function(){
            $('.edit-leave-form').hide();
            })

        $('.btn-edit').click(function(e){
            e.preventDefault();
            const entryId = $(this).data('entry-id');
            const url = $(this).attr('href');
            let editUrl = "{{ route('editLeave', 'entryId') }}";
            const newUrl = editUrl.replace('entryId', entryId);
            $.ajax({
                url: newUrl,   
                    dataType: 'json',
                    type: 'GET',
                    success: function(response) {
                        $('#edit_leave_type').val(response.leave_type);
                        $('#edit_duration').val(response.duration);
                        $('#edit_leave_from').val(response.leave_from);
                        $('#edit_reason').val(response.reason);
                        $('#blc').text(response.sick_credit);
                        $('#vlc').text(response.vacation_credit);
                        $('.edit-leave-form').show(); 
                        $('form').attr('action', '/my_leaves/' + response.id + '/update');
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
            let editUrl = "{{ route('deleteLeave', 'entryId') }}";
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
                                'The Leave request has been canceled.',
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