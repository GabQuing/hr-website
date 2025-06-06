@extends('layouts.side_top_content' , ['title' => 'My Profile'])

@section('module_name', 'My Profile')

@section('css')
    <style>

        .select2-container .select2-selection--single{
            height: 33px;

        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            font-size: 13px;
            text-transform: lowercase;
            line-height: 33px;
            text-align: center

        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            font-size: 13px;
            text-transform: uppercase;

        }


        .select2-container--default .select2-results__option {
            font-size: 13px;
            text-transform: lowercase;

        }

        .select2-container--default .select2-results__option {
            font-size: 13px;
            text-transform: uppercase;

        }
        .my-contract-div,
        .employee-contract-div{
            max-width: 75rem !important;
        }

    </style>
@endsection

<div class="modal-center change-password" style="display: none">
    <div class="modal-box">
        <div class="modal-content">
            <form method="POST" action="{{ route('update_password', auth()->user()->id) }}">
                @csrf
                <div style="overflow-x: auto; width: 100%;">
                    <table class="custom_normal_table">
                        <tbody>
                            <tr>
                                <td colspan="4">
                                    <h3 class="f-weight-bold"><i class="fa-solid fa-eye"></i> Change Password</h3>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Current Password:</p>
                                    <input class="u-input" name="current_password" type="password" required>
                                </td>                                                                             
                            </tr>
                            <tr>
                                <td>
                                    <p>New Password:</p>
                                    <input class="u-input" name="new_password" type="password" required>
                                </td>                           
                            </tr>
                            <tr>
                                <td>
                                    <p>Confirm Password:</p>
                                    <input class="u-input" name="confirmation_password" type="password" required>
                                </td>  
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="u-flex-space-between">
                    <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default" id="btn-close-password" type="button">Close</button>
                    <button class="u-t-white u-fw-b u-btn u-bg-accent u-m-10 u-border-1-default" id="btn-close" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@role('hr|admin')
    {{-- Employee Contract --}}
    <div class="modal-center employee-contract" style="display: none;">
        <div class="modal-box employee-contract-div">
            <div class="modal-content">
                <form method="POST" action="{{ route('employee_contract_add')}}" enctype="multipart/form-data">
                    @csrf
                    <table class="custom_normal_table">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <h3 class="f-weight-bold">Employee Contract</h3>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Employee Name</p>
                                    <input class="u-input" id="" value="{{$user_info->name}}" type="text" disabled>
                                    <input class="u-input" id="" value="{{$user_info->id}}" name="employee_id" type="text" hidden readonly>
                                </td>
                                <td>
                                    <p>Upload/Edit PDF</p>
                                    <input class="u-input" id="resumeInput" name="pr_pdf" type="file" accept=".pdf" required>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="u-flex-space-between u-flex-wrap">
                        <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default btn-close" id="btn-close-contract" type="button">Close</button>
                        <button class="u-t-white u-fw-b u-btn u-bg-primary u-m-10 u-border-1-default btn-close" id="modal-btn-submit" type="submit">Submit</button>
                    </div>
                    @if($employee_contract)
                        <div class="u-m-10">
                            <div class="u-bg-primary u-fw-b u-t-white" style="padding: 20px 10px">
                                Uploaded Employee Contract
                            </div>
                                <embed src="{{ route('show_contract', $employee_contract->file_name) }}" width="100%" height="700px"></embed>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
    {{-- Resume --}}
    <div class="modal-center employee-resume" style="display: none;">
        <div class="modal-box employee-contract-div">
            <div class="modal-content">
                <form method="POST" action="{{ route('employee_resume_add', $user_info->id)}}" enctype="multipart/form-data">
                    @csrf
                    <table class="custom_normal_table">
                        <tbody>
                            <tr>
                                <td colspan="2">
                                    <h3 class="f-weight-bold">Employee Resume</h3>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Upload/Edit PDF</p>
                                    <input class="u-input" id="pdfInput" name="resume_pdf" type="file" accept=".pdf" required>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="u-flex-space-between u-flex-wrap">
                        <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default btn-close" id="btn-close-resume" type="button">Close</button>
                        <button class="u-t-white u-fw-b u-btn u-bg-primary u-m-10 u-border-1-default btn-close" id="modal-btn-submit" type="submit">Submit</button>
                    </div>
                    @if($user_info->resume_path)
                        <div class="u-m-10">
                            <div class="u-bg-primary u-fw-b u-t-white" style="padding: 20px 10px">
                                Uploaded Employee Resume
                            </div>
                            <embed src="{{ route('show_resume', "$user_info->id.pdf") }}" width="100%" height="700px"></embed>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endrole
