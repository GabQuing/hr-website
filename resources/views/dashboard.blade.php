@extends('layouts.side_top_content', ['title' => 'Dashboard'])

@section('module_name', 'Dashboard')

@section('content')
<style>
textarea {
    resize: none; 
}
.modal-box{
        max-width: 75rem !important;
    }
.message_container{
    margin-top: 30px;
    padding: 0px 50px;
}


.text-red {
        color: red;
        font-weight: bold
    }
    .text-green {
        color: green;
        font-weight: bold

    }
.text-cetner{
    text-align: center;
}
.pad-left{
    padding-left: 1rem !important;
}
.blue-border{
    object-fit: contain;
    width: 80%;
    box-shadow: rgba(0, 0, 0, 0.15) 0px 2px 8px;
    margin-bottom: 20px;
}
.text-message{
    color: #333333;
    text-align: justify;
}
#ann_subject{
    margin-bottom: 10px;
    color: black;
}

.text-message-container{
    margin-bottom: 20px;
}

@media (max-width: 1492px) {
    .blue-border {
        width: 100%;
    }
    ..message_container{
        padding: 0px 30px;
    }
}

</style>
<div class="modal-center create-ann-form" style="display:none;">
    <div class="modal-box">
        <div class="modal-content">
            <form method="POST" action="{{ route('announcement.create') }}" autocomplete="off" enctype="multipart/form-data" id="announcementCreateForm">
                @csrf
                <table class="custom_normal_table">
                    <tbody>
                        <tr>
                            <td colspan="4">
                                <h3 class="f-weight-bold">Make Announcement</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Start Date:</p>
                                <input class="u-input" name="start_date" type="date" required>
                            </td>
                            <td>
                                <p>End Date:</p>
                                <input class="u-input" name="end_date" type="date" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Subject: <span style="font-size: 12px; color: rgb(69, 110, 159) !important;">*Optional</span></p>
                                <input class="u-input" name="subject" placeholder="Enter the subject of your message" type="text" >
                            </td>
                            <td>
                                <p>Insert Image: <span style="font-size: 12px; color: rgb(69, 110, 159) !important;">*Optional</span></p>
                                <input class="u-input" id="imageInput" name="imageInput" type="file" accept=".png, .jpg, .jpeg" >
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <p>Message: <span style="font-size: 12px; color: rgb(69, 110, 159) !important;">*Optional</span></p>
                                <div id="create-editor" class="u-input" name="message" ></div>
                                </div>
                                <input type="hidden" name="message" id="messageInputCreate">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="u-flex-space-between u-flex-wrap">
                    <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default" id="modal-btn-close" type="button">Close</button>
                    <button class="u-t-white u-fw-b u-btn u-bg-primary u-m-10 u-border-1-default" id="modal-btn-submit" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal-center edit-ann-form" style="display:none;">
    <div class="modal-box">
        <div class="modal-content">
            <form method="POST" action="{{ route('announcement.update') }}" autocomplete="off" enctype="multipart/form-data" id="announcementEditForm">
                @csrf
                <table class="custom_normal_table">
                    <tbody>
                        <tr>
                            <td colspan="4">
                                <h3 class="f-weight-bold">Edit Announcement</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Start Date:</p>
                                <input class="u-input" name="start_date" type="date" value="{{ $announcement?->start_date }}" required>
                            </td>
                            <td>
                                <p>End Date:</p>
                                <input class="u-input" name="end_date" type="date" value="{{ $announcement?->end_date }}" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Subject: <span style="font-size: 12px; color: rgb(69, 110, 159) !important;">*Optional</span></p>
                                <input class="u-input" name="subject" placeholder="Reminder:" type="text" value="{{ $announcement?->subject }}">
                            </td>
                            <td>
                                <p>Insert Image: <span style="font-size: 12px; color: rgb(69, 110, 159) !important;">*Optional</span></p>
                                <input class="u-input"  name="imageInput" type="file" accept=".png, .jpg, .jpeg" >
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <p>Message: <span style="font-size: 12px; color: rgb(69, 110, 159) !important;">*Optional</span></p>
                                <div id="edit-editor" class="u-input" name="message"></div>
                                </div>
                                <input type="hidden" name="message" id="messageInputEdit">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="u-flex-space-between u-flex-wrap">
                    <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default btn-close" id="btn-close-edit" type="button">Close</button>
                    <button class="u-t-white u-fw-b u-btn u-bg-primary u-m-10 u-border-1-default btn-close" id="btn-edit-submit" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="grid">
    <div class="container container_today">
        <div class="container_title">
            <p class="header_title_h2">Today's Attendance</p>
        </div>
        <div class="today_attendance">
            <div class="today_attendance flex-column">
                <div class="today_attendance_p">
                    <h4 class="f-weight-5 attendance_action">
                        @php
                            if ($today_log) {
                                if ($today_log->clock_out) {
                                    $label = 'CLOCK OUT';
                                    $log_time = $today_log->clock_out;
                                } else if ($today_log->clock_in) {
                                    $label = 'CLOCK IN';
                                    $log_time = $today_log->clock_in;
                                }
                                $text = "$label: $today_log->log_date ($log_time)";
                            }
                        @endphp
                        {{ $text ?? "Press Clock In To Start (00:00:00)" }}
                    </h4>
                </div>
                <div class="today_attendance_message">
                    <h5 class="f-weight-4"><strong>Clock in</strong> once per day and then <strong>clock out</strong>.</h5>
                </div>
                <div class="today_attendance_btns">
                    <button type="button" data-action="CLOCK IN" data-column="clock_in" id="clock-in" class="action-button-log clock_in_btn" {{ $today_log?->clock_in || $today_log?->clock_out || $is_rest_day ? 'disabled' : '' }}>
                        <div class="today_clock_in">
                            <span class="material-symbols-outlined" style="font-size: 25px;">schedule</span>
                            <span>Clock In</span>
                        </div>
                    </button>
                    <button type="button" data-action="CLOCK OUT" data-column="clock_out" id="clock-out" class="action-button-log clock_out_btn" {{ $today_log?->clock_out || !$today_log?->clock_in ? 'disabled' : '' }}>
                        <div class="today_clock_out" >
                            <span class="material-symbols-outlined" style="font-size: 25px;">schedule</span>
                            <p>Clock Out</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container container_my_attendance">
        <div class="container_title">
            <p class="header_title_h2">My Break</p>
        </div>
        <div class="my_break">
            <div class="my_break flex-column">
                <div class="my_break_p">
                    <h4 class="f-weight-5 break_action">
                        @php
                            $breakLabel = "";
                            if ($today_log && ($today_log->break_end || $today_log->break_start)){
                                if ($today_log->break_end){
                                    $breakLabel = "BREAK END";
                                    $breakLogTime = "$today_log->break_end";
                                } elseif ($today_log->break_start) {
                                    $breakLabel = "BREAK START";
                                    $breakLogTime = "$today_log->break_start";
                                }
                                $break = "$breakLabel: $today_log->log_date ($breakLogTime)";
                            }
                        @endphp
                        {{ $break ?? "Press Break Start (00:00:00)" }}
                    </h4>
                </div>
                <div class="my_break_message">
                    <h5 class="f-weight-4"><strong>Break start</strong> once per day and then <strong>break end</strong>.</h5>
                </div>
                <div class="my_break_btns">
                    <button type="button" data-action="BREAK START" data-column="break_start" id="break-start" class="action-button-log clock_in_btn" {{ !$today_log?->clock_in || $today_log?->break_start || $today_log?->clock_out ? 'disabled' : '' }}>
                        <div class="break_start_btn">
                            <span class="material-symbols-outlined"style="font-size: 25px;">local_cafe</span>
                            <span>Break Start</span>
                        </div>
                    </button>
                    <button type="button" data-action="BREAK END" data-column="break_end" id="break-end" class="action-button-log clock_out_btn" {{ !$today_log?->break_start || $today_log?->break_end || $today_log?->clock_out ? 'disabled' : '' }}>
                        <div class="break_end_btn" >
                            <span class="material-symbols-outlined"style="font-size: 25px;">local_cafe</span>
                            <p>Break End</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="container container_today">
        <div class="container_title">
            <p class="header_title_h2">My Activity</p>
        </div>
        <div class="dashboard_table ">
            <table class="myTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Date Access</th>
                        <th>Time Access</th>
                        <th>Log-Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user_logs as $user_log)
                        <tr>
                            <td>{{ date('M d Y', strtotime($user_log->log_date)) }}</td>
                            <td class="pad-left">{{ date('h:ia', strtotime($user_log->log_time)) }}</td>
                            <td>{{ $user_log->log_type_description }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="container container_today">
        <div class="container_title">
            <p class="header_title_h2">Team Attendance (Today)</p>
        </div>
        <div class="dashboard_table ">
            <table class="myTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Employee Name</th>
                        <th>Time-Access</th>
                        <th>Attendance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($team_logs as $team_log)
                        <tr>
                            <td>{{ $team_log->name }}</td>
                            <td class="pad-left"> 
                                {{ $team_log->log_time ? date('h:ia', strtotime($team_log->log_time)) : 'Not Available' }}
                            </td>
                            <td class="
                                {{ 
                                    !$team_log->description ? 'text-red' : 
                                    ($team_log->description === 'CLOCK IN' ? 'text-green' : 
                                    ($team_log->description === 'CLOCK OUT' ? 'text-red' : 
                                    ($team_log->description === 'BREAK START' ? 'text-red' : 
                                    ($team_log->description === 'BREAK END' ? 'text-green' : '')))
                                    )
                                }}"
                            >
                                {{ $team_log->description ? $team_log->description : 'NO LOGS' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="container container_today">
        <div class="container_title">
            <p class="header_title_h2">Announcement</p>
        </div>
        <div class="u-flex-center-column ">
            @if ($announcement)
            <div class=" message_container">
                @if ($announcement && $announcement->file_path)
                    <div style="text-align: center;">
                        <img class="blue-border" src="{{ $announcement->file_path }}" alt="" style=" ">
                    </div>
                @endif
                <h4 id="ann_subject" class="u-fw-500  u-t-center "><strong>{{ $announcement?->subject }}</strong></h4>
                <div class="text-message-container">
                    <span class=" text-message">{!!$announcement?->message !!}</span>
                </div>
            </div>
            @else
            <p class="text-center u-p-15 u-mt-25">No announcement for today.</p>
            @endif 
            @role('admin||hr')
            <div>
                <div class="today_attendance_btns u-p-10" style="display: flex; justify-content: center;">
                    @if ($announcement)
                    <button type="button" class="ann_btn edit-ann">
                        <div class="edit_ann_btn">
                            <span class="material-symbols-outlined" style="font-size: 25px;">edit_square</span>
                            <span>Edit</span>
                        </div>
                    </button>
                    <button type="button" class="ann_btn remove-ann">
                        <div class="remove_ann_btn" >
                            <span class="material-symbols-outlined">disabled_by_default</span>
                            <p>Remove</p>
                        </div>
                    </button>
                    @else
                    <button type="button" class="ann_btn create-ann">
                        <div class="announcement_btn" >
                            <span class="material-symbols-outlined">wysiwyg</span>
                            <p>Create</p>
                        </div>
                    </button>
                        @endif
                </div>
                @if (session('success'))
                    <h5 class="u-fw-b" style="color: green; display:block; margin-top: 15px;">{{ session('success') }}</h5>
                @endif
            </div>
            @endrole
        </div>
    </div>
</div>

@section('script_content')
<script>
    $(document).ready(function(){
        function showLogDetails(logDetails) {
            const Toast = Swal.mixin({
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                },
                customClass: {
                    popup: 'custom-swal'
                },
                iconColor: '#02718A'
            });
            Toast.fire({
                icon: "success",
                title: `Your log (${logDetails.log_type}) has been added to your today's log.`,
            });
        }
        const createAnnouncementEditor = new Quill('#create-editor', {theme: 'snow'});
        const editAnnouncementEditor = new Quill('#edit-editor', {theme: 'snow' });
        const htmlEditString = `{!! $announcement?->message !!}`;
        const delta = editAnnouncementEditor.clipboard.dangerouslyPasteHTML(htmlEditString);
        $('#announcementCreateForm').submit(function(e) {
            e.preventDefault();
            const quillContent = createAnnouncementEditor.getSemanticHTML();
            $('#messageInputCreate').val(quillContent);
            this.submit();
        });

        $('#announcementEditForm').submit(function(e) {
            e.preventDefault();
            const quillContent = editAnnouncementEditor.getSemanticHTML();
            $('#messageInputEdit').val(quillContent);
            this.submit();
        });
        $('#announcementCreateForm').submit(function(e) {
            e.preventDefault();
            const quillContent = createAnnouncementEditor.getSemanticHTML();
            $('#messageInputCreate').val(quillContent);
            this.submit();
        });
        
        $('.myTable').DataTable({
            responsive: true,
            paging:false,
            info:false,
            searching: false,
            ordering: false,
        });
        
        $('#modal-btn-close').on('click', function(){
            $('.create-ann-form').hide();
        });
        $('#btn-close-edit').on('click', function(){
            $('.edit-ann-form').hide();
        });
        $('.edit-ann').on('click', function(){
            $('.edit-ann-form').show();
        });
        $('.create-ann').on('click', function(){
            $('.create-ann-form').show();
        });

        function refreshButtons(logToday) {
            // console.log(logToday);
            const clockIn = $('#clock-in');
            const clockOut = $('#clock-out');
            const breakStart = $('#break-start');
            const breakEnd = $('#break-end');

            clockIn.attr('disabled', logToday.clock_in || logToday.clock_out);
            clockOut.attr('disabled', logToday.clock_out || !logToday.clock_in);
            breakStart.attr('disabled', !logToday.clock_in || logToday.break_start || logToday.clock_out);
            breakEnd.attr('disabled', !logToday.break_start || logToday.break_end || logToday.clock_out);
        }
        
        function displayAction(logToday) {
            console.log(logToday);
            let selector = '';
            if (logToday.log_type === "CLOCK IN" || logToday.log_type === "CLOCK OUT") {
                selector = '.attendance_action';
            }
            if (logToday.log_type === "BREAK START" || logToday.log_type === "BREAK END") {
                selector = '.break_action';
            }
            $(selector).text(`${logToday.log_type || 'No Action Available'}: ${logToday.log_date || 'No Date Available'} (${logToday.log_time || 'No Time Available'})`);
        }
        

        $( ".container" ).first().show( "slow", function showNext() {
            $( this ).next( ".container" ).show( "slow", showNext );
        });

        $('.action-button-log').on('click', function() {
            if ($(this).attr('disabled')) return;
            $(this).attr('disabled', true);
            const userId = "{{ auth()->user()->id }}";
            const userSchedID = "{{ auth()->user()->schedule_types_id }}";
            const action = $(this).attr('data-action');
            $.ajax({
                url: "{{ route('dashboard.log-action') }}",
                method: 'POST',
                type: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    user_id: userId,
                    user_sched_id:userSchedID,
                    action,
                },
                success: function(data) {
                    showLogDetails(data.log_details);
                    refreshButtons(data.log_today);
                    displayAction(data.log_details);
                },
                error: function(error) {
                    const errorMessage = error.responseJSON.message;
                    alert(errorMessage);
                }
            })
        });

        $('.remove_ann_btn').click(function(e){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Remove It!'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.assign("{{ route('announcement.delete') }}");
                }
            });
        });

                
    });
</script>
@endsection
@endsection