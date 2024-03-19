@extends('layouts.side_top_content', ['title' => 'Employee Leaves'])

@section('module_name', 'Employee Leaves')

@section('content')
<div class="approve_reg_btn">
    <a class="user_info_link" href="#useraccounts_add" rel="modal:open">Add Employee Account</a> 
    </div>
<div class="user_accounts_table">
    <table id="myTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Email</th>
                <th>Vacation Leaves</th>
                <th>Birthday Leaves</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <div class="d-flex;">
                            <button class="ob-btn u-action-btn u-bg-primary" type="button" >
                                <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 20px; font-weight: bold;">
                                    edit
                                </span>
                            </button>
                        </div>
                    </td>
                </tr>
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

    $('.js-example-basic-single').select2({
            width: '99%',
    });

    
</script>
@endsection