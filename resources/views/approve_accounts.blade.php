@extends('layouts.side_top_content', ['title' => 'Employee Registration'])

@section('module_name', 'Employee Registration')

@section('content')
<style>

    .select2-container--default .select2-results__option {
        text-transform: uppercase;
        font-size: 12px
    }
    .select2-container--default {
        font-size: 14px;
    }
    .text-red {
        color: rgb(255, 0, 0);
        font-weight: bold;
    }
    
    
</style>

<div class="modal-center" id="add-account-modal" style="display: none;">
    <div class="modal-box u-p-10">
        <form action="{{ route('add_user') }}" method="POST" autocomplete="off">
            @csrf
            <div>
                <h4 class="u-t-gray u-fw-b">Add Account</h4>
            </div>
            <table class="custom_normal_table">
                <tbody>
                    <tr>
                        <td>
                            <p>Email Address:</p>
                            <input class="u-input" type="text" name="email"  required>
                        </td>
                        <td>
                            <p>First Name:</p>
                            <input class="u-input" type="text" name="first_name" onchange="removeExcessSpaces(this)" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Last Name:</p>
                            <input class="u-input" type="text" name="last_name" required>
                        </td>
                        <td>
                            <p>Mobile Number:</p>
                            <input class="u-input" type="text" name="mobile_number" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p for="">Privilege</p>
                            <select class="js-example-basic-single s-add u-input" name="privilege_role" id="user_privilege" style="text-align: center;">
                                @foreach ($privilege_roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td style="position: relative">
                            <p for="">Temporary Password: </p>
                            <input class="u-input" type="password" name="password" value="qwerty123" placeholder="qwerty123" readonly>
                            <p style="position: absolute; font-size: 12px; color: rgb(69, 110, 159) !important; "> Temporary password = qwerty123</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="u-ml-10 u-mt-10 u-flex-space-between" style="padding: 10px;">
                <button class="u-btn u-mr-10" type="button" id="modal-btn-close">Close</button>
                <button class="u-btn u-bg-primary u-t-white" type="submit">Submit</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-center" id="modal-import" style="display: none;">
    <div class="modal-box u-p-10">
        <form action="{{ route('importUser') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div>
                <h4 class="u-t-gray u-fw-b">Import Excel File</h4>
            </div>
            <table class="custom_normal_table">
                <tbody>
                    <tr>
                        <td>
                            <p>Attach File:</p>
                            <input class="u-input" type="file" name="import_accounts"  required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Download Template:</p>
                            <a class="u-input" style="padding-top: 7px; padding-bottom: 7px; text-decoration: none;" href="{{ route('downloadNewEmployeeTemplate') }}" >Add-New-Employee-Template</a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="u-ml-10 u-mt-10 u-flex-space-between" style="padding: 10px;">
                <button class="u-btn u-mr-10" type="button" id="modal-import-btn-close">Close</button>
                <button class="u-btn u-bg-primary u-t-white" type="submit">Submit</button>
            </div>
        </form>
    </div>
</div>

<div class="mg-bottom">
    {{-- <div id="useraccounts_add" class="modal">
        <form action="{{ route('add_user') }}" method="POST" autocomplete="off">
            @csrf
            <div class="useraccounts_add_header">
                <p>Add Account</p>
            </div>
            <div>
                <div class="label_input">
                    <label for="">Email Address: </label>
                    <input type="text" name="email"  required>
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="label_input">
                    <label for="">First Name: </label>
                    <input type="text" name="first_name" onchange="removeExcessSpaces(this)" required>
                    @if ($errors->has('first_name'))
                        <span class="text-danger">{{ $errors->first('first_name') }}</span>
                    @endif
                </div>
                <div class="label_input">
                    <label for="">Last Name: </label>
                    <input type="text" name="last_name" required>
                    @if ($errors->has('last_name'))
                        <span class="text-danger">{{ $errors->first('last_name') }}</span>
                    @endif
                </div>
                <div class="label_input">
                    <label for="">Mobile Number: </label>
                    <input type="text" name="mobile_number" required>
                    @if ($errors->has('mobile_number'))
                        <span class="text-danger">{{ $errors->first('mobile_number') }}</span>
                    @endif
                </div>
                <div class="label_input">
                    <label for="">Privilege</label>
                    <select class="js-example-basic-single s-add" name="privilege_role" id="user_privilege" style="text-align: center;">
                        @foreach ($privilege_roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="label_input">
                    <label for="">Temporary Password: </label> <label style="color: #20B2AA"><em>qwerty123</em></label>
                    <input type="password" name="password" value="qwerty123" placeholder="qwerty123" readonly>
                </div>
            </div>

            <a class="addaccount_close" href="#" rel="modal:close" id="clsaccount_btn">Close</a>
            <button class="addaccount_btn">Submit</button>
        </form>
    </div> --}}

    <div id="useraccounts_import" class="modal">
        <form action="{{ route('importUser') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div class="useraccounts_add_header">
                <p>Import Excel File</p>
            </div>
            <br>
            <div class="label_input_import" style="text-align: center">
                <br>
                <label for="">Attach File: </label> &nbsp;
                <input type="file" id="import_accounts" name="import_accounts"  required>
                {{-- <input type="file" id="import_accounts" name="import_accounts" accept=".xlsx, .xlsm, .csv" required> --}}
                <br><br>
                <label for="">Download Template: </label> &nbsp;
                <a class="download_temp_btn" href="{{ route('downloadNewEmployeeTemplate') }}" >Add-New-Employee-Template</a>
            </div>
            <br><br><br><br><br>
            <div class="import_modal_btn" style="text-align: center;">
            <a class="addaccount_close" href="#" rel="modal:close" id="clsaccount_btn">Close</a>
            <button type="submit" class="addaccount_btn" id="import_account_btn">Submit</button>
            </div>
        </form>
    </div>

        <!-- Link to open the modal -->
    <div class="approve_reg_btn">
    <button class="u-btn u-bg-primary u-t-white" id="add-acc-btn">Add Account</button> 
    <button class="u-btn u-bg-default" id="import-acc-btn">Import Accounts</button>
    </div>
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
                <th>Email</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Role</th>
                <th>Created at</th>
                <th>Account</th>
                <th>Status</th>
                <th>Actions</th>            
            </tr>
        </thead>
        <tbody>
            @foreach ($user as $user_data)
                <tr>
                    <td>{{ $user_data->email }}</td>
                    <td>{{ $user_data->first_name }}</td>
                    <td>{{ $user_data->last_name }}</td>
                    <td>{{ strtoupper($user_data->privilege_name ) }}</td>
                    <td>{{ $user_data->created_at }}</td>
                    <td>{{ $user_data->biometric_register ? "REGISTERED" : "NO RECORDS" }}</td>
                    <td>
                        <span class="{{ $user_data->approval_status === 'REJECTED' ? 'text-red' : 'text-pending' }}">
                            {{ $user_data->approval_status }}
                        </span>
                    </td>
                    <td>
                        <div class="useraccounts_action_btn">
                            @if ($user_data->biometric_register)
                            <a class="useraccount_approve" href="{{ route('approve', $user_data->id) }}" data-user-id="{{ $user_data->id }}">Approve</a>
                            <a class="useraccount_reject" href="{{ route('reject', $user_data->id) }}">Reject</a>
                            @endif
                        </div>
                    </td> 
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Name</th>
                <th>Role</th>
                <th>Created at</th>
                <th>Account </th>
                <th>Status</th>     
                <th>Actions</th>     
            </tr>
        </tfoot>
    </table>
</div>

@endsection

@section('script_content')
<script>

    // FadeIn table
    $('.user_accounts_table').fadeIn('slow');

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


    // Reject swal alert
    $('.useraccount_reject').click(function(e){
        e.preventDefault();
        var deleteLink = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure to reject the request?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Reject it!'
        }).then((result) => {
            if (result.isConfirmed) {
            Swal.fire(
                'Rejected!',
                'User account request has been rejected.',
                'success'
            )
            .then(() => {
                window.location.href = deleteLink;
            });
            }
        });
    });

    $('.useraccount_approve').click(function(e){
        e.preventDefault();
        var deleteLink = $(this).attr('href');
        Swal.fire({
            title: 'Are you sure to approve the request?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve it!'
        }).then((result) => {
            if (result.isConfirmed) {
            Swal.fire(
                'Approved!',
                'User account request has been approve.',
                'success'
            )
            .then(() => {
                window.location.href = deleteLink;
            });
            }
        });
    });

    $('#modal-btn-close').on('click', function(){
        $('.modal-center').hide();
    })

    $('#add-acc-btn').on('click', function(){
        $('#add-account-modal').show();
    })

    $('#import-acc-btn').on('click', function(){
        $('#modal-import').show();
    })

    $('#modal-import-btn-close').on('click', function(){
        $('#modal-import').hide();
    })

    // Approved swal alert

</script>
@endsection