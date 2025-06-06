@extends('layouts.side_top_content', ['title' => 'My Payroll'])

@section('module_name', 'My Payroll')

@section('content')

<style>
    .modal-box {
        max-width: 75rem !important;
    }
</style>

<div class="modal-center" style="display: none;">
    <div class="modal-box">
        <div class="modal-content">
            <br>
            <div class="u-m-10">
                <embed src="" id="pdfShow" width="100%" height="700px"></embed>
            </div>
            <div>
                <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default btn-close"
                    id="modal-btn-close" type="button">Close</button>
                <button class="ob-btns u-t-white u-fw-b u-btn u-bg-accent u-m-5 u-border-1-default"
                    id="modal-btn-download" type="button">Download</button>
            </div>
        </div>
    </div>
</div>

<div class="u-mt-10 user_accounts_table2">
    <table class="myTable" class="display" style="width:100%;">
        <thead>
            <tr>
                <th>Pay Date</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Created By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payrolls as $payroll)
            <tr>
                <td>{{ $payroll->pay_date ? date("F d, Y l", strtotime($payroll->pay_date)) : ''}}</td>
                <td>{{ $payroll->from_date ? date("F d, Y l", strtotime($payroll->from_date)) : ''}}</td>
                <td>{{ $payroll->to_date ? date("F d, Y l", strtotime($payroll->to_date)) : ''}}</td>
                <td>{{ $payroll->created_by_head }}</td>
                <td>
                    <div class="d-flex;">
                        <button file-path="{{ $payroll->file_path }}"
                            class="material-symbols-outlined u-action-btn u-bg-primary payroll-view" id="payroll-view"
                            data-payroll-name="{{ $payroll->file_name }}"
                            style="vertical-align: bottom; font-size: 20px; font-weight: bold; color: white; text-decoration: none;">
                            visibility
                            </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Pay Date</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Created By</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
    {{ $payrolls->links() }}
    <p>Showing {{ $payrolls->firstItem() ?? 0 }} to {{ $payrolls->lastItem() ?? 0 }} of {{ $payrolls->total() }} items.
    </p>
</div>


@endsection

@section('script_content')

<script>
    // $('.myTable').DataTable({
    //     responsive: true
    // });
    $('.myTable').DataTable({
        responsive: true,
        paging:false,
        info:false,
        searching: false,
        "columnDefs": [
            { "className": "dt-center", "targets": "_all" }
        ]
    });

    $('.payroll-view').on('click', function(){
        const payrollName = $(this).data('payroll-name');
        const route = "{{ route('showPDF', ':payrollName') }}".replace(':payrollName', payrollName);
        $('#modal-btn-download').attr('payroll-name', payrollName);
        $('#pdfShow').attr('src', route);
        $('.modal-center').show();
    });

    $(document).on('click', '#modal-btn-download', function(){
        const payrollName = $(this).attr('payroll-name');
        const route = `{{ route('employee_payroll_download') }}?payroll_name=${payrollName}`;
        location.assign(route);
    });

    $('#modal-btn-close').on('click', function(){
        $('.modal-center').hide();
        $('#pdfShow').attr('src');
    });

    
</script>

@endsection