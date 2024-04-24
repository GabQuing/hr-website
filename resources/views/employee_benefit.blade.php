@extends('layouts.side_top_content' , ['title' => 'Employee Benefit'])

@section('module_name', 'Employee Benefit')

@section('content')

<style>
    .modal-box{
        max-width: 75rem !important;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
    }
    
    input[type=number] {
        appearance: textfield;
        -moz-appearance: textfield;
    }
</style>

<div class="modal-center" style="display: none;">
    <div class="modal-box">
        <div class="modal-content">
            <form method="POST" action="{{ route('employeeBenefitAdd') }}" enctype="multipart/form-data">
                @csrf
                <table class="custom_normal_table">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <h3 class="f-weight-bold">Add Benefit</h3>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Employee Name</p>
                                <select class="u-input" name="users_id" id="users_id" required >
                                    <option value="" selected disabled>None selected</option>
                                    @foreach ( $usernames as $username )
                                        <option value="{{ $username->id }}"
                                            @if ($username->employee_benefits_id)
                                                disabled
                                            @endif
                                        >{{ $username->name }}</option>
                                    @endforeach
                                </select>  
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Healthcare Benefit:</p>
                                <input class="u-input" name="health_care" type="number" min="0" step="0.01" required>
                            </td>
                            <td>
                                <p>Vision Benefit:</p>
                                <input class="u-input" name="vision" type="number" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Dental Benefit:</p>
                                <input class="u-input " name="dental" type="number" required>
                            </td>
                            <td>
                                <p>Pregnancy And Maternity Care:</p>
                                <input class="u-input" name="pregnancy" type="number" required>
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
        <button class="u-btn u-bg-default u-t-dark u-border-1-gray u-box-shadow-default" href="">Add Benefit</button>
    </div>
</div>

@if (session('success'))
    <div class="u-mt-10">
        <span class="u-t-success">{{ session('success') }}</span>
    </div>
@endif

<div class="u-mt-10">
    <table class="myTable" class="display" style="width:100%;">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Healthcare Benefits</th>
                <th>Vision Benefits</th>
                <th>Dental Benefits</th>
                <th>Pregnancy and Maternity Care</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Updated By</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{$user->employee_name}}</td>
                    <td>{{$user->health_care}}</td>
                    <td>{{$user->vision}}</td>
                    <td>{{$user->dental}}</td>
                    <td>{{$user->pregnancy}}</td>
                    <td>{{$user->employee_benefits_created_by}}</td>
                    <td>{{$user->employee_benefits_created_at}}</td>
                    <td>{{$user->employee_benefits_updated_by}}</td>
                    <td>{{$user->employee_benefits_updated_at}}</td>
                    <td>
                        <div class="d-flex;">
                            <a href="" class="material-symbols-outlined u-action-btn u-bg-primary" style="vertical-align: bottom; font-size: 20px; font-weight: bold; color: white; text-decoration: none;">
                                edit
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Employee Name</th>
                <th>Healthcare Benefits</th>
                <th>Vision Benefits</th>
                <th>Dental Benefits</th>
                <th>Pregnancy and Maternity Care</th>
                <th>Created By</th>
                <th>Created At</th>
                <th>Updated By</th>
                <th>Updated At</th>
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

        // Close Modal
        $('#modal-btn-close').on('click', function(){
            $('.modal-center').hide();
        })

        // Open add payroll
        $('#add-payroll-btn').on('click', function(){
            $('.modal-center').show();
        })

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

