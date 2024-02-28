@extends('layouts.side_top_content')

@section('module_name', 'Official Business')

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
                                        <p>Date To:</p>
                                        <input class="u-input" name="date_to" type="date" required>
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
                                        <p>Date To:</p>
                                        <input class="u-input" name="date_to" id="edit_date_to" type="date" required>
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

    <div class="my_official_business_content" style="display: none">
        <div class="my_official_business_main_content u-bg-white">
            <div class="my_official_business_header">
                <p class="header_title_h2">My Official Businesses</p>
            </div>
            <div class="my_official_businesses u-m-15">
                <div style="display: flex; flex-wrap: wrap;">
                    <h5 class="my_official_businesses_header my_official_businesses_header_active" id="mob-pending">Pending/Resubmit for editing</h5>
                    <h5 class="my_official_businesses_header" id="mob-approve">Approved</h5>
                    <h5 class="my_official_businesses_header" id="mob-rejected">Rejected/Canceled</h5>
                </div>
                <button  class="u-btn u-bg-accent u-t-white" style="display: block; margin-top: 12px;" id="my_official_business_add" type="button">
                    <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 16px; font-weight: bold;">
                        add
                    </span>
                    Add OB
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
                            <td><h6 class="f-weight-bold">Location</h6></td>
                            <td><h6 class="f-weight-bold">Date From</h6></td>
                            <td><h6 class="f-weight-bold">Date To</h6></td>
                            <td><h6 class="f-weight-bold">Time From</h6></td>
                            <td><h6 class="f-weight-bold">Time To</h6></td>
                            <td><h6 class="f-weight-bold">Purpose</h6></td>
                            <td><h6 class="f-weight-bold">Actions</h6></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pending_logs as $pending_log)
                            <tr>
                                <td><h6>{{ $pending_log->status }}</h6></td>
                                <td><h6>{{ $pending_log->created_at }}</h6></td>
                                <td><h6>{{ $pending_log->location }}</h6></td>
                                <td><h6>{{ $pending_log->date_from }}</h6></td>
                                <td><h6>{{ $pending_log->date_to }}</h6></td>
                                <td><h6>{{ $pending_log->time_from }}</h6></td>
                                <td><h6>{{ $pending_log->time_to }}</h6></td>
                                <td><h6>{{ $pending_log->reason }}</h6></td>
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
            <div class="mob-approve-table u-m-15" style="overflow-x: auto; border-radius: 0.5rem;">
                <table class="u-responsive-table">
                    <thead>
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
                    </thead>
                    <tbody>
                        @foreach ($approved_logs as $approved_log)
                            <tr>
                                <td><h6>{{ $approved_log->status }}</h6></td>
                                <td><h6>{{ $approved_log->created_at }}</h6></td>
                                <td><h6>{{ $approved_log->location }}</h6></td>
                                <td><h6>{{ $approved_log->date_from }}</h6></td>
                                <td><h6>{{ $approved_log->date_to }}</h6></td>
                                <td><h6>{{ $approved_log->time_from }}</h6></td>
                                <td><h6>{{ $approved_log->time_to }}</h6></td>
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
                            <td><h6 class="f-weight-bold">Location</h6></td>
                            <td><h6 class="f-weight-bold">Date From</h6></td>
                            <td><h6 class="f-weight-bold">Date To</h6></td>
                            <td><h6 class="f-weight-bold">Time From</h6></td>
                            <td><h6 class="f-weight-bold">Time To</h6></td>
                            <td><h6 class="f-weight-bold">Purpose</h6></td>
                            <td><h6 class="f-weight-bold">Date Rejected/Canceled</h6></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rejected_canceled_logs as $rejected_canceled_log)
                            <tr>
                                <td><h6>{{ $rejected_canceled_log->status }}</h6></td>
                                <td><h6>{{ $rejected_canceled_log->created_at }}</h6></td>
                                <td><h6>{{ $rejected_canceled_log->location }}</h6></td>
                                <td><h6>{{ $rejected_canceled_log->date_from }}</h6></td>
                                <td><h6>{{ $rejected_canceled_log->date_to }}</h6></td>
                                <td><h6>{{ $rejected_canceled_log->time_from }}</h6></td>
                                <td><h6>{{ $rejected_canceled_log->time_to }}</h6></td>
                                <td><h6>{{ $rejected_canceled_log->reason }}</h6></td>
                                <td><h6>{{ $rejected_canceled_log->rejected_at ?? $rejected_canceled_log->cancelled_at }}</h6></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div style="clear: both;"></div>

@section('script_content')
    <script>

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
                    $('#edit_date_from').val(response.date_from);
                    $('#edit_date_to').val(response.date_to);
                    $('#edit_time_from').val(response.time_from);
                    $('#edit_time_to').val(response.time_to);
                    $('#edit_location').val(response.location);
                    $('#edit_reason').val(response.reason);
                    $('.edit-ob-form').show(); // Show the modal
                    $('form').attr('action', '/my_official_business/' + response.id + '/update');
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