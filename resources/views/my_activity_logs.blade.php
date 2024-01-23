@extends('layouts.side_top_content')

@section('module_name', 'Employee Activity Logs')

@section('content')

<div>
    <div class="modal" id="pop_image">
        <form method="POST" action="{{ route('generate_file') }}">
        @csrf
            <div class="modal_body" >
                <input type="text" name="employeeName" value="{{ auth()->user()->employee_name }}" style="display: none;"> 
                <div class="container_title">
                    <p class="header_title_h2">My Activity Logs Summary</p>
                </div>
                <div class="summary_report">
                    <div class="sr_from_date">
                        <label for="">From:</label>
                        <input type="date" name="from_date" id="from_date" value="{{ $from ?? '' }}" required>
                    </div>
                    <div class="sr_to_date">
                        <label for="">To:</label>
                        <input type="date" name="to_date" id="to_date" value="{{ $to ?? '' }}" required>
                    </div>
                </div>
                <div class="datebtn">
                    <button type="submit" class="date_generate">Generate</button>
                </div>
            </div>

        </form>
    </div>
    @if (session('success'))
        <div class="add_user_success"> 
            <span>{{ session('success') }}</span>
        </div>
    @endif
</div>

<a class="user_info_link" href="#pop_image" rel="modal:open">Generate File</a>
@if ($has_generated ?? false)
    <a href="{{ route('export_activity_log') }}?data_entry={{ $numEntry }}&from_date={{ $fromDate }}&to_date={{ $toDate }}" id="export_excel">Export File</a>
@endif
<br>
<br>
<div class="user_accounts_table">
    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th style="text-align: center;">Datetime Access</th>
                <th style="text-align: center;">Log-Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user_logs as $user_log )
                <tr>
                    <td style="text-align: center;">{{ date('M d Y h:i a', strtotime($user_log->log_at)) }}</td>
                    {{-- <td style="text-align: center;">{{ $user_log->log_at }}</td> --}}
                    <td style="text-align: center;">{{ $user_log->log_type_description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $user_logs->links()}}
</div>

@endsection

@section('script_content')
<script>
    

    
    $('.user_accounts_table').fadeIn('slow');

    $('#myTable').DataTable({
    responsive: true,
    paging:false,
    info:false,
    order: [[0, 'desc']] // Assuming you want to order by the first column (index 0) in descending order
});

    $('.js-example-basic-single').select2({
            width: '99%',
    });
</script>
@endsection