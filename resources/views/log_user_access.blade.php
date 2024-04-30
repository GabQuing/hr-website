@extends('layouts.side_top_content', ['title' => 'Employee Activity Logs'])

@section('module_name', 'Employee Activity Logs')

@section('content')

<div class="modal-center" style="display: none;">
    <div class="modal-box">
        <div class="modal-content">
            <form method="GET" action="{{ route('generate_user_file') }}">
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
                            <tr>
                                <td colspan="2">
                                    <p>Select Users:</p>
                                    <select class="js-example-basic-single s-single multiple-select" name="users_id[]" id="users_id" multiple="multiple" required >
                                        @foreach ( $usernames as $username )
                                            <option value="{{ $username->id }}">{{ $username->name }}</option>
                                        @endforeach
                                    </select>                             
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

<button class="u-btn u-bg-primary u-t-white open-modal" >Generate Table</button>
@if ($has_generated ?? true)
    <a href="{{ route('export_user_activity_log') }}?{{ $query_params }}" id="export_excel">Export File</a>
@endif
<div>
    @if (session('success'))
        <br>
        <span style="color: green; display:block;">{{ session('success') }}</span>
    @endif
</div>
<br>
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
        <p>Showing {{ $user_logs->firstItem() ?? 0 }} to {{ $user_logs->lastItem() ?? 0 }} of {{ $user_logs->total() }} items.</p>
    {{-- @endif --}}
</div>

@endsection

@section('script_content')
<script>

    $('.s-single').select2({
        width: '100%',
    });

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
    searching: false,
    order: [[0, 'desc']] // Assuming you want to order by the first column (index 0) in descending order
});

    $('.js-example-basic-single').select2({
            width: '99%',
    });

    
</script>
@endsection