@extends('layouts.side_top_content' , ['title' => 'Employee Payroll'])

@section('module_name', 'Employee Payroll')

@section('content')

<style>
    .modal-box{
        max-width: 75rem !important;
    }
</style>

{{-- <div class="modal-center" style="display: none;">
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
                                <input class="u-input" id="pdfInput" name="pr_pdf" type="file" accept=".pdf" required>
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
    <div class="u-mr-16" style="position: relative" id="add-payroll-btn">
        <button class="u-btn u-bg-default u-t-dark u-border-1-gray u-box-shadow-default" href="">Add Payroll</button>
    </div>
</div> --}}

@if (session('success'))
    <div class="u-mt-10">
        <span class="u-t-success">{{ session('success') }}</span>
    </div>
@endif

<div class="u-mt-10 user_accounts_table2">
    <table class="myTable" class="display" style="width:100%;">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Mobile Number</th>
                <th>Email</th>
                <th>Action</th>
                {{-- <th>Employee Name</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Updated By</th>
                <th>Action</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>{{ "$employee->name" }}</td>
                    <td>{{ $employee->basic_information->mobile_number }}</td>
                    <td>{{ "$employee->email" }}</td>
                    <td>
                        <div class="d-flex" style="gap:3px">
                            <a href="{{ route('employee_payroll_view', $employee->id) }}" class="material-symbols-outlined u-action-btn u-bg-primary" style="vertical-align: bottom; font-size: 20px; font-weight: bold; color: white; text-decoration: none;">
                                edit
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
            {{-- @foreach ($payrolls as $payroll)
                <tr>
                    <td>{{ $payroll->name }}</td>
                    <td>{{ $payroll->from_date }}</td>
                    <td>{{ $payroll->to_date }}</td>
                    <td>{{ $payroll->created_by_head }}</td>
                    <td>{{ $payroll->created_at }}</td>
                    <td>{{ $payroll->name }}</td>
                    <td>
                        <div class="d-flex" style="gap:3px">
                            <a href="{{ route('employee_payroll_edit', $payroll->id) }}" class="material-symbols-outlined u-action-btn u-bg-primary" style="vertical-align: bottom; font-size: 20px; font-weight: bold; color: white; text-decoration: none;">
                                edit
                            </a>
                            <button type="button" class="material-symbols-outlined u-action-btn u-bg-danger delete-payroll" style="vertical-align: bottom; font-size: 20px; font-weight: bold; color: white; text-decoration: none;" payroll-id="{{ $payroll->id }}">
                                delete
                            </button>
                        </div>
                    </td>
                </tr>   
            @endforeach --}}
        </tbody>
        <tfoot>
            {{-- Comment --}}
            <tr>
                <th>Employee Name</th>
                <th>Mobile Number</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            {{-- <tr>
                <th>Employee Name</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Action</th>
            </tr> --}}
        </tfoot>
    </table>
    {{ $employees->links() }}
    <p>Showing {{ $employees->firstItem() ?? 0 }} to {{ $employees->lastItem() ?? 0 }} of {{ $employees->total() }} items.</p>
</div>



@section('script_content')
    <script>

        // DataTable 
        $('.myTable').DataTable({
            responsive: true,
            paging:false,
            info:false,
            searching: false,
            "columnDefs": [
                { "className": "dt-center", "targets": "_all" }
            ]
        });

        // Select2
        $('.js-example-basic-single').select2({
                width: '100%',
        });

        // Close Modal
        $('#modal-btn-close').on('click', function(){
            $('.modal-center').hide();
        })

        // Open add payroll
        $('#add-payroll-btn').on('click', function(){
            $('.modal-center').show();
        })

        // Delete Payroll
        $(document).on('click', '.delete-payroll', function() {
            const payrollId = $(this).attr('payroll-id');
            Swal.fire({
                title: 'Are you sure?',
                html: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then(result => {
                if (result.isConfirmed) {
                    location.assign(`{{ route('employee_payroll_delete') }}?id=${payrollId}`);
                }
            })
        });

        $(document).ready(function() {
            $('#pdfInput').on('change', function() {
                var file = this.files[0];
                var fileType = file.type;
                if (fileType !== 'application/pdf') {
                    alert('Please select a PDF file.');
                    $(this).val(''); 
                }
                }); 
        });
    </script>
@endsection
@endsection

