@extends('layouts.side_top_content', ['title' => 'Policy & Procedure'])

@section('module_name', 'Policies & Procedures')
<style>
    .profile_info_section{
        padding: 20px;
    }
    .policy_paragraph{
        padding-left: 10px;
        text-indent: 40px;
        margin-top: 5px;
    }
    .policy_bullet {
        display: flex;
    }

    .policy_bullet ul{
        margin: 0 5rem;
    }

    .policy_bullet_sm{
        margin: 0 3rem;
    }

    .table_schedule,
    .table_schedule td,
    .table_schedule th
    {
        text-align: left !important;
    }

    .t-underline{
        text-decoration: underline;
    }

    .modal-box{
        max-width: 75rem !important;
    }
</style>
@section('content')
    <div>
        <button class="u-btn u-bg-default u-t-dark u-border-1-gray u-box-shadow-default open-modal new-policy-btn" >Generate Policy</button>
    </div>
    <div>
        <br>
        @if (session('success'))
            <h5 class="u-fw-b" style="color: green; display:block;">{{ session('success') }}</h5>
        @endif
    </div>
    <div class="modal-center" id="new-policy-modal" style="display: none;">
        <div class="modal-box">
            <div class="modal-content">
                <h4 class="u-fw-b">Generate Policy</h4>
                <form id="new-policy-form" method="POST" action="{{route('policy_procedure.new_policy')}}">
                    @csrf
                    <div style="overflow-x: auto; width: 100%;">
                        <table class="custom_normal_table">
                            <tbody>
                                <tr>
                                    <td>
                                        <p>Policy Title</p>
                                        <input class="u-input" type="text" name="policy_title" id="policy_title" value="" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <p>Policy Content:</p>
                                        <!-- CKEditor Textarea -->
                                        <textarea name="details" id="editor" class="ckeditor" required>
                                        </textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="u-flex-space-between u-flex-wrap">
                        <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default btn-close" type="button">Close</button>
                        <div class="u-flex-space-between">
                            <button class="ob-btns u-t-white u-fw-b u-btn u-bg-accent u-m-5 u-border-1-default" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-center" id="edit-policy-modal" style="display: none;">
        <div class="modal-box">
            <div class="modal-content">
                <h4 class="u-fw-b">Edit Policy</h4>
                <form id="edit-policy-form" method="POST">
                    @csrf
                    <input type="hidden" name="policy_id" id="edit_policy_id">
                    <div style="overflow-x: auto; width: 100%;">
                        <table class="custom_normal_table">
                            <tbody>
                                <tr>
                                    <td>
                                        <p>Policy Title</p>
                                        <input class="u-input" type="text" name="edit_policy_title" id="edit_policy_title" value="" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <p>Policy Content:</p>
                                        <!-- CKEditor Textarea -->
                                        <textarea name="edit_policy_details"  class="ckeditor edit_policy_details">
                                        </textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="u-flex-space-between u-flex-wrap">
                        <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default btn-close" type="button">Close</button>
                        <div class="u-flex-space-between">
                            <button class="ob-btns u-t-white u-fw-b u-btn u-bg-accent u-m-5 u-border-1-default" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-center" id="payroll-calendar-modal" style="display: none;">
        <div class="modal-box">
            <div class="modal-content">
                <form method="POST" action="{{ route('policy_procedure.add_payroll_calendar') }}" enctype="multipart/form-data">
                    @csrf
                    <div style="overflow-x: auto; width: 100%;">
                        <table class="custom_normal_table">
                            <tbody>
                                <tr>
                                    <td colspan="4">
                                        <h3 class="f-weight-bold"><i class="fa-solid fa-eye"></i> Update Payroll Calendar</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Year:</p>
                                        <input type="number" class="u-input" name="calendar_year" required>
                                    </td>
                                    <td>
                                        <p>Image File:</p>
                                        <input type="file" class="u-input" name="image_file" accept=".jpg,.jpeg,.png" required>
                                    </td>                            
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="u-flex-space-between u-flex-wrap">
                        <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default btn-close" id="ob-btn-close" type="button">Close</button>
                        <div class="u-flex-space-between">
                            <button class="ob-btns u-t-white u-fw-b u-btn u-bg-accent u-m-5 u-border-1-default" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="attendance_summary_content" style="display: none;">
        <div class="profile_info_section">
            @foreach($policies as $index => $policy)
                @php
                    $headerClass = $index % 2 == 0 ? 'info_header_design1' : 'info_header_design2';
                    $contentClass = "show_content" . $index; // Unique class for each content section
                @endphp
                <div class="policy-section">
                    <div class="info_header {{ $headerClass }}" data-target=".{{ $contentClass }}">
                        <p>{{ $policy->title }}</p>
                    </div>
                    <div class="{{ $contentClass }} info_padding" style="display: none;">
                        @role('hr|admin')
                        <div class="u-flex-end u-gap-1">
                            <button type="button" class="u-action-btn u-bg-primary btn-edit edit-policy" data-id="{{ $policy->id }}">
                                <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 20px; font-weight: bold;">
                                    edit
                                </span>
                            </button>
                            <button type="button" class="u-action-btn u-bg-primary btn-edit delete-policy" data-id="{{ $policy->id }}">
                                <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 20px; font-weight: bold;">
                                    delete
                                </span>
                            </button>
                        </div>
                        @endrole
                        <div class="pic_input_main_table">
                            {!! $policy ? $policy->details : '<p>No details available.</p>' !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    @section('script_content')
        <script>
            $(document).ready(function () {
                CKEDITOR.config.versionCheck = false;
                CKEDITOR.replace('editor', {
                    height: 300
                });

                $(".info_header").click(function() {
                    const targetClass = $(this).data("target");
                    $(targetClass).slideToggle("fast");
                });

                // Open the modal and set form data dynamically
                $(".edit-policy").click(function () {
                    let policySection = $(this).closest(".policy-section");
                    let policyId = $(this).data("id");
                    let policyTitle = policySection.find(".info_header p").text();
                    let policyDetails = policySection.find(".pic_input_main_table").html();

                    // Set values
                    $("#edit_policy_title").val(policyTitle);
                    $("#edit_policy_id").val(policyId);
                    $("#edit-policy-form").attr("action", `/policy_procedure/update-policy/${policyId}`);

                    // Update CKEditor content
                    CKEDITOR.instances['edit_policy_details'].setData(policyDetails);

                    // Show modal
                    $("#edit-policy-modal").fadeIn();
                });

                // Ensure CKEditor data is included in form submission
                $("#edit-policy-form").submit(function () {
                    for (let instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
                });

                $(document).on("click", ".delete-policy", function () {
                    let policyId = $(this).data("id");

                    Swal.fire({
                        title: "Are you sure?",
                        text: "This policy will be deleted.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, delete it!",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "/policy_procedure/delete-policy/" + policyId,
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                },
                                success: function (response) {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Policy has been deleted.",
                                        icon: "success",
                                        timer: 2000,
                                        showConfirmButton: false,
                                    }).then(() => {
                                        location.reload(); // Reload page to update the list
                                    });
                                },
                                error: function (xhr) {
                                    Swal.fire({
                                        title: "Error!",
                                        text: xhr.responseJSON.error,
                                        icon: "error",
                                    });
                                },
                            });
                        }
                    });
                });

            
                $('.attendance_summary_content').fadeIn('slow');
                $('.btn-close').on('click', function(){
                    $('.modal-center').hide();
                })

                $('.new-policy-btn').on('click', function() {
                    $('#new-policy-modal').show();
                });

                // Select2
                $('.js-example-basic-single').select2({
                    placeholder: 'None Selected',
                    width: '100%',
                });

            });





        </script>
    @endsection
@endsection

