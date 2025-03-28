@extends('layouts.side_top_content' , ['title' => 'Employee Payroll'])

@section('module_name', 'Edit Employee Payroll')

@section('content')

<style>
    .modal-box {
        max-width: 75rem !important;
    }
</style>

<div class="modal-box">
    <div class="modal-content">
        <form method="POST" action="{{ route('employee_payroll_update', $payroll->id) }}" enctype="multipart/form-data">
            @csrf
            <table class="custom_normal_table">
                <tbody>
                    <tr>
                        <td colspan="2">
                            <h3 class="f-weight-bold">Edit Employee Payroll</h3>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><strong>Employee:</strong> {{ $payroll->user->name }}</p>
                        </td>
                    </tr>
                    @if (session('success'))
                    <tr>
                        <td>
                            <span class="u-fw-b u-t-success" style="font-size: 16px;">{{ session('success') }}</span>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td>
                            <p>Upload PDF</p>
                            <input class="u-input" id="pdfInput" name="pr_pdf" type="file" accept=".pdf">
                        </td>
                        <td>
                            <p>Pay Date</p>
                            <input class="u-input" id="pr_pay_date" name="pr_pay_date" type="date"
                                value="{{ $payroll->pay_date }}" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Date From:</p>
                            <input class="u-input" name="pr_date_from" type="date" value="{{ $payroll->from_date }}"
                                required>
                        </td>
                        <td>
                            <p>Date To:</p>
                            <input class="u-input" name="pr_date_to" type="date" value="{{ $payroll->to_date }}"
                                required>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="u-flex-end u-flex-wrap">
                <button class="u-t-white u-fw-b u-btn u-bg-primary u-m-10 u-border-1-default btn-close"
                    id="modal-btn-submit" type="submit">Submit</button>
            </div>
            <div class="u-m-10">
                <div class="u-bg-primary u-fw-b u-t-white" style="padding: 20px 10px">
                    Uploaded Payroll
                </div>
                <embed src="{{ route('showPDF', $payroll->file_name) }}" width="100%" height="700px"></embed>
            </div>
        </form>
    </div>
</div>

<br>

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