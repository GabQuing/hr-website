@extends('layouts.side_top_content')

@section('module_name', 'Employee Activity Logs')

@section('content')



<div>
    <div class="modal" id="pop_image">
        <form method="POST" action="{{ route('generate_user_file') }}">
        @csrf
            <div class="modal_body" >
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
</div>
<a class="user_info_link" href="#pop_image" rel="modal:open">Generate File</a>
@if ($has_generated ?? false)
    <a href="{{ route('export_user_activity_log') }}?data_entry={{ $numEntry }}&from_date={{ $fromDate }}&to_date={{ $toDate }}" id="export_excel">Export File</a>
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
                <th>Date Access</th>
                <th>User</th>
                <th>Log-Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user_logs as $user_log )
                <tr>
                    <td>{{ date('M d Y h:i a', strtotime($user_log->log_at)) }}</td>
                    {{-- <td>{{ date('h:i a', strtotime($user_log->log_time)) }}</td> --}}
                    {{-- <td>{{$userData->date.' ('.$userData->time.')'}}</td> --}}
                    <td>{{ $user_log->user_name }}</td>
                    <td>{{ $user_log->log_type_description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- @if (!$has_generated) --}}
        {{ $user_logs->links()}}
    {{-- @endif --}}
</div>

@endsection

@section('script_content')
<script>

    /*function getGDriveLinks() {
        const images = $('.log-image').get();
        const uuids = images.map(image => $(image).attr('uuid'));


        $.ajax({
            url: "{{ route('getGoogleImages') }}",
            data: { _token : "{{ csrf_token() }}", uuids: JSON.stringify(uuids)},
            dataType:'json',
            type: 'POST',
            success: function(response){
                console.log(response);
                showImage(uuids, response)
            },
            error: function(error){
                console.log(error);
            }
        });
    }

    getGDriveLinks();

    function showImage(uuids, data) {
        uuids.forEach(uuid => {
            const link = data[uuid];
            $(`.log-image[uuid="${uuid}"]`).attr('src', link);
        })
    } */


    
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