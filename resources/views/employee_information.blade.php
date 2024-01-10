@extends('layouts.side_top_content')

@section('module_name', 'Employee Informations')

@section('content')

<div class="mg-bottom">
    <div id="useraccounts_import" class="modal">
        <form action="{{ route('editUser') }}" method="POST" enctype="multipart/form-data">
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
                <a class="download_temp_btn" href="{{ route('downloadEditProfileTemplate') }}" >Edit-Profile-Template</a>
            </div>
            <br><br><br><br><br>
            <div style="text-align: center;">
            <a class="addaccount_close" href="#" rel="modal:close" id="clsaccount_btn">Close</a>
            <button type="submit" class="addaccount_btn" id="import_account_btn">Submit</button>
            </div>
        </form>
    </div>

        <!-- Link to open the modal -->
    <p><a class="user_info_link" href="#useraccounts_import" rel="modal:open">Edit Profile Accounts</a></p>
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
                <th>Role</th>
                <th>Created at</th>
                <th>Updated at</th>
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
                    <td>{{ strtoupper($user_data->privilege_name ) }}</td>
                    <td>{{ $user_data->created_at }}</td>
                    <td>{{ $user_data->updated_at }}</td>
                    <td>
                        <a class="useraccount_edit" href="{{ route('edit_profile', $user_data->id) }}" data-user-id="{{ $user_data->id }}">Edit</a>
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
                <th>Role</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Actions</th>          
            </tr>
        </tfoot>
    </table>
</div>

@endsection

@section('script_content')
<script>
    
    $('.user_accounts_table').fadeIn('slow');

    $('#myTable').DataTable({
        responsive: true
    });

    $('.js-example-basic-single').select2({
            width: '99%',
    });
</script>
@endsection