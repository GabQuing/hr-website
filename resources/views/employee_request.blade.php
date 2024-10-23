@extends('layouts.side_top_content' , ['title' => 'Employee Request'])

@section('module_name', 'Employee Request')

@section('content')
    <style>
        .modal-box{
            max-width: 75rem !important;
        }
    </style>

    <div>
        {{-- Modals --}}
        <div class="modal-center" id="official-business-modal" style="display: none;">
            <div class="modal-box">
                <div class="modal-content">
                    <form method="POST" action="{{ route('obForm') }}">
                        @csrf
                        <input type="hidden" name="ob_id">
                        <input type="hidden" name="ob_form_btn"> 
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
                                            <input class="u-input" name="ob_date_from" type="date" readonly>
                                        </td>
                                        <td>
                                            <p>Time From:</p>
                                            <input class="u-input" name="ob_time_from" type="time" readonly>
                                        </td>                            
                                        <td>
                                            <p>Time To:</p>
                                            <input class="u-input" name="ob_time_to" type="time" readonly>
                                        </td>                            
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <p>Location:</p>
                                            <input class="u-input-border-boottom" name="ob_location" type="text" placeholder="Enter Location" readonly>
                                        </td>                            
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <p>Reason:</p>
                                            <input class="u-input-border-boottom" name="ob_reason" type="text" placeholder="Enter Reason" readonly>
                                        </td>                            
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="u-flex-space-between u-flex-wrap">
                            <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default btn-close" id="ob-btn-close" type="button">Close</button>
                            <div class="u-flex-space-between">
                                <button class="ob-btns u-t-white u-fw-b u-btn u-bg-danger u-m-5 u-border-1-default" type="submit">Reject</button>
                                <button class="ob-btns u-t-white u-fw-b u-btn u-bg-accent u-m-5 u-border-1-default" type="submit">Approve</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal-center" id="overtime-modal" style="display: none;">
            <div class="modal-box">
                <div class="modal-content">
                    <form method="POST" action="{{ route('otForm') }}">
                        @csrf
                        <input type="hidden" name="ot_id">
                        <input type="hidden" name="ot_form_btn"> 
                        <div style="overflow-x: auto; width: 100%;">
                            <table class="custom_normal_table">
                                <tbody>
                                    <tr>
                                        <td colspan="4">
                                            <h3 class="f-weight-bold"><i class="fa-solid fa-eye"></i> Overtime Application Form</h3>
                                        </td>
                                    </tr>
                                    {{-- <tr>
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
                                    </tr> --}}
                                    <tr>
                                        <td>
                                            <p>Day:</p>
                                            <input class="u-input-border-boottom" name="ot_day" type="text" placeholder="Day..." readonly>
                                        </td>
                                        <td>
                                            <p>Shift Date:</p>
                                            <input class="u-input-border-boottom" name="ot_shift_date" type="date" readonly>
                                        </td>
                                        <td>
                                            <p>Shift From:</p>
                                            <input class="u-input-border-boottom" name="ot_shift_from" type="time" readonly>
                                        </td>
                                        <td>
                                            <p>To:</p>
                                            <input class="u-input-border-boottom" name="ot_shift_to" type="time" readonly>
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
                                            <select class="u-input" name="ot_classification" disabled>
                                                <option value="Normal OT">Normal OT</option>
                                                <option value="Rest Day OT">Rest Day OT</option>
                                                <option value="Holiday OT">Holiday OT</option>
                                            </select>
                                        </td> 
                                        <td>
                                            <p>Start:</p>
                                            <input class="u-input" name="ot_time_from" type="time" placeholder="Enter Location" disabled>
                                        </td>                           
                                        <td>
                                            <p>End:</p>
                                            <input class="u-input" name="ot_time_to" type="time" placeholder="Enter Location" disabled>
                                        </td>                           
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <p>Indicate Ticket Number (If Applicable) and Reason</p>
                                            <input class="u-input-border-boottom" name="ot_reason" type="text" placeholder="Enter Reason" disabled>
                                        </td>                            
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="u-flex-space-between">
                            <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default btn-close" id="ot-btn-close" type="button">Close</button>
                            <div class="u-flex-space-between">
                                <button class="ot-btns u-t-white u-fw-b u-btn u-bg-danger u-m-5 u-border-1-default"  type="ot-btns submit">Reject</button>
                                <button class="ot-btns u-t-white u-fw-b u-btn u-bg-accent u-m-5 u-border-1-default"  type="submit">Approve</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal-center" id="leave-modal" style="display: none;">
            <div class="modal-box">
                <div class="modal-content">
                    <form method="POST" action="{{ route('leaveForm') }}">
                        @csrf
                        <input type="hidden" name="leave_id">
                        <input type="hidden" name="leave_form_btn"> 
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
                                        <select class="u-input" name="leave_type" id="" disabled>
                                            <option value="" selected disabled>None selected</option>
                                            <option value="BIRTHDAY">BIRTHDAY</option>
                                            <option value="VACATION">VACATION</option>
                                        </select>
                                    </td>        
                                    <td>
                                        <p>Duration:</p>
                                        <select class="u-input" name="leave_duration" id="" disabled>
                                            <option value="" selected disabled>None selected</option>
                                            <option value="WHOLEDAY">WHOLEDAY</option>
                                            <option value="HALFDAY">HALFDAY</option>
                                        </select>
                                    </td>        
                                </tr>
                                <tr>                   
                                    <td>
                                        <p>From:</p>
                                        <input class="u-input" name="leave_from" type="date" disabled>
                                    </td>                           
                                </tr>
                                <tr>
                                    <td>
                                        <p>Birthday : Default Birthday leave policy</p>
                                        <span id="blc"></span>
                                    </td>
                                    <td>
                                        <p>Vacation : Default Vacation leave policy</p>
                                        <span id="vlc"></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <p>Reason</p>
                                        <input class="u-input-border-boottom" name="leave_reason" type="text" placeholder="Enter Reason" disabled>
                                    </td>                            
                                </tr>
                        </table>
                        </div>
                        <div class="u-flex-space-between">
                            <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default btn-close" id="ot-btn-close" type="button">Close</button>
                            <div class="u-flex-space-between">
                                <button class="ot-btns u-t-white u-fw-b u-btn u-bg-danger u-m-5 u-border-1-default"  type="ot-btns submit">Rejected</button>
                                <button class="ot-btns u-t-white u-fw-b u-btn u-bg-accent u-m-5 u-border-1-default"  type="submit">Approve</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        

        <div class="u-flex">
            <div class="u-mr-16" style="position: relative" id="official_business-btn">
                <button class="u-btn u-bg-default u-t-dark u-border-1-gray u-box-shadow-default" href="">Official Business</button>
                @if ($pending_ob)
                    <div class="u-record u-t-white">
                        <span style="position: relative; top: -1px;">
                            {{ $pending_ob }}
                        </span>
                    </div>
                @endif
            </div>
            
            <div class="u-mr-16" style="position: relative" id="overtimes-btn">
                <button class="u-btn u-bg-default u-t-dark u-border-1-gray u-box-shadow-default" href="">Overtimes</button>
                @if ($pending_ot)
                    <div class="u-record u-t-white">
                        <span style="position: relative; top: -1px;">
                            {{ $pending_ot }}
                        </span>
                    </div>
                @endif
            </div>
            <div class="u-mr-16" style="position: relative" id="leaves-btn">
                <button class="u-btn u-bg-default u-t-dark u-border-1-gray u-box-shadow-default" href="">Leaves</button>
                @if ($pending_leaves)
                    <div class="u-record u-t-white">
                        <span style="position: relative; top: -1px;">
                            {{ $pending_leaves }}
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <div class="u-mt-10 u-mb-10 u-t-success">
            @if(session('ob-success'))
                <h5>{{ session('ob-success') }}</h5>
            @endif
            @if(session('ot-success'))
                <h5>{{ session('ot-success') }}</h5>
            @endif
            @if(session('ot-failed'))
                <h5>{{ session('ot-failed') }}</h5>
            @endif
        </div>

        <div class="official-business-table" style="display: none;">
            <div class="u-mt-10">
                <table class="myTable" class="display" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Date Filed</th>
                            <th>Location</th>
                            <th>Date From</th>
                            <th>Time From</th>
                            <th>Time To</th>
                            <th>Purpose</th>   
                            <th>Requested By</th>   
                            <th>Actions</th>         
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($official_businesses))
                            @foreach ($official_businesses as $official_business)
                                @php
                                    if ($official_business->status == 'PENDING') $status_class = 'u-t-warning';
                                    else if ($official_business->status == 'APPROVED') $status_class = 'u-t-success';
                                    else if ($official_business->status == 'REJECTED') $status_class = 'u-t-danger';
                                    else if ($official_business->status == 'CANCELLED') $status_class = 'u-t-danger';
                                    else if ($official_business->status == 'CANCELED') $status_class = 'u-t-danger';
                                @endphp
                                <tr>
                                    <td class="{{ $status_class }} u-fw-b">{{ $official_business->status }}</td>
                                    <td>{{ date('M d Y h:i a', strtotime($official_business->created_at)) }}</td>
                                    <td>{{ $official_business->location }}</td>
                                    <td>{{ date('F d Y', strtotime($official_business->date_from)) }}</td>
                                    <td>{{ date('g:ia', strtotime($official_business->time_from))}}</td>
                                    <td>{{ date('g:ia', strtotime($official_business->time_to))}}</td>
                                    <td>{{ $official_business->reason }}</td>
                                    <td>{{ $official_business->name }}</td>
                                    <td>
                                        @if ($official_business->status == 'PENDING')
                                        <div class="d-flex;">
                                            <button class="ob-btn u-action-btn u-bg-primary" type="button" ob-id="{{ $official_business->id }}">
                                                <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 20px; font-weight: bold;">
                                                    edit
                                                </span>
                                            </button>
                                        </div>
                                        @endif
                                    </td>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Status</th>
                            <th>Date Filed</th>
                            <th>Location</th>
                            <th>Date From</th>
                            <th>Time From</th>
                            <th>Time To</th>
                            <th>Purpose</th>   
                            <th>Requested By</th>      
                            <th>Actions</th>      
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="overtimes-table" style="display: none;">
            <div class="u-mt-10">
                <table class="myTable" class="display" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Date Request</th>
                            <th>Day</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>OT Minutes</th>   
                            <th>Requested By</th>
                            <th>Date Filed</th>
                            <th>Actions</th>         
                        </tr>
                    </thead>
                    <tbody>
                    @if (!empty($overtimes))
                        @foreach ($overtimes as $overtime)
                            @php
                                if ($overtime->status == 'PENDING') $status_class = 'u-t-warning';
                                else if ($overtime->status == 'APPROVED') $status_class = 'u-t-success';
                                else if ($overtime->status == 'REJECTED') $status_class = 'u-t-danger';
                                else if ($overtime->status == 'CANCELLED') $status_class = 'u-t-danger';
                                else if ($overtime->status == 'CANCELED') $status_class = 'u-t-danger';

                            @endphp
                            <tr>
                                <td class="{{ $status_class }} u-fw-b">{{ $overtime->status }}</td>
                                <td>{{date('F d Y', strtotime($overtime->shift_date)) }}</td>
                                <td>{{$overtime->day_name}}</td>
                                {{-- <td>{{ date('l', strtotime($overtime->shift_date)) }}</td> --}}
                                <td>{{ date('g:ia', strtotime($overtime->time_start)) }}</td>
                                <td>{{ date('g:ia', strtotime($overtime->time_end)) }}</td>
                                <td>
                                    <?php
                                        // Calculate the time difference
                                        $start = new DateTime($overtime->time_start);
                                        $end = new DateTime($overtime->time_end);
                                        $interval = $start->diff($end);
                                        $hours = $interval->h;
                                        $minutes = $interval->i;
                                        if ($hours > 0) {
                                            echo $hours . " hr and ";
                                        }
                                        
                                        echo $minutes . " minutes";
                                    ?>
                                </td>
                                <td>{{ $overtime->name }}</td>
                                <td>{{ date('M d Y h:i a', strtotime($overtime->created_at)) }}</td>
                                <td>
                                    @if ($overtime->status == 'PENDING')
                                    <div class="d-flex;">
                                        <button class="ot-btn u-action-btn u-bg-primary" type="button" ot-id="{{ $overtime->id }}">
                                            <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 20px; font-weight: bold;">
                                                edit
                                            </span>
                                        </button>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    <tfoot>
                        <tr>
                            <th>Status</th>
                            <th>Date Request</th>
                            <th>Day</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>OT Minutes</th>   
                            <th>Requested By</th>   
                            <th>Date Filed</th>
                            <th>Actions</th>    
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="leaves-table" style="display: none;">
            <div class="u-mt-10">
                <table class="myTable" class="display" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Date Filed</th>
                            <th>Leave Type</th>
                            <th>Duration</th>
                            <th>Leave From</th>
                            <th>Purpose</th>   
                            <th>Requested By</th>   
                            <th>Actions</th>         
                        </tr>
                    </thead>
                    <tbody>
                    @if (!empty($leaves))
                        @foreach ($leaves as $leave)
                        @php
                            if ($leave->status == 'PENDING') $status_class = 'u-t-warning';
                            else if ($leave->status == 'APPROVED') $status_class = 'u-t-success';
                            else if ($leave->status == 'REJECTED') $status_class = 'u-t-danger';
                            else if ($leave->status == 'CANCELLED') $status_class = 'u-t-danger';
                            else if ($leave->status == 'CANCELED') $status_class = 'u-t-danger';
                        @endphp
                            <tr>
                                <td class="{{ $status_class }} u-fw-b">{{ $leave->status }}</td>
                                <td>{{ date('M d Y h:i a', strtotime($leave->created_at)) }}</td>
                                <td>{{ $leave->leave_type}}</td>
                                <td>{{ $leave->duration }}</td>
                                <td>{{ date('F d Y', strtotime($leave->leave_from))}}</td>
                                <td>{{ $leave->reason }}</td>  
                                <td>{{ $leave->name }}</td>
                                <td>
                                    @if ($leave->status == 'PENDING')
                                    <div class="d-flex;">
                                        <button class="leave-btn u-action-btn u-bg-primary" type="button" leave-id="{{ $leave->id }}">
                                            <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 20px; font-weight: bold;">
                                                edit
                                            </span>
                                        </button>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    <tfoot>
                        <tr>
                            <th>Status</th>
                            <th>Date Filed</th>
                            <th>Leave Type</th>
                            <th>Leave From</th>
                            <th>Duration</th>
                            <th>Purpose</th>   
                            <th>Requested By</th>   
                            <th>Actions</th>  
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('script_content')
<script>
    $(document).ready(function(){

        $('.btn-close').on('click', function(){
            $('.modal-center').hide();
        })

        $('#official_business-btn').on('click', function(){
            removeBtnClassActive();
            hideTables();
            $(this).find('button').addClass('u-btn-active');
            $('.official-business-table').fadeIn('slow');
        });

        $('#overtimes-btn').on('click', function(){
            removeBtnClassActive();
            hideTables();
            $(this).find('button').addClass('u-btn-active');
            $('.overtimes-table').fadeIn('slow');
        })

        $('#leaves-btn').on('click', function(){
            removeBtnClassActive();
            hideTables();
            $(this).find('button').addClass('u-btn-active');
            $('.leaves-table').fadeIn('slow');
        })


        $(document).on('click','.ob-btn', function(){
            $('#official-business-modal').show();
            
            let obId = $(this).attr('ob-id');
            let url = "{{ route('obd', ':obId') }}";
            url = url.replace(':obId', obId);
            
            $.ajax({
                url: url, 
                dataType: 'json',
                type: 'GET',
                success: function(response){
                    $('input[name="ob_id"]').val(response.id);
                    $('input[name="ob_date_from"]').val(response.date_from);
                    $('input[name="ob_date_to"]').val(response.date_to);
                    $('input[name="ob_time_from"]').val(response.time_from);
                    $('input[name="ob_time_to"]').val(response.time_to);
                    $('input[name="ob_location"]').val(response.location);
                    $('input[name="ob_reason"]').val(response.reason);
                },
                error: function(error){
                    console.log(error)
                }
            })
        })

        $(document).on('click', '.leave-btn', function(){
            $('#leave-modal').show();
            
            let leaveId = $(this).attr('leave-id');
            let url = "{{ route('leaved', ':leaveId') }}";
            url = url.replace(':leaveId', leaveId);

            console.log(url);
            
            $.ajax({
                url: url, 
                dataType: 'json',
                type: 'GET',
                success: function(response){
                    console.log(response);
                    $('input[name="leave_id"]').val(response.id);
                    $('select[name="leave_type"]').val(response.leave_type);
                    $('select[name="leave_duration"]').val(response.duration);
                    $('input[name="leave_from"]').val(response.leave_from);
                    $('input[name="leave_reason"]').val(response.reason);
                    $('#blc').text(response.sick_credit);
                    $('#vlc').text(response.vacation_credit);
                },
                error: function(error){
                    console.log(error)
                }
            })
        })

        $(document).on('click', '.ot-btn', function(){
            $('#overtime-modal').show();
            
            let otId = $(this).attr('ot-id');
            let url = "{{ route('otd', ':otId') }}";
            url = url.replace(':otId', otId);
            
            $.ajax({
                url: url, 
                dataType: 'json',
                type: 'GET',
                success: function(response){
                    console.log(response);
                    $('input[name="ot_id"]').val(response.id);
                    $('input[name="ot_day"]').val(new Date(response.shift_date).toLocaleDateString('en-US', { weekday: 'long' }));
                    $('input[name="ot_shift_date"]').val(response.shift_date);
                    $('input[name="ot_shift_from"]').val(response.shift_from);
                    $('input[name="ot_shift_to"]').val(response.shift_to);
                    $('input[name="ot_time_from"]').val(response.time_start);
                    $('input[name="ot_time_to"]').val(response.time_end);
                    $('input[name="ot_reason"]').val(response.reason);
                    $('select[name="ot_classification"]').val(response.ot_classification);
                },
                error: function(error){
                    console.log(error)
                }
            })
        })

        $('.ob-btns').on('click', (event) => {
            $('input[name="ob_form_btn"]').val($(event.target).text().toLowerCase());
        });

        $('.ot-btns').on('click', (event) => {
            $('input[name="ot_form_btn"]').val($(event.target).text().toLowerCase());
        });

        $('.ot-btns').on('click', (event) => {
            $('input[name="leave_form_btn"]').val($(event.target).text().toLowerCase());
        });

        // session success
        if ("{{ session('ob-success') }}"){
            $('.official-business-table').fadeIn('slow');
        }else if ("{{ session('ot-success') }}"){
            $('.overtimes-table').fadeIn('slow');
        }


        function removeBtnClassActive(){
            $('.u-btn-active').removeClass('u-btn-active');
        }

        function hideTables(){
            $('.official-business-table').hide();
            $('.overtimes-table').hide();
            $('.leaves-table').hide();
        }
        $('#official_business-btn').click();
        
    });

    // DataTable 
    $('.myTable').DataTable({
        responsive: true,
        order: [],
        "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ]
    });
</script>
@endsection