@role('employee')
    <div class="modal-center my-contract" style="display: none;">
        <div class="modal-box  my-contract-div">
            <div class="modal-content">
                <br>
                <div class="u-m-10">
                    <embed src="" id="pdfShow" width="100%" height="700px"></embed>
                </div>
                <div>
                    <button class="u-t-gray-dark u-fw-b u-btn u-bg-default u-m-10 u-border-1-default btn-close" id="modal-btn-close" type="button">Close</button>
                    <button class="ob-btns u-t-white u-fw-b u-btn u-bg-accent u-m-5 u-border-1-default" id="modal-btn-download" type="button">Download</button>
                </div>
            </div>
        </div>
    </div>
@endrole

@section('content')
    @role('hr|admin')
        @if( Request::segment(count(Request::segments())) != 'profile' )
            <label class="my_profile_employee_info" for="">Employee Name: {{ $basic_information->first_name.' '.$basic_information->last_name }}</label>
            <br>
            <label class="my_profile_employee_info" for="">User ID: {{ $basic_information->user_id }}</label>
            <br>
            <button class="u-btn u-mt-5 u-bg-default u-t-dark u-border-1-gray u-box-shadow-default update-contract-modal">Employee Contract</button>
            <button class="u-btn u-mt-5 u-ml-15 u-bg-default u-t-dark u-border-1-gray u-box-shadow-default update-resume-modal">Employee Resume</button>
        @endif
    @endrole
    {{-- My Profile Content --}}
    <div class="profile_content">
        <br>
        @if($show_password)
            <div>
                <a class="u-btn u-bg-default u-t-dark u-border-1-gray u-box-shadow-default open-modal change-password-modal">Change Password</a>
                @role('employee')
                @if($my_contract)
                <button class="u-btn u-bg-default u-t-dark u-border-1-gray u-box-shadow-default my-contract-btn" file-path="{{ $my_contract->file_path }}" data-contract-name="{{ $my_contract->file_name }}" >View Contract</button>
                @endif
                @endrole
            </div>
            <br>
        @endif
        <div>
            @if (session('error'))
                <span style="color: red; display:block;">{{ session('error') }}</span>
            @endif
            @if (session('success'))
                <span style="color: green; display:block;">{{ session('success') }}</span>
            @endif
            @if (session('successUpdated'))
                <span style="color: green; display:block;">{{ session('successUpdated') }}</span>
            @endif
            @if (session('successContract'))
                <span style="color: green; display:block;">{{ session('successContract') }}</span>
            @endif
            @if ($errors->has('new_password'))
                <span style="color: red; display:block;">{{ $errors->first('new_password') }}</span>
            @endif
            @if ($errors->has('confirmation_password'))
                <span style="color: red; display:block;">{{ $errors->first('confirmation_password') }}</span>
            @endif
        </div>
        <div class="profile_info_section">
            <div class="show_profile">
                <br>
                <div class="info_header info_header_design1">
                    <p>Basic Information</p>
                </div>
                <div class="profile_info_content show_content info_padding">
                    <form action="{{ route('mp_update',$basic_information->user_id) }}" method="POST">
                        @csrf
                        <div class="pic">
                            <div class="pic_input">
                                <label>First Name</label>
                                <input type="text" name="first_name" value="{{ $basic_information->first_name }}" readonly>
                            </div >
                            <div class="pic_input">
                                <label>Middle</label>
                                <input type="text" name="middle" value="{{ $basic_information->middle }}" readonly>
                            </div>
                            <div class="pic_input">
                                <label>Last Name</label>
                                <input type="text" name="last_name" value="{{ $basic_information->last_name }}" readonly>
                            </div>
                        </div>
                        <div class="pic">
                            <div class="pic_input">
                                <label>User ID</label>
                                <input type="text" name="system_id" value="{{ $basic_information->user_id }}" readonly>
                            </div>
                            {{-- <div class="pic_input">
                                <label>Employee ID</label>
                                <input type="text" name="employee_id" value="{{ $basic_information->employee_id }}" readonly>
                            </div> --}}
                            <div class="pic_input">
                                <label>Gender</label>
                                <select class="js-example-basic-single s-single" name="gender" id="basic_information_gender" disabled>
                                    <option value="">None selected</option>
                                    @foreach ($genders as $gender)
                                        @if($basic_information->gender_id == $gender->id )
                                            <option value="{{ $gender->id }}" selected>{{ $gender->name }}</option>
                                        @else
                                            <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="pic_input">
                                <label>Civil Status</label>
                                <select class="js-example-basic-single s-single" name="civil_status" id="civil_status" disabled>
                                    <option value="">None selected</option>
                                    @foreach ($civil_status as $civil_statuses)
                                        @if($basic_information->civil_status_id == $civil_statuses->id )
                                            <option value="{{ $civil_statuses->id }}" selected>{{ $civil_statuses->name }}</option>
                                        @else
                                            <option value="{{ $civil_statuses->id }}">{{ $civil_statuses->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="pic">
                            <div class="pic_input">
                                <label>Date of Birth</label>
                                <input type="date" name="date_of_birth" value="{{ $basic_information->date_of_birth }}" readonly>
                            </div>
                            <div class="pic_input">
                                <label>Email</label>
                                <input type="text" name="email" value="{{ $basic_information->email }}" readonly>
                            </div>
                            <div class="pic_input">
                                <label>Mobile Number</label>
                                <input type="text" name="mobile_number" value="{{ $basic_information->mobile_number }}" readonly>
                            </div>
                        </div>
                        @role('hr|admin')
                            @if( Request::segment(count(Request::segments())) == 'show' )
                                <div class="pic">
                                    <input id="basic_information_update" class="my_profile_save_btn" type="submit" name="update" value="Save">
                                </div>
                                @else
                            @endif
                        @endrole
                    </div>
                </form>
            </div>
            <div class="show_work_information">
                <div class="info_header1 info_header_design2">
                    <p>Work Information</p>
                </div>
                <div class="work_information_content show_content1 info_padding">
                    <form action="{{ route('updateWorkInfo',$work_information->user_id) }}" method="POST">
                        @csrf
                        <div class="pic">
                            <p>Basic Job Information</p>
                        </div>
                        <br>
                        <hr>
                        <br>
                        <div class="pic">
                            <div class="pic_input">
                                <label for="">Company</label>
                                <select class="js-example-basic-single s-single" name="company" id="work_info_company" disabled>
                                    <option value="">None selected</option>
                                    @foreach ($companies as $company)
                                        @if($work_information->company_id == $company->id )
                                            <option value="{{ $company->id }}" selected>{{ $company->name }}</option>
                                        @else
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="pic_input">
                                <label for="">Department</label>
                                <select class="js-example-basic-single s-single" name="department" id="work_info_department" disabled>
                                    <option value="">None selected</option>
                                    @foreach ($departments as $department)
                                        @if($work_information->department_id == $department->id )
                                            <option value="{{ $department->id }}" selected>{{ $department->name }}</option>
                                        @else
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="pic_input">
                                <label for="">Title</label>
                                <input type="text" value="{{ $work_information->title }}" name="title" readonly>
                            </div>
                        </div>
                        <div class="pic">
                            <div class="pic_input">
                                <label for="">Employee Type</label>
                                <select class="js-example-basic-single s-single" name="employee_type" id="work_info_employee_type" disabled>
                                    <option value="">None selected</option>
                                    @foreach ($employee_types as $employee_type)
                                        @if($work_information->employee_type_id == $employee_type->id )
                                            <option value="{{ $employee_type->id }}" selected>{{ $employee_type->name }}</option>
                                        @else
                                            <option value="{{ $employee_type->id }}">{{ $employee_type->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="pic_input">
                                <label for="">Immediate Supervisor</label>
                                <input type="text" value="{{ $work_information->immediate_supervisor }}"  name="immediate_supervisor" readonly>
                            </div>
                            <div class="pic_input">
                                <label for="">Designated Work Place</label>
                                <input type="text" value="{{ $work_information->designated_work_place }}"  name="designated_work_place" readonly>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <br>
                        <div class="pic">
                            <p>Employment Details</p>
                        </div>
                        <br>
                        <hr>
                        <br>
                        <div class="pic">
                            <div class="pic_input">
                                <label for="">Employment Status</label>
                                <select class="js-example-basic-single s-single" name="employment_status" id="employment_status" disabled>
                                    <option value="">None selected</option>
                                    @foreach ($employment_statuses as $employment_status)
                                        @if($work_information->employment_status_id == $employment_status->id )
                                            <option value="{{ $employment_status->id }}" selected>{{ $employment_status->name }}</option>
                                        @else
                                            <option value="{{ $employment_status->id }}">{{ $employment_status->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="pic_input">
                                <label for="">User Type</label>
                                <select class="js-example-basic-single s-single" name="user_type" id="user_type" disabled>
                                    <option value="">None selected</option>
                                    @foreach ($user_types as $user_type)
                                        @if($work_information->user_type_id == $user_type->id )
                                            <option value="{{ $user_type->id }}" selected>{{ $user_type->name }}</option>
                                        @else
                                            <option value="{{ $user_type->id }}">{{ $user_type->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="pic_input">
                                <label for="">Job Code</label>
                                <input type="text"  value="{{ $work_information->job_code }}" name="job_code" readonly>
                            </div>
                        </div>
                        <div class="pic">
                            <div class="pic_input">
                                <label for="">Hire Date</label>
                                <input type="date" name="hire_date" value="{{ $work_information->hire_date }}" readonly>
                            </div>
                            <div class="pic_input">
                                <label for="">Expected Regularization Date</label>
                                <input type="date" name="expected_regularization_date" value="{{ $work_information->expected_regularization_date }}" readonly>
                            </div>
                            <div class="pic_input">
                                <label for="">Regularization Date</label>
                                <input type="text" value="{{ $work_information->regularization_date }}" name="regularization_date" readonly>
                            </div>
                        </div>
                        @role('hr|admin')
                        @if( Request::segment(count(Request::segments())) == 'show' )
                            <div class="pic">
                                <input id="work_information_update" class="my_profile_save_btn" type="submit" name="update" value="Save">
                            </div>
                            @else
                        @endif
                        @endrole
                    </form>
                </div>
            </div>
            <div class="show_goverment_information">
                <div class="info_header4 info_header_design1">
                    <p>Work Schedule</p>
                </div>
                <div class="work_schedule_content show_content4 info_padding">
                    <form action="{{ route('updateWorkSchedule',$user_id) }}" method="POST">
                        @csrf
                        <div class="pic">
                            <div class="pic_input">
                                <p>Current Schedule</p>
                            </div>
                            <br>
                            <hr>
                            <br>
                            <div class="pic_input">
                                <label for="">Schedule Type:</label>
                                <select class="js-example-basic-single s-single" name="schedule_type" id="schedule_type" disabled>
                                    <option value="">None selected</option>
                                    @foreach ($schedule_types as $schedule_type)
                                        @if($user_sched->schedule_types_id == $schedule_type->id )
                                            <option value="{{ $schedule_type->id }}" selected>{{ $schedule_type->name }}</option>
                                        @else
                                            <option value="{{ $schedule_type->id }}">{{ $schedule_type->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="pic_input">
                                <label>No of hours to work including break hours:</label>
                                    <input type="text"  id = "working_hours" name="working_hours" value="{{ $work_schedule[0]['working_hours'] }}" readonly>
                            </div>
                            <br>
                            <div class="pic_input_main_table">
                                <table class="table_schedule" id="normal_schedule_table" >
                                    <thead>
                                        <tr >
                                            <th class="header_schedule">Day</th>
                                            <th class="header_schedule">Shift/Core From</th>
                                            <th class="header_schedule">Shift/Core To</th>
                                            <th class="header_schedule">Break Start</th>
                                            <th class="header_schedule">Break End</th>            
                                            <th class="header_schedule">Is Rest Day</th>            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($work_days as $work_day)
                                        @php
                                            $filterArray = array_filter($work_schedule,function($arr) use ($work_day) {
                                                return $arr['work_day'] == $work_day;
                                            });
                                            $key = array_key_first($filterArray);
                                            $filterArray = isset($key) ? $filterArray[$key] : [
                                                "schedule_types_id" => 1,
                                                "working_hours" => "10.00",
                                                "status" => "active",
                                                "created_by" => 1,
                                                "work_day" => $work_day,
                                                "work_from" => null,
                                                "work_to" => null,
                                                "break_start" => null,
                                                "break_end" => null,
                                                "rest_day" => 1,
                                            ];
                                        @endphp
                                        <tr>
                                            <td class="body_schedule">{{ $work_day }}</td>
                                            <td class="body_schedule">
                                                <div class="pic_input_table">
                                                    <input type="time" class="input_time from_{{ strtolower($work_day) }}" value="{{ $filterArray['work_from']}}" name="{{ $work_day }}_from" placeholder="00:00:00" readonly>
                                                </div >
                                            </td>
                                            <td class="body_schedule">
                                                <div class="pic_input_table">
                                                    <input type="time" class="input_time to_{{ strtolower($work_day) }}" value="{{ $filterArray['work_to']}}" name="{{ $work_day }}_to" placeholder="00:00:00" readonly>
                                                </div >
                                            </td>
                                            <td class="body_schedule">
                                                <div class="pic_input_table">
                                                    <input type="time" class="input_time start_{{ strtolower($work_day) }}" value="{{ $filterArray['break_start']}}" name="{{ $work_day }}_start" placeholder="00:00:00" readonly>
                                                </div >
                                            </td>
                                            <td class="body_schedule">
                                                <div class="pic_input_table">
                                                    <input type="time" class="input_time end_{{ strtolower($work_day) }}" value="{{ $filterArray['break_end']}}" name="{{ $work_day }}_end" placeholder="00:00:00" readonly>
                                                </div >
                                            </td>
                                            <td class="body_schedule">
                                                <div class="pic_input_table">
                                                    <input type="checkbox" day="{{ $work_day }}" class="c_box view_sched_cbox checkbox rest_{{ strtolower($work_day) }}" name="{{ $work_day }}_rest" disabled {{ $filterArray['rest_day'] ? 'checked' : '' }}>
                                                </div >
                                            </td>
                                            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @role('hr|admin')
                        @if( Request::segment(count(Request::segments())) == 'show' )
                            <div class="pic">
                                <br>
                                <input id="work_schedule_update" class="my_profile_save_btn" type="submit" name="update" value="Save">
                            </div>
                            @else
                        @endif
                        @endrole
                    </div>
                </form>
            </div>
            <div class="show_goverment_information">
                <div class="info_header2 info_header_design2">
                    <p>Bank Information</p>
                </div>
                <form action="{{ route('updateGovernmentInfo',$government_information->user_id) }}" method="POST">
                    @csrf
                    <div class="goverment_information_content show_content2 info_padding">
                        <div class="pic">
                            <div class="pic_input">
                                <label>Name</label>
                                <input type="text"  value="{{ $government_information->name }}" name="name" readonly>
                            </div>
                            <div class="pic_input">
                                <label>Address</label>
                                <input type="text"  value="{{ $government_information->address }}" name="address" readonly>
                            </div>
                            <div class="pic_input">
                                <label>Bank Name</label>
                                <input type="text"  value="{{ $government_information->bank_name }}" name="bank_name" readonly>
                            </div>
                            <div class="pic_input">
                                <label>Bank Address</label>
                                <input type="text"  value="{{ $government_information->bank_address }}" name="bank_address" readonly>
                            </div>
                            <div class="pic_input">
                                <label>Bank Account Number</label>
                                <input type="text"  value="{{ $government_information->bank_account_number }}" name="bank_account_number" readonly>
                            </div>
                            <div class="pic_input">
                                <label>Bank Swift Code</label>
                                <input type="text"  value="{{ $government_information->bank_swift_code }}" name="bank_swift_code" readonly>
                            </div>
                            <div class="pic_input">
                                <label>Bank Routing Number</label>
                                <input type="text"  value="{{ $government_information->bank_routing_number }}" name="bank_routing_number" readonly>
                            </div>
                            <div class="pic_input">
                                <label>Mobile Number</label>
                                <input type="text" name="mobile_number" value="{{ $basic_information->mobile_number }}" disabled>
                            </div>
                        </div>
                        @role('hr|admin')
                        @if( Request::segment(count(Request::segments())) == 'show' )
                            <div class="pic">
                                <input id="government_information_update" class="my_profile_save_btn" type="submit" name="update" value="Save">
                            </div>
                            @else
                        @endif
                        @endrole
                    </form>
                </div>
            </div>
            <div class="show_education_background">
                <div class="info_header3 info_header_design1">
                    <p>Education Background</p>
                </div>
                <div class="education_background_content show_content3 info_padding">
                    <form action="{{ route('updateEducationBackground',$education_background->user_id) }}" method="POST">
                        @csrf
                        <div class="pic">
                            <div class="pic_input">
                                <label>Education Type</label>
                                <select class="js-example-basic-single s-single" name="education_type" id="education_type" disabled>
                                    <option value="">None selected</option>
                                    @foreach ($education_types as $education_type)
                                        @if($education_background->education_type_id == $education_type->id )
                                            <option value="{{ $education_type->id }}" selected>{{ $education_type->name }}</option>
                                        @else
                                            <option value="{{ $education_type->id }}">{{ $education_type->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="pic_input">
                                <label>School</label>
                                <input type="text" name="school" value="{{ $education_background->school }}" readonly>
                            </div>
                            <div class="pic">
                                <div class="pic_input">
                                    <label>From</label>
                                    <input type="date" name="from" value="{{ $education_background->from }}" readonly>
                                </div>
                                <div class="pic_input">
                                    <label>To</label>
                                    <input type="date" name="to" value="{{ $education_background->to }}" readonly>
                                </div>
                                <div class="pic_input">
                                    <label>Degree</label>
                                    <input type="text" name="degree" value="{{ $education_background->degree }}" readonly>
                                </div>
                            </div>
                        </div>
                        @role('hr|admin')
                        @if( Request::segment(count(Request::segments())) == 'show' )
                            <div class="pic">
                                <input id="education_background_update" class="my_profile_save_btn" type="submit" name="update" value="Save">
                            </div>
                            @else
                        @endif
                        @endrole
                    </form>
                </div>
            </div>
            <div class="show_contact_information">
                <div class="info_header5 info_header_design2">
                    <p>Contact Information</p>
                </div>
                <form action="{{ route('updateContactInformation',$contact_information->user_id) }}" method="POST">
                    @csrf
                    <div class="contact_information_content show_content5 info_padding">
                        <div class="pic">
                            <p>Employee Contact</p>
                        </div>
                        <br>
                        <hr>
                        <br>
                        <div class="pic">
                            <div class="pic_input">
                                <label>Mobile Number</label>
                                <input type="text"  value="{{ $basic_information->mobile_number }}" name="mobile_number" disabled>
                            </div>
                            {{-- <div class="pic_input">
                                <label> Local Trunk Line</label>
                                <input type="text"  value="{{ $contact_information->local_trunk_line }}" name="local_trunk_line" readonly>
                            </div>
                            <div class="pic_input">
                                <label>Pin</label>
                                <input type="text"  value="{{ $contact_information->pin }}" name="pin" readonly>
                            </div> --}}
                        </div>
                        <br>
                        <hr>
                        <br>
                        <div class="pic">
                            <p>Address</p>
                        </div>
                        <br>
                        <hr>
                        <br>
                        <div class="pic">
                            <div class="pic_input">
                                <label>Address</label>
                                <input type="text"  value="{{ $contact_information->home_address }}" name="home_address" readonly>
                            </div>
                            <div class="pic_input">
                                <label> City</label>
                                <input type="text"  value="{{ $contact_information->home_city }}" name="home_city" readonly>
                            </div>
                            <div class="pic_input">
                                <label>State/Province</label>
                                <input type="text"  value="{{ $contact_information->state_province }}" name="state_province" readonly>
                            </div>
                            <div class="pic_input">
                                <label>Zip Code</label>
                                <input type="text"  value="{{ $contact_information->zip_code }}" name="zip_code" readonly>
                            </div>
                            <div class="pic_input">
                                <label>Country</label>
                                <input type="text"  value="{{ $contact_information->country }}" name="country" readonly>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <br>
                        <div class="pic">
                            <p>Emergency Contact Information</p>
                        </div>
                        <br>
                        <hr>
                        <br>
                        <div class="pic">
                            <div class="pic_input">
                                <label>Contact Number</label>
                                <input type="text"  value="{{ $contact_information->contact_number }}" name="contact_number" readonly>
                            </div>
                            <div class="pic_input">
                                <label> Contact Name</label>
                                <input type="text"  value="{{ $contact_information->contact_name }}" name="contact_name" readonly>
                            </div>
                            <div class="pic_input">
                                <label>Relationship</label>
                                <input type="text"  value="{{ $contact_information->relationship }}" name="relationship" readonly>
                            </div>
                            <div class="pic_input">
                                <label>Address</label>
                                <input type="text"  value="{{ $contact_information->address }}" name="address" readonly>
                            </div>
                        </div>
                        
                        @role('hr|admin')
                        @if( Request::segment(count(Request::segments())) == 'show' )
                            <div class="pic">
                                <input id="contact_information_update" class="my_profile_save_btn" type="submit" name="update" value="Save">
                            </div>
                            @else
                        @endif
                        @endrole
                    </form>
                </div>
            </div>
        </div>
    </div>

@section('script_content')

<script>

    function getSched(selectedValue){
        console.log(selectedValue);
            $.ajax({
                url:"{{ route('getSchedule') }}",
                type:"POST",
                dataType:"json",
                data:{
                    _token:"{{ csrf_token() }}",
                    scheduleType:selectedValue,
                },
                success:function(res){
                    // console.log(res);
                    displaySched(res);

                },
                error:function(res){
                    console.log(res);
                    alert('Failed')
                },
            });
    };

    function displaySched(res){
        $("#normal_schedule_table").fadeIn({
            done: function() {
                console.log(res)
                const scheduleEntries = res.entry;
                $('#working_hours').val(res.working_hours);
                scheduleEntries.forEach(function(entry){
                    const day = entry.work_day.toLowerCase();
                    const fromInput = $(".from_" + day);
                    const toInput = $(".to_" + day);
                    const startInput = $(".start_" + day);
                    const endInput = $(".end_" + day);
                    const restCheckbox = $(".rest_" + day);
                    fromInput.val(entry.work_from);
                    toInput.val(entry.work_to);
                    startInput.val(entry.break_start);
                    endInput.val(entry.break_end);
                    if (entry.rest_day == 1){
                    restCheckbox.prop('checked',true);
                    restCheckbox.closest('tr').find('input').val('');
                    restCheckbox.closest('tr').find('input').attr('readonly', true);
                    } else {
                        restCheckbox.prop('checked',false);
                    };
                });
            }
        });
    };

    if ("{{ session('success') }}"){
        setTimeout(function(){
            window.location.href = "{{ route('logout') }}"
        }, 2000);
    }
    $('.info_header').click(function(){
        $('.show_content').slideToggle('fast');
    })

    $('.info_header1').click(function(){
        $('.show_content1').slideToggle('fast');
    })

    $('.info_header2').click(function(){
        $('.show_content2').slideToggle('fast');
    })

    $('.info_header3').click(function(){
        $('.show_content3').slideToggle('fast');
    })
    $('.info_header4').click(function(){
        $('.show_content4').slideToggle('fast');
    })
    $('.info_header5').click(function(){
        $('.show_content5').slideToggle('fast');
    })


    // Select2
    $('.js-example-basic-single').select2({
        placeholder: 'None Selected',
        width: '100%',
    });

    let user_auth = '{{auth()->user()->getRoleNames()->first()}}';
    let url_segment = '{{ Request::segment(count(Request::segments())) }}'

    // Check Authentication
    if((user_auth == 'admin' || user_auth == 'hr') && (url_segment != 'profile')){
        $('select').removeAttr('disabled');
        $('input').not('.input_time').removeAttr('readonly');

    }
    //Change Work Schedule
    $(document).ready(function(){
        $('#schedule_type').on('change',function(){
            $(this).find('option.sched-none').attr('disabled',true);
            const selectedValue = $(this).val()
            getSched(selectedValue);
            // console.log(selectedValue);
        });
    });


    $('#pdfInput').on('change', function() {
        var file = this.files[0];
        var fileType = file.type;
        if (fileType !== 'application/pdf') {
            alert('Please select a PDF file.');
            $(this).val(''); 
        }
    }); 

    //Disabled TimeSchedule by Checkbox

    $(document).ready(function() {

        $('.change-password-modal').on('click', function(){
            $('.change-password').show();
        })

        $('#btn-close-password').on('click', function(){
            $('.change-password').hide();
        })
        $('.update-contract-modal').on('click', function(){
            $('.employee-contract').show();
        })
        $('#btn-close-contract').on('click', function(){
            $('.employee-contract').hide();
        })

        $('.update-resume-modal').on('click', function(){
            $('.employee-resume').show();
        })
        $('#btn-close-resume').on('click', function(){
            $('.employee-resume').hide();
        })

        $('#modal-btn-close').on('click', function(){
            $('.my-contract').hide();
        })

        if($('.checkbox_sunday').val() === '1'){
            $('.input_time_sunday').prop('readonly', true).val('--:--:--').attr('placeholder', '--:--:--');
            $('.checkbox_sunday').prop('checked', true);
        }
        if($('.checkbox_monday').val() === '1'){
            $('.input_time_monday').prop('readonly', true).val('--:--:--').attr('placeholder', '--:--:--');
            $('.checkbox_monday').prop('checked', true);
        }
        if($('.checkbox_tuesday').val() === '1'){
            $('.input_time_tuesday').prop('readonly', true).val('--:--:--').attr('placeholder', '--:--:--');
            $('.checkbox_tuesday').prop('checked', true);
        }
        if($('.checkbox_wednesday').val() === '1'){
            $('.input_time_wednesday').prop('readonly', true).val('--:--:--').attr('placeholder', '--:--:--');
            $('.checkbox_wednesday').prop('checked', true);
        }
        if($('.checkbox_thursday').val() === '1'){
            $('.input_time_thursday').prop('readonly', true).val('--:--:--').attr('placeholder', '--:--:--');
            $('.checkbox_thursday').prop('checked', true);
        }
        if($('.checkbox_friday').val() === '1'){
            $('.input_time_friday').prop('readonly', true).val('--:--:--').attr('placeholder', '--:--:--');
            $('.checkbox_friday').prop('checked', true);
        }
        if($('.checkbox_saturday').val() === '1'){
            $('.input_time_saturday').prop('readonly', true).val('--:--:--').attr('placeholder', '--:--:--');
            $('.checkbox_saturday').prop('checked', true);
        }

        $('.checkbox_sunday').change(function() {
        if ($(this).is(':checked')) {
            $('.input_time_sunday').prop('readonly', true).val('--:--:--').attr('placeholder', '--:--:--');
            $(this).val(1);
        } else {
            $('.input_time_sunday').prop('readonly', false).val('').attr('placeholder', '00:00:00');
        }
        });
        $('.checkbox_monday').change(function() {
        if ($(this).is(':checked')) {
            $('.input_time_monday').prop('readonly', true).val('--:--:--').attr('placeholder', '--:--:--');
            $(this).val(1);
        } else {
            $('.input_time_monday').prop('readonly', false).val('').attr('placeholder', '00:00:00');
        }
        });
        $('.checkbox_tuesday').change(function() {
        if ($(this).is(':checked')) {
            $('.input_time_tuesday').prop('readonly', true).val('--:--:--').attr('placeholder', '--:--:--');
            $(this).val(1);
        } else {
            $('.input_time_tuesday').prop('readonly', false).val('').attr('placeholder', '00:00:00');
        }
        });
        $('.checkbox_wednesday').change(function() {
        if ($(this).is(':checked')) {
            $('.input_time_wednesday').prop('readonly', true).val('--:--:--').attr('placeholder', '--:--:--');
            $(this).val(1);
        } else {
            $('.input_time_wednesday').prop('readonly', false).val('').attr('placeholder', '00:00:00');
        }
        });
        $('.checkbox_thursday').change(function() {
        if ($(this).is(':checked')) {
            $('.input_time_thursday').prop('readonly', true).val('--:--:--').attr('placeholder', '--:--:--');
            $(this).val(1);
        } else {
            $('.input_time_thursday').prop('readonly', false).val('').attr('placeholder', '00:00:00');
        }
        });
        $('.checkbox_friday').change(function() {
        if ($(this).is(':checked')) {
            $('.input_time_friday').prop('readonly', true).val('--:--:--').attr('placeholder', '--:--:--');
            $(this).val(1);
        } else {
            $('.input_time_friday').prop('readonly', false).val('').attr('placeholder', '00:00:00');
        }
        });
        $('.checkbox_saturday').change(function() {
        if ($(this).is(':checked')) {
            $('.input_time_saturday').prop('readonly', true).val('--:--:--').attr('placeholder', '--:--:--');
            $(this).val(1);
        } else {
            $('.input_time_saturday').prop('readonly', false).val('').attr('placeholder', '00:00:00');

        }
        });
    });


    $('.my-contract-btn').on('click', function(){
        const contractName = $(this).data('contract-name');
        const route = "{{ route('show_contract', ':contractName') }}".replace(':contractName', contractName);
        $('#modal-btn-download').attr('contract-name', contractName);
        $('#pdfShow').attr('src', route);
        $('.my-contract').show();
    });

    $(document).on('click', '#modal-btn-download', function(){
        const contractName = $(this).attr('contract-name');
        const route = `{{ route('employee_contract_download') }}?contract_name=${contractName}`;
        location.assign(route);
    });

    // Update Basic Information
    $('#basic_information_update').click(function(event){
        event.preventDefault();
        let form = $(this).closest('form');
        let url = form.attr('action');
        console.log(url);
        let serialize = form.serialize()
        console.log(serialize);

        $.ajax({
            url: url,
            data: serialize,
            dataType: 'json',
            type: 'POST',

            success: function(response){
                console.log(response);
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    customClass: {
                        toast: 'bottom-0 end-0',
                    },
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Updated successfully'
                })
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })

    })

    $('#work_information_update').click(function(event){
        event.preventDefault();
        let form = $(this).closest('form');
        let url = form.attr('action');
        console.log(url);
        let serialize = form.serialize()
        console.log(serialize);

        $.ajax({
            url: url,
            data: serialize,
            dataType: 'json',
            type: 'POST',

            success: function(response){
                console.log(response);
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    customClass: {
                        toast: 'bottom-0 end-0',
                    },
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Updated successfully'
                })
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })

    })
    $('#government_information_update').click(function(event){
        event.preventDefault();
        let form = $(this).closest('form');
        let url = form.attr('action');
        console.log(url);
        let serialize = form.serialize()
        console.log(serialize);

        $.ajax({
            url: url,
            data: serialize,
            dataType: 'json',
            type: 'POST',

            success: function(response){
                console.log(response);
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    customClass: {
                        toast: 'bottom-0 end-0',
                    },
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Updated successfully'
                })
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })

    })

    $('#education_background_update').click(function(event){
        event.preventDefault();
        let form = $(this).closest('form');
        let url = form.attr('action');
        console.log(url);
        let serialize = form.serialize()
        console.log(serialize);

        $.ajax({
            url: url,
            data: serialize,
            dataType: 'json',
            type: 'POST',

            success: function(response){
                console.log(response);
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    customClass: {
                        toast: 'bottom-0 end-0',
                    },
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Updated successfully'
                })
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })

    })
    $('#contact_information_update').click(function(event){
        event.preventDefault();
        let form = $(this).closest('form');
        let url = form.attr('action');
        console.log(url);
        let serialize = form.serialize()
        console.log(serialize);

        $.ajax({
            url: url,
            data: serialize,
            dataType: 'json',
            type: 'POST',

            success: function(response){
                console.log(response);
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    customClass: {
                        toast: 'bottom-0 end-0',
                    },
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Updated successfully'
                })
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })

    })
    $('#work_schedule_update').click(function(event){
        event.preventDefault();
        let form = $(this).closest('form');
        let url = form.attr('action');
        console.log(url);
        let serialize = form.serialize()
        console.log(serialize);

        $.ajax({
            url: url,
            data: serialize,
            dataType: 'json',
            type: 'POST',

            success: function(response){
                
                console.log(response);
                // return;
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    customClass: {
                        toast: 'bottom-0 end-0',
                    },
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Updated successfully'
                })
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
            }
        })

    })

    //RegisterFace Biometric
    $('#register_face_btn').on('click', function(event){
        event.preventDefault();

        Swal.fire({
            title: 'IMPORTANT!',
            text: "You will have to wait for admin's approval before using the HR attendance system.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#006064',
            cancelButtonColor: '#2F4F4F',
            confirmButtonText: 'Continue',
            customClass: {
                title: 'swal-title-face',
                text: 'swal-text-face',
                icon: 'swal-icon-face'
            },
        }).then((result) => {
            if (result.isConfirmed) {
                var userId = "{{ auth()->user()->id }}";
                var redirectUrl = "registerFace/" + userId;
                window.location.href = redirectUrl;
            }
        });



    });

</script>
@endsection

@endsection
