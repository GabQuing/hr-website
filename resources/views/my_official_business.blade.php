@extends('layouts.side_top_content')

@section('module_name', 'My Official Business')

@section('content')

    <style>
        .modal-box{
            max-width: 75rem !important;
        }
    </style>

    <div class="modal-center add-ob-form" style="display: none;">
        <div class="modal-box">
            <div class="modal-content">
                <form method="POST" action="{{ route('submitOB') }}">
                    @csrf
                    <div style="overflow-x: auto; width: 100%;">
                        <table class="custom_normal_table">
                            <tbody>
                                <tr>
                                    <td colspan="4">
                                        <h3 class="f-weight-bold"><i class="fa-solid fa-eye"></i> Official Business Form</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Date From:</p>
                                        <input class="u-input" name="date_from" type="date" required>
                                    </td>                            
                                    <td>
                                        <p>Time From:</p>
                                        <input class="u-input" name="time_from" type="time" required>
                                    </td>                            
                                    <td>
                                        <p>Time To:</p>
                                        <input class="u-input" name="time_to" type="time" required>
                                    </td>                            
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <p>Location:</p>
                                        <input class="u-input-border-boottom" name="location" type="text" placeholder="Enter Location" required>
                                    </td>                            
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <p>Reason:</p>
                                        <input class="u-input-border-boottom" name="reason" type="text" placeholder="Enter Reason" required>
                                    </td>                            
                                </tr>
                                <tr>
                                    <td>
                                        <p>Alaska Current Date:</p>
                                        <span>{{ $serverCurrentDay }}, {{ $serverFormattedDate }}</span>
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

    <div class="modal-center edit-ob-form" id="edit-ob-form" style="display: none;">
        <div class="modal-box">
            <div class="modal-content">
                <form method="POST">
                    @csrf
                    <div style="overflow-x: auto; width: 100%;">
                        <table class="custom_normal_table">
                            <tbody>
                                <tr>
                                    <td colspan="4">
                                        <h3 class="f-weight-bold"><i class="fa-solid fa-eye"></i>Edit Official Business Form</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Date From:</p>
                                        <input class="u-input" name="date_from" id="edit_date_from" type="date" required>
                                    </td>                           
                                    <td>
                                        <p>Time From:</p>
                                        <input class="u-input" name="time_from" id="edit_time_from" type="time" required>
                                    </td>                            
                                    <td>
                                        <p>Time To:</p>
                                        <input class="u-input" name="time_to" id="edit_time_to" type="time" required>
                                    </td>                            
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <p>Location:</p>
                                        <input class="u-input-border-boottom" name="location" id="edit_location" type="text" placeholder="Enter Location" required>
                                    </td>                            
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <p>Reason:</p>
                                        <input class="u-input-border-boottom" name="reason" id="edit_reason" type="text" placeholder="Enter Reason" required>
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
                <h4 class="u-t-center u-t-white u-fw-b">My Official Business</h4>
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
                                        Add OB
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
                            <td><h5 class="u-fw-b">My Request - <span id="status-label">Pending</span></h5></td>
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
                            <td><h5 class="f-weight-bold">Date</h5></td>
                            <td><h5 class="f-weight-bold">Time From</h5></td>
                            <td><h5 class="f-weight-bold">Time To</h5></td>
                            <td><h5 class="f-weight-bold">Purpose</h5></td>
                            <td><h5 class="f-weight-bold">Actions</h5></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pending_logs as $pending_log)
                            <tr>
                                <td><h5>{{ $pending_log->status }}</h5></td>
                                <td><h5>{{ date('M d Y h:i a', strtotime($pending_log->created_at)) }}</h5></td>
                                <td><h5>{{ $pending_log->location }}</h5></td>
                                <td><h5>{{ date('F d Y', strtotime($pending_log->date_from)) }}</h5></td>
                                <td><h5>{{ date('g:ia', strtotime($pending_log->time_from)) }}</h5></td>
                                <td><h5>{{ date('g:ia', strtotime($pending_log->time_to))  }}</h5></td>
                                <td><h5>{{ $pending_log->reason }}</h5></td>
                                <td>
                                    <div class="d-flex;">
                                        <button type="button" class="u-action-btn u-bg-primary btn-edit" data-entry-id="{{ $pending_log->id }}" data-href="{{ route('editInfo', $pending_log->id) }}">
                                            <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 20px; font-weight: bold;">
                                                edit
                                            </span>
                                        </button>
                                        <button type="button" class="u-action-btn u-bg-danger btn-cancel" data-entry-id="{{ $pending_log->id }}" data-href="{{ route('deleteOB', $pending_log->id) }}" >
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
                            <td><h5 class="f-weight-bold">Location</h5></td>
                            <td><h5 class="f-weight-bold">Date</h5></td>
                            <td><h5 class="f-weight-bold">Time From</h5></td>
                            <td><h5 class="f-weight-bold">Time To</h5></td>
                            <td><h5 class="f-weight-bold">Purpose</h5></td>
                            <td><h5 class="f-weight-bold">Date Approved</h5></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($approved_logs as $approved_log)
                            <tr>
                                <td><h5>{{ $approved_log->status }}</h5></td>
                                <td><h5>{{ date('M d Y h:i a', strtotime($approved_log->created_at)) }}</h5></td>
                                <td><h5>{{ $approved_log->location }}</h5></td>
                                <td><h5>{{ date('F d Y', strtotime($approved_log->date_from ))}}</h5></td>
                                <td><h5>{{ date('g:ia', strtotime($approved_log->time_from)) }}</h5></td>
                                <td><h5>{{ date('g:ia', strtotime($approved_log->time_to)) }}</h5></td>
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
                            <td><h5 class="f-weight-bold">Location</h5></td>
                            <td><h5 class="f-weight-bold">Date</h5></td>
                            <td><h5 class="f-weight-bold">Time From</h5></td>
                            <td><h5 class="f-weight-bold">Time To</h5></td>
                            <td><h5 class="f-weight-bold">Purpose</h5></td>
                            <td><h5 class="f-weight-bold">Date Rejected/Canceled</h5></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rejected_canceled_logs as $rejected_canceled_log)
                            <tr>
                                <td><h5>{{ $rejected_canceled_log->status }}</h5></td>
                                <td><h5>{{ date('M d Y h:i a', strtotime($rejected_canceled_log->created_at))}}</h5></td>
                                <td><h5>{{ $rejected_canceled_log->location }}</h5></td>
                                <td><h5>{{ date('F d Y', strtotime($rejected_canceled_log->date_from ))}}</h5></td>
                                <td><h5>{{ date('g:ia', strtotime($rejected_canceled_log->time_from)) }}</h5></td>
                                <td><h5>{{ date('g:ia', strtotime($rejected_canceled_log->time_to)) }}</h5></td>
                                <td><h5>{{ $rejected_canceled_log->reason }}</h5></td>
                                <td><h5>{{ date('M d Y h:i a', strtotime($rejected_canceled_log->rejected_at) ?: strtotime($rejected_canceled_log->cancelled_at)) }}</h5></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>
    </div>

