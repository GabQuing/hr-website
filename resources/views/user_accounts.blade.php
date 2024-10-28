@extends('layouts.side_top_content', ['title' => 'Employee Accounts'])

@section('module_name', 'Employee Accounts')

@section('content')
<style>

    .select2-container--default .select2-results__option {
        text-transform: uppercase;
        font-size: 12px
    }
    .select2-container--default {
        font-size: 14px;
    }
    
</style>
<div class="mg-bottom">

    <div class="modal-center" id="useraccounts_edit" style="display: none;">
        <div class="modal-box u-p-15">
            <div>
                <h4 class="u-fw-b">Update Account</h4>
            </div>
            <form id="ua-form" method="POST">
                @csrf
                <table class="custom_normal_table u-mt-10">
                    <tbody>
                        <tr>
                            <td>
                                <p>First Name</p>
                                <input class="u-input" type="text" name="first_name" id="edit_first_name" value="" required>
                            </td>
                            <td>
                                <p>Last Name</p>
                                <input class="u-input" type="text" name="last_name" id="edit_last_name" value="" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Email</p>
                                <input class="u-input" type="text" name="email" id="edit_email" value="">
                            </td>
                            <td>
                                <p>Privilege</p>
                                <select class="js-example-basic-single" name="privilege_role" id="user_privilege_edit" style="text-align: center;">
                                    @foreach ($privilege_roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <td colspan="2">
                            <p>Password</p>
                            <input class="u-input" type="password" name="password" id="edit_password">
                        </td>
                    </tbody>
                </table>
                @if ($errors->has('first_name'))
                    <div class="u-m-10 u-bg-danger" style="padding: 10px;">
                        <span class="u-t-white">{{ $errors->first('first_name') }}</span>
                    </div>
                @endif
                @if ($errors->has('last_name'))
                    <div class="u-m-10 u-bg-danger" style="padding: 10px;">
                        <span class="u-t-white">{{ $errors->first('last_name') }}</span>
                    </div>
                @endif
                @if ($errors->has('email'))
                    <div class="u-m-10 u-bg-danger" style="padding: 10px;">
                        <span class="u-t-white">{{ $errors->first('email') }}</span>
                    </div>
                @endif
                @if ($errors->has('password'))
                    <div class="u-m-10 u-bg-danger" style="padding: 10px;">
                        <span class="u-t-white">{{ $errors->first('email') }}</span>
                    </div>
                @endif
                <div class="u-ml-10 u-flex-end" style="padding: 10px;">
                    <button class="u-btn u-mr-10" type="button" id="btn-close">Close</button>
                    <button class="u-btn u-bg-primary u-t-white" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Link to open the modal -->
    {{-- <p><a class="user_info_link" href="#useraccounts_add" rel="modal:open">Add Account</a> <a class="user_info_link" href="#useraccounts_import" rel="modal:open">Import Accounts</a></p> --}}
    @if (session('errors'))
        <div class="add_user_success"> 
            @foreach (session('errors')->getBag('default')->all() as $error)
            <span class="u-fw-b u-t-danger" style="display:block;">{{ $error }}</span>
            @endforeach
        </div>
    @endif
    @if (session('success'))
        <div class="add_user_success"> 
            <span class="u-fw-b">{{ session('success') }}</span>
        </div>
    @endif
    @if (session('deactivate'))
        <div class="add_user_delete"> 
            <span class="u-fw-b">{{ session('deactivate') }}</span>
        </div>
    @endif
    @if (session('activate'))
        <div class="add_user_success"> 
            <span class="u-fw-b">{{ session('activate') }}</span>
        </div>
    @endif
</div>

<div class="user_accounts_table">
    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Name</th>
                <th>Email</th>
                {{-- <th>Approval Status</th> --}}
                <th>Role</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Status</th>
                <th>Actions</th>            
            </tr>
        </thead>
        <tbody>
            @foreach ($user as $user_data)
                <tr>
                    <td>{{ $user_data->id }}</td>
                    <td>{{ $user_data->first_name }}</td>
                    <td>{{ $user_data->last_name }}</td>
                    <td>{{ $user_data->name }}</td>
                    <td>{{ $user_data->email }}</td>
                    {{-- <td>{{ $user_data->approval_status }}</td> --}}
                    <td>{{ strtoupper($user_data->privilege_name ) }}</td>
                    <td>{{ $user_data->created_at }}</td>
                    <td>{{ $user_data->updated_at }}</td>
                    <td>
                        @if (is_null($user_data->deleted_at))
                            <span class="text-success">ACTIVE</span>
                        @else
                            <span class="text-danger">INACTIVE</span>
                        @endif
                    </td>
                    <td>
                        <div class="useraccounts_action_btn">
                            <button class="u-btn u-mr-5 edit-btn u-t-gray" href="{{ route('edit', $user_data->id) }}" data-user-id="{{ $user_data->id }}">Edit</button>
                            @if (is_null($user_data->deleted_at))
                                <a class="u-btn u-bg-danger deactivate_btn u-t-deco-none u-t-white" href="{{ route('delete', $user_data->id) }}">Deactivate</a>
                                @else
                                <a class="u-btn u-bg-success active-btn u-t-deco-none u-t-white" href="{{ route('activate', $user_data->id) }}">Activate</a>
                            @endif
                        </div>
                    </td> 
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Name</th>
                <th>Email</th>
                {{-- <th>Approval Status</th> --}}
                <th>Role</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Status</th>     
                <th>Actions</th>     
            </tr>
        </tfoot>
    </table>
</div>

@endsection

@section('script_content')
<script>
    let btnId;
    //Remove Excess Space
    function removeExcessSpaces(input) {
        var firstName = input.value.replace(/\s{2,}/g,' ').trim();
        input.value = firstName;
    }

    // FadeIn table
    $('.user_accounts_table').fadeIn('slow');

    // Edit Data
    $('.edit-btn').click(function(e) {
        e.preventDefault();
        const userId = $(this).data('user-id');
        const url = $(this).attr('href');
        btnId = userId;

        $.ajax({
            url: url,   
            dataType: 'json',
            type: 'GET',
            success: function(response) {
                console.log(response);
                $('#useraccounts_edit').show();
                $('#edit_first_name').val(response.user.first_name);
                $('#edit_last_name').val(response.user.last_name);
                $('#edit_email').val(response.user.email);
                $('#edit_password').val("");
                // View
                $('form').attr('action', '/user_accounts/' + response.user.id + '/update');
                var roleName = response.roles[0].name;
                $('#user_privilege_edit').val(roleName).trigger('change');
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    $('#ua-form').on('submit', function(event){
        event.preventDefault();

        const userId = btnId;
        const update = "{{ route('ua_update', 'userId') }}".replace('userId', userId);

        $('#ua-form').attr('action', update);

        console.log(update);

        this.submit();
    })
    
    // DataTable 
    $('#myTable').DataTable({
        responsive: true
    });

    // Select2 
    $('.js-example-basic-single').select2({
        width: '100%',
        templateSelection: function (data, container) {
            // Get the original text and capitalize all letters
            var modifiedText = data.text.toUpperCase();

            // Create a new jQuery object with the modified text
            var $modified = $('<span>').text(modifiedText);
            
            // Return the modified jQuery object
            return $modified;
        }
    });

    // Close Modal
    $('#btn-close').on('click', function(){
        $('.modal-center').hide();
        var inputs = $('#useraccounts_add').find('input');
        inputs.val('');
    });

    // Delete swal alert
    $('.deactivate_btn').click(function(e){
        e.preventDefault();
        var deleteLink = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Deactivate it!'
        }).then((result) => {
            if (result.isConfirmed) {
            Swal.fire(
                'Deactived!',
                'User account has been set to deactivate.',
                'success'
            )
            .then(() => {
                window.location.href = deleteLink;
            });
            }
        });
    });

    $('.active-btn').click(function(e){
        e.preventDefault();
        var deleteLink = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Activate it!'
        }).then((result) => {
            if (result.isConfirmed) {
            Swal.fire(
                'Activated!',
                'User account has been set to activate.',
                'success'
            )
            .then(() => {
                window.location.href = deleteLink;
            });
            }
        });
    });

    // Activate swal alert

</script>
@endsection