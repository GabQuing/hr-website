@extends('layouts.side_top_content', ['title' => 'User Accounts'])

@section('module_name', 'User Accounts')

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

    <div class="sk-chase-position" style="display: none;">
        <div class="sk-chase">
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        <div class="sk-chase-dot"></div>
        </div>
        <div class="sk-chase-text">
        <p>Retrieving Images . . . Please Wait</p>
        </div>
    </div>

    <div id="useraccounts_edit" class="modal">
        <form method="POST">
            @csrf
            <div class="useraccounts_add_header">
                <p>Update Account</p>
            </div>
            <div>
                <div class="label_input">
                    <label for="">First Name: </label>
                    <input type="text" name="first_name" id="edit_first_name" value="" required>
                    @if ($errors->has('first_name'))
                        <span class="text-danger">{{ $errors->first('first_name') }}</span>
                    @endif
                </div>
                <div class="label_input">
                    <label for="">Last Name: </label>
                    <input type="text" name="last_name" id="edit_last_name" value="" required>
                    @if ($errors->has('last_name'))
                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                    @endif
                </div>
                <div class="label_input">
                    <label for="">Email Name: </label>
                    <input type="text" name="email" id="edit_email" value="">
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="label_input">
                    <label for="">Privilege</label>
                    <select class="js-example-basic-single s-add" name="privilege_role" id="user_privilege_edit" style="text-align: center;">
                        @foreach ($privilege_roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="label_input">
                    <label for="">Password: </label>
                    <input type="password" name="password" id="edit_password">
                    @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
            </div>

            <div class="useraccounts_edit_btns">
                <a class="addaccount_close" href="#" rel="modal:close" id="clsaccount_btn">Close</a>
                <button class="addaccount_btn">Update</button>
                {{-- <a class="retake_photo_btn" href="" id="retake_btn">Re-take Photos</a> --}}
            </div>


        </form>
    </div>

    <div id="pop_img" class="pop_img_hide">
        <div id="close_modal_btn">×</div>
        <div class="user_img" style="display: flex">
            <div class="user_img_content1 user_img_content">
                <img id="user_face_recog_img1" src="" alt="Photo" loading="lazy" style="width: 100%">
                <p>Photo 1</p>
            </div>
            <div class="user_img_content2 user_img_content">
                <img id="user_face_recog_img2" src="" alt="Photo" loading="lazy" style="width: 100%">
                <p>Photo 2</p>
            </div>
        </div>
    </div>
    
    <!-- Link to open the modal -->
    {{-- <p><a class="user_info_link" href="#useraccounts_add" rel="modal:open">Add Account</a> <a class="user_info_link" href="#useraccounts_import" rel="modal:open">Import Accounts</a></p> --}}
    @if (session('errors'))
    <div class="add_user_success"> 
        @foreach (session('errors')->getBag('default')->all() as $error)
        <span style="color: red; display:block;">{{ $error }}</span>
        @endforeach
    </div>
    @endif
    @if (session('success'))
        <div class="add_user_success"> 
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if (session('deactivate'))
        <div class="add_user_delete"> 
            <span>{{ session('deactivate') }}</span>
        </div>
    @endif
    @if (session('activate'))
        <div class="add_user_success"> 
            <span>{{ session('activate') }}</span>
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
                            <a class="useraccount_edit" href="{{ route('edit', $user_data->id) }}" data-user-id="{{ $user_data->id }}">Edit</a>
                            @if (is_null($user_data->deleted_at))
                                <a class="useraccount_delete" href="{{ route('delete', $user_data->id) }}">Deactivate</a>
                                @else
                                <a class="useraccount_activate" href="{{ route('activate', $user_data->id) }}" style="background-color: #ff5733;">Activate</a>
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

    //Remove Excess Space
    function removeExcessSpaces(input) {
        var firstName = input.value.replace(/\s{2,}/g,' ').trim();
        input.value = firstName;
    }

    // FadeIn table
    $('.user_accounts_table').fadeIn('slow');

    // Edit Data
    $('.useraccount_edit').click(function(e) {
        e.preventDefault();
        var userId = $(this).data('user-id');
        var url = $(this).attr('href');
        let retakeUrl = "{{ route('retake', 'userId') }}";
        console.log(retakeUrl);
        const retakeId = retakeUrl.replace('userId', userId);
        $('#retake_btn').attr('href', retakeId);

        $.ajax({
            url: url,   
            dataType: 'json',
            type: 'GET',
            success: function(response) {
                console.log(response);
                $('#useraccounts_edit .modal-content').html(response);
                $('#useraccounts_edit').modal('show');
                // $('#useraccounts_edit').modal();
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

    // View Data
    $('.useraccount_view_img').click(function(e) {
        $('body').css('overflow', 'hidden');
        // $('*').css('background-color', 'black');
        $('.sk-chase-position').show();
        e.preventDefault();
        var userId = $(this).data('user-id');
        console.log(userId);
        var url = $(this).attr('href');
        console.log(url);
        $.ajax({
            url: url,   
            data: {
                userId : userId
            },
            dataType: 'json',
            type: 'GET',
            success: function(response) {
                console.log(response);
                $('.sk-chase-position').hide();
                $('#user_face_recog_img1').attr('src', `${response.photo}`);
                $('#user_face_recog_img2').attr('src', `${response.photo2}`);
                $('#pop_img').removeClass('pop_img_hide');
                $('#pop_img').addClass('pop_img_show');
            },
            error: function(error) {
                console.log(error);
                $('.sk-chase-position').hide();
                alert('No Images Retrieved');


            }
        });
    });

    // close modal
    $(document).on('click', '#close_modal_btn', function() {
        $('body').css('overflow', 'auto');
        $('#pop_img').removeClass('pop_img_show');
        $('#pop_img').addClass('pop_img_hide');
    });

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

    // Add Account
    $('#clsaccount_btn').click(function(){
        var inputs = $('#useraccounts_add').find('input');
        inputs.val('');
    })

    // Delete swal alert
    $('.useraccount_delete').click(function(e){
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

    //retake photo
    // $('#retake_btn').click(function(e){
    //     e.preventDefault();
    //     const retakeLink = $(this).attr('href');
    //     Swal.fire({
    //         title: 'Are you sure?',
    //         text: "You won't be able to revert this!",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         cancelButtonColor: '#d33',
    //         confirmButtonText: 'Yes, Re-take Photos!'
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //         Swal.fire(
    //             'Success!',
    //             'The user will need to re-take photos when logging into their account.',
    //             'success'
    //         )
    //         .then(() => {
    //             window.location.href = retakeLink;
    //         });
    //         }
    //     });
        
    // });


    $('.useraccount_activate').click(function(e){
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