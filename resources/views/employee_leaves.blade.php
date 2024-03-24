@extends('layouts.side_top_content', ['title' => 'Employee Leaves'])

@section('module_name', 'Employee Leaves')

@section('content')

</style>

<div class="modal-center add-leaves" style="display: none;">
    <div class="modal-box u-p-15">
        <form method="POST" action="{{ route('employeeLeavesAdd') }}">
            @csrf
            <div>
                <h4>Add Profile</h4>
            </div>
            <table class="custom_normal_table">
                <tbody>
                    <tr>
                        <td colspan="2">
                            <p>Select Employee:</p>
                            <select class="js-example-basic-single" name="users_id" id="users_id" required >
                                <option value="" selected disabled>None selected</option>
                                @foreach ( $usernames as $username )
                                    <option value="{{ $username->id }}"
                                        @if ($username->employee_leaves_id)
                                            disabled
                                        @endif
                                    >{{ $username->name }}</option>
                                @endforeach
                            </select>                       
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <p>Vacation Leaves Credit:</p>
                            <input class="u-input u-t-center" name="vacation_leave" type="text" pattern="\d+(\.\d{0,2})?" title="Numbers only with two decimal place" required>
                        </td>      
                        <td>
                            <p>Birthday Leaves Credit:</p>
                            <input class="u-input u-t-center" name="sick_leave"  pattern="\d+(\.\d{0,2})?" title="Numbers only with two decimal place" type="text" required>
                        </td>      
                    </tr>
                </tbody>                
            </table>
            <div class="u-ml-10" style="padding: 10px;">
                <button class="u-btn u-mr-10" type="button" id="btn-close">Close</button>
                <button class="u-btn u-bg-primary u-t-white" type="submit">Submit</button>
            </div>
        </form>
    </div>
</div>
<div class="modal-center edit-leaves" style="display: none;">
    <div class="modal-box u-p-15">
        <form method="POST">
            @csrf
            <div>
                <h4>Edit Leaves</h4>
            </div>
            <table class="custom_normal_table">
                <tbody>
                    <tr>
                        <td colspan="2">
                            <p>Select Employee:</p>
                            <select class="js-example-basic-single u-input" name="users_id" id="edit_users_id" disabled >
                                <option value="" selected disabled>None selected</option>
                                @foreach ( $usernames as $username )
                                    <option value="{{ $username->id }}"
                                        @if ($username->employee_leaves_id)
                                            disabled
                                        @endif
                                    >{{ $username->name }}</option>
                                @endforeach
                            </select>                       
                        </td>
                    </tr>
                    <tr>
                        <td >
                            <p>Vacation Leaves Credit:</p>
                            <input class="u-input u-t-center" name="vacation_leave" id="edit_vacation_leave" type="text" pattern="\d+(\.\d{0,2})?" title="Numbers only with two decimal place" required>
                        </td>      
                        <td>
                            <p>Birthday Leaves Credit:</p>
                            <input class="u-input u-t-center" name="sick_leave"  id="edit_sick_leave" pattern="\d+(\.\d{0,2})?" title="Numbers only with two decimal place" type="text" required>
                        </td>      
                    </tr>
                </tbody>                
            </table>
            <div class="u-ml-10" style="padding: 10px;">
                <button class="u-btn u-mr-10" type="button" id="edit-btn-close">Close</button>
                <button class="u-btn u-bg-primary u-t-white" type="submit">Submit</button>
            </div>
        </form>
    </div>
</div>
<div class="approve_reg_btn">
    <a class="user_info_link open-modal">New Employee Leaves</a> 
</div>
<div>
    <br>
    @if (session('success'))
        <h5 class="u-fw-b" style="color: green; display:block;">{{ session('success') }}</h5>
    @endif
</div>
<div class="user_accounts_table">
    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Vacation Leaves</th>
                <th>Birthday Leaves</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Updated By</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ( $users as $user )
                <tr>
                    <td>{{ $user->employee_name }}</td>
                    <td>{{ $user->vacation_credit }}</td>
                    <td>{{ $user->sick_credit }}</td>
                    <td>{{ $user->employee_leaves_created_by }}</td>
                    <td>{{ $user->employee_leaves_created_at }}</td>
                    <td>{{ $user->employee_leaves_updated_by }}</td>
                    <td>{{ $user->employee_leaves_updated_at }}</td>
                    <td>
                        <div class="d-flex;">
                            <button class="ob-btn u-action-btn u-bg-primary edit-modal" type="button"  data-entry-id="{{ $user->id }}" data-href="{{ route('editEmployeeLeave', $user->id) }}">
                                <span class="material-symbols-outlined"  style="vertical-align: bottom; font-size: 20px; font-weight: bold;">
                                    edit
                                </span>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
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

    $('.open-modal').on('click', function(){
        $('.add-leaves').show();
    });
    $('.edit-modal').on('click', function(){
        $('.edit-leaves').show();
    });

    $('#btn-close, #edit-btn-close').on('click', function(){
        $('.modal-center').hide();
    });

    $('.js-example-basic-single').select2({
            width: '100%',
    });

    $('.edit-modal').click(function(e){
        const entryId = $(this).data('entry-id');
        const url = $(this).attr('href');
        let editUrl = "{{ route('editEmployeeLeave', 'entryId') }}";
        const newUrl = editUrl.replace('entryId', entryId);
        $.ajax({
                url: newUrl,   
                    dataType: 'json',
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        $('#edit_users_id').val(response.user_id).trigger('change');
                        $('#edit_vacation_leave').val(response.vacation_credit);
                        $('#edit_sick_leave').val(response.sick_credit);
                        $('form').attr('action', '/employee_leave/' + response.id + '/update');
                    },
                    error: function(error) {
                        console.log(error);
                    }
            });
    });

</script>
@endsection