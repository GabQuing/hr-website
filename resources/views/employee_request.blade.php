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
                                            <input class="u-input" name="ob_date_from" type="date" disabled>
                                        </td>
                                        <td>
                                            <p>Date To:</p>
                                            <input class="u-input" name="ob_date_to" type="date" disabled>
                                        </td>                            
                                        <td>
                                            <p>Time From:</p>
                                            <input class="u-input" name="ob_time_from" type="time" disabled>
                                        </td>                            
                                        <td>
                                            <p>Time To:</p>
                                            <input class="u-input" name="ob_time_to" type="time" disabled>
                                        </td>                            
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <p>Location:</p>
                                            <input class="u-input-border-boottom" name="ob_location" type="text" placeholder="Enter Location" disabled>
                                        </td>                            
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <p>Reason:</p>
                                            <input class="u-input-border-boottom" name="ob_reason" type="text" placeholder="Enter Reason" disabled>
                                        </td>                            
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="u-flex-space-between u-flex-wrap">
                            <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default btn-close" id="ob-btn-close" type="button">Close</button>
                            <div class="u-flex-space-between">
                                <button class="u-t-white u-fw-b u-btn u-bg-danger u-m-5 u-border-1-default"  type="submit">Rejected</button>
                                <button class="u-t-white u-fw-b u-btn u-bg-accent u-m-5 u-border-1-default"  type="submit">Approve</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal-center" id="overtime-modal" style="display: none;">
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
                                            <select class="u-input" name="ot_classification" disabled>
                                                <option value="">Normal OT</option>
                                                <option value="">Early OT</option>
                                            </select>
                                        </td> 
                                        <td>
                                            <p>Start:</p>
                                            <input class="u-input" name="start_date" type="date" placeholder="Enter Location" disabled>
                                        </td>                           
                                        <td>
                                            <p>End:</p>
                                            <input class="u-input" name="end_date" type="date" placeholder="Enter Location" disabled>
                                        </td>                           
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <p>Indicate Ticket Number (If Applicable) and Reason</p>
                                            <input class="u-input-border-boottom" name="reason" type="text" placeholder="Enter Reason" disabled>
                                        </td>                            
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="u-flex-space-between">
                            <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default btn-close" id="ot-btn-close" type="button">Close</button>
                            <div class="u-flex-space-between">
                                <button class="u-t-white u-fw-b u-btn u-bg-danger u-m-5 u-border-1-default"  type="submit">Rejected</button>
                                <button class="u-t-white u-fw-b u-btn u-bg-accent u-m-5 u-border-1-default"  type="submit">Approve</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        

        <div class="u-flex">
            <div class="u-mr-16" style="position: relative" id="official_business-btn">
                <button class="u-btn u-bg-default u-t-dark u-border-1-gray u-box-shadow-default" href="">Official Business</button>
                @if (count($official_businesses) > 0)
                    <div class="u-record u-t-white">
                        <span style="position: relative; top: -1px;">
                            {{ count($official_businesses) }}
                        </span>
                    </div>
                @endif
            </div>
            
            <div class="u-mr-16" style="position: relative" id="overtimes-btn">
                <button class="u-btn u-bg-default u-t-dark u-border-1-gray u-box-shadow-default" href="">Overtimes</button>
                @if (count($overtimes) > 0)
                    <div class="u-record u-t-white">
                        <span style="position: relative; top: -1px;">
                            {{ count($overtimes) }}
                        </span>
                    </div>
                @endif
            </div>
            <div class="u-mr-16" style="position: relative" id="leaves-btn">
                <button class="u-btn u-bg-default u-t-dark u-border-1-gray u-box-shadow-default" href="">Leaves</button>
                @if (count([]) > 0)
                    <div class="u-record u-t-white">
                        <span style="position: relative; top: -1px;">
                            {{ count($leaves) }}
                        </span>
                    </div>
                @endif
            </div>
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
                            <th>Date To</th>
                            <th>Time From</th>
                            <th>Time To</th>
                            <th>Purpose</th>   
                            <th>Actions</th>         
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($official_businesses))
                            @foreach ($official_businesses as $official_business)
                                <tr>
                                    <td>{{ $official_business->status }}</td>
                                    <td>{{ $official_business->created_at }}</td>
                                    <td>{{ $official_business->location }}</td>
                                    <td>{{ $official_business->date_from }}</td>
                                    <td>{{ $official_business->date_to }}</td>
                                    <td>{{ $official_business->time_from }}</td>
                                    <td>{{ $official_business->time_to }}</td>
                                    <td>{{ $official_business->reason }}</td>
                                    <td>
                                        <div class="d-flex;">
                                            <button class="ob-btn u-action-btn u-bg-primary" type="button" ob-id="{{ $official_business->id }}">
                                                <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 20px; font-weight: bold;">
                                                    edit
                                                </span>
                                            </button>
                                        </div>
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
                            <th>Date To</th>
                            <th>Time From</th>
                            <th>Time To</th>
                            <th>Purpose</th>   
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
                            <th>Date Filed</th>
                            <th>Day</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>OT Minutes</th>   
                            <th>Requested By</th>   
                            <th>Actions</th>         
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($overtimes))
                            @foreach ($overtimes as $overtime)
                                <tr>
                                    <td>{{ $overtime->status }}</td>
                                    <td>{{ $overtime->created_at }}</td>
                                    <td>{{ date('l', strtotime($overtime->shift_date)) }}</td>
                                    <td>{{ $overtime->start_date }}</td>
                                    <td>{{ $overtime->start_end }}</td>
                                    <td>50</td>
                                    <td>Patrick Punzalan</td>
                                    <td>
                                        <div class="d-flex;">
                                            <button class="ot-btn u-action-btn u-bg-primary" type="button" ot-id="{{ $overtime->id }}">
                                                <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 20px; font-weight: bold;">
                                                    edit
                                                </span>
                                            </button>
                                        </div>
                                    </td>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Status</th>
                            <th>Date Filed</th>
                            <th>Day</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>OT Minutes</th>   
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
            console.log('hello world');
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
        })


        $('.ob-btn').on('click', function(){
            $('#official-business-modal').show();
            
            let obId = $(this).attr('ob-id');
            let url = "{{ route('obd', ':obId') }}";
            url = url.replace(':obId', obId);
            
            $.ajax({
                url: url, 
                dataType: 'json',
                type: 'GET',
                success: function(response){
                    $('input[name="ob_date_from"]').val(response.date_from);
                    $('input[name="ob_date_to"]').val(response.date_to);
                    $('input[name="ob_time_from"]').val(response.time_from);
                    $('input[name="ob_time_from"]').val(response.time_to);
                    $('input[name="ob_location"]').val(response.location);
                    $('input[name="ob_reason"]').val(response.reason);
                },
                error: function(error){
                    console.log(error)
                }
            })
        })

        $('.ot-btn').on('click', function(){
            $('#overtime-modal').show();
            
            let otId = $(this).attr('ot-id');
            let url = "{{ route('otd', ':otId') }}";
            url = url.replace(':otId', otId);
            
            // $.ajax({
            //     url: url, 
            //     dataType: 'json',
            //     type: 'GET',
            //     success: function(response){
            //         $('input[name="ob_date_from"]').val(response.date_from);
            //         $('input[name="ob_date_to"]').val(response.date_to);
            //         $('input[name="ob_time_from"]').val(response.time_from);
            //         $('input[name="ob_time_from"]').val(response.time_to);
            //         $('input[name="ob_location"]').val(response.location);
            //         $('input[name="ob_reason"]').val(response.reason);
            //     },
            //     error: function(error){
            //         console.log(error)
            //     }
            // })
        })

        function removeBtnClassActive(){
            $('.u-btn-active').removeClass('u-btn-active');
        }

        function hideTables(){
            $('.official-business-table').hide();
            $('.overtimes-table').hide();
        }
        
    });

    // DataTable 
    $('.myTable').DataTable({
        responsive: true,
        "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ]
    });
</script>
@endsection