@extends('layouts.side_top_content', ['title' => 'Employee Activity Logs'])

@section('module_name', 'Employee Activity Logs')

@section('content')

{{-- <style>
    .modal-box{
        max-width: 35rem !important;
    }
</style> --}}

<div class="modal-center" style="display: none;">
    <div class="modal-box">
        <div class="modal-content">
            <form method="GET" action="{{ route('generate_file') }}">
                @csrf
                <div style="overflow-x: auto; width: 100%;">
                    <table class="custom_normal_table">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <h3 class="f-weight-bold"><i class="fa-solid fa-eye"></i>  My Activity Logs Summary</h3>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>From:</p>
                                    <input class="u-input" type="date" name="from_date" id="from_date" value="{{ $from ?? '' }}" required>
                                </td>                           
                                <td>
                                    <p>To:</p>
                                    <input class="u-input" type="date" name="to_date" id="to_date" value="{{ $to ?? '' }}" required>
                                </td>                           
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="u-flex-space-between">
                    <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default" id="btn-close" type="button">Close</button>
                    <button class="u-t-white u-fw-b u-btn u-bg-accent u-m-10 u-border-1-default" id="btn-close" type="submit">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <button class="u-btn u-bg-default u-t-dark u-border-1-gray u-box-shadow-default open-modal">Generate Table</button>
{{-- <a class="user_info_link" href="#pop_image" rel="modal:open">Generate File</a> --}}
@if ($has_generated ?? false)
    <a href="{{ route('export_activity_log') }}?from_date={{ $fromDate }}&to_date={{ $toDate }}" id="export_excel">Export File</a>
@endif
<div>
    @if (session('success'))
        <br>
        <span style="color: green; display:block;">{{ session('success') }}</span>
    @endif
</div>
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

    $('.open-modal').on('click', function(){
        $('.modal-center').show();
    })

    $('#btn-close').on('click', function(){
        $('.modal-center').hide();
    })

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