@section('script_content')
    <script>

        $('.my_official_business_content').fadeIn('slow');

        $('.mob-approve-table').hide();
        $('.mob-rejected-table').hide();

        $('#mob-pending').on('click', function(){
            hideTable($(this), 'Pending');
            $('.mob-pending-table').show();
            $('#status-label').text('Pending');
        })

        $('#mob-approve').on('click', function(){
            hideTable($(this), 'Approved');
            $('.mob-approve-table').show();
            $('#status-label').text('Approved');
        })

        $('#mob-rejected').on('click', function(){
            hideTable($(this), 'Rejected');
            $('.mob-rejected-table').show();
            $('#status-label').text('Rejected/Canceled');
        })

        $('#my_official_business_add').on('click', function(){
            $('.add-ob-form').show();
        })

        $('#btn-close').on('click', function(){
            $('.add-ob-form').hide();
        })
        $('#btn-close-edit').on('click', function(){
            $('.edit-ob-form').hide();
        })

        $('')

        $('.btn-edit').click(function(e) {
            e.preventDefault();
            const entryId = $(this).data('entry-id');
            const url = $(this).attr('href');
            let editUrl = "{{ route('editInfo', 'entryId') }}";
            const newUrl = editUrl.replace('entryId', entryId);
            console.log(newUrl);
            $.ajax({
            url: newUrl,   
            dataType: 'json',
            type: 'GET',
                success: function(response) {
                    let submitUrl = "{{ route('my_official_business.update', 'entryId') }}";
                    submitUrl = submitUrl.replace('entryId', response.id);
                    $('#edit_date_from').val(response.date_from);
                    $('#edit_time_from').val(response.time_from);
                    $('#edit_time_to').val(response.time_to);
                    $('#edit_location').val(response.location);
                    $('#edit_reason').val(response.reason);
                    $('.edit-ob-form').show(); // Show the modal
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
            let editUrl = "{{ route('deleteOB', 'entryId') }}";
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
                                'The OB request has been canceled.',
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