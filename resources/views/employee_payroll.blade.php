@extends('layouts.side_top_content' , ['title' => 'Employee Payroll'])

@section('module_name', 'Employee Payroll')

@section('content')

<style>
    .modal-box{
        max-width: 75rem !important;
    }
</style>

<div class="modal-center" id="official-business-modal">
    <div class="modal-box">
        <div class="modal-content">
            <form method="POST" action="{{ route('employee_payroll_add') }}" enctype="multipart/form-data">
                @csrf
                <table class="custom_normal_table">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <h3 class="f-weight-bold">Add Payroll</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Employee Name</p>
                                <select class="u-input" name="pr_employee_id" id="" required>
                                    <option value="" selected disabled>Select employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <p>Upload PDF</p>
                                <input class="u-input" name="pr_pdf" type="file" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Date From:</p>
                                <input class="u-input" name="pr_date_from" type="date" required>
                            </td>
                            <td>
                                <p>Date To:</p>
                                <input class="u-input" name="pr_date_to" type="date" required>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="u-flex-space-between u-flex-wrap">
                    <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default btn-close" id="modal-btn-close" type="button">Close</button>
                    <button class="u-t-white u-fw-b u-btn u-bg-primary u-m-10 u-border-1-default btn-close" id="modal-btn-submit" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="u-flex">
    <div class="u-mr-16" style="position: relative" id="payroll-btn">
        <button class="u-btn u-bg-default u-t-dark u-border-1-gray u-box-shadow-default" href="">Add Payroll</button>
    </div>
</div>

<div class="u-mt-10">
    <table class="myTable" class="display" style="width:100%;">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Created By</th>
                <th>Updated By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <div class="d-flex;">
                        <button class="ot-btn u-action-btn u-bg-primary" type="button">
                            <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 20px; font-weight: bold;">
                                edit
                            </span>
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th>Employee Name</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Created By</th>
                <th>Updated By</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
</div>



@section('script_content')
    <script>

        // DataTable 
        $('.myTable').DataTable({
            responsive: true,
            "columnDefs": [
                { "className": "dt-center", "targets": "_all" }
            ]
        });

        // Select2
        $('.js-example-basic-single').select2({
                width: '100%',
        });
    </script>
@endsection
@endsection

