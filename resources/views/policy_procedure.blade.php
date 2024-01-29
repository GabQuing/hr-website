@extends('layouts.side_top_content')

@section('module_name', 'Policies & PRocedures')
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
</style>
@section('content')
    <div class="attendance_summary_content" style="display: none;">
        <div class="profile_info_section">
            <div class="show_profile">
                <br>
                <div class="info_header info_header_design1">
                    <p>Attendance Related</p>
                </div>
                <div class="profile_info_content show_content info_padding">
                    <div class="pic">
                        <h5>Policy on Punctuality</h5>
                    </div>
                    <hr>
                    <div class="policy_paragraph">
                        <p>
                            Sanction for Tardiness and Abuse of Punctuality Policy – If the employee incurs five (5) or more instances of tardiness in a month, or an accumulation of one hundred eighty minutes (180) or more in a month, the following corrective action will apply:
                        </p>
                    </div>
                    <br>
                    <div class="policy_bullet">
                        <ul>
                            <li>First Offense - 1st Warning</li>
                            <li>Second Offense - 2nd Warning</li>
                            <li>Third Offense - Consultation</li>
                            <li>Fourth Offense - 3rd warning and notice of suspension</li>
                            <li>Fifth Offense - Termination</li>
                        </ul>
                    </div>
                    <br>
                    <div class="pic">
                        <h5>Work and Break Time Schedule</h5>
                    </div>
                    <hr>
                    <br>
                    <div class="pic_input_main_table">
                        <table class="table_schedule" id="normal_schedule_table" >
                            <tbody>
                                <tr>
                                    <td>Login to MS Teams before or on 8:00 AM AK TIME by posting the following in Lurtsema Communications General Channel:</td>
                                    <td>Continue to update your post for the day with the tasks you’re starting to do for task-time monitoring purposes. Example: Good Morning, grateful for... [the things that you are grateful for today] Today, I’m working on... [State what task that you’re going to start with]</td>
                                </tr>
                                <tr>
                                    <td>Attend Team Meetings</td>
                                    <td>Employee must attend team meetings to briefly discuss the the agenda of the day and overview of client statuses.</td>
                                </tr>
                                <tr>
                                    <td>1 Hour Break</td>
                                    <td>After Four (4) hours of logging in, Employee is allowed to take a 1-hour break. However, Employee is not allowed to take a break when there is 1 hour left before the end of work hours.</td>
                                </tr>
                                <tr>
                                    <td>Respond to a Task Roll Call by Founder</td>
                                    <td>Founder will randomly call out a Task Roll Call at any time during work hours. Employee must be ready to comment on the post what they’re working on.</td>
                                </tr>
                                <tr>
                                    <td>Late and Absences</td>
                                    <td>
                                        <p>Employees who will take a day off due to </p>
                                        <div class="policy_bullet_sm">
                                            <ul>
                                                <li>First Offense - 1st Warning</li>
                                                <li>Second Offense - 2nd Warning</li>
                                                <li>Third Offense - Consultation</li>
                                                <li>Fourth Offense - 3rd warning and notice of suspension</li>
                                                <li>Fifth Offense - Termination</li>
                                            </ul>
                                        </div>
                                        <br>
                                        <p>
                                            Must send an advance notice 3 hours before the shift. If not, the
                                            absence will be credited in the employee's paid time leave (PTO).
                                        </p>
                                        <br>
                                        <p>
                                            If an employee is unable to attend work due to illness, they must
                                            notify their immediate supervisor or the designated contact within
                                            the first hour of the workday. Failure to provide timely notice may
                                            result in disciplinary action.
                                        </p>
                                        <br>
                                        <p>
                                            <span class="t-underline">Employees are required to provide a medical certificate from
                                                a licensed healthcare professional for absences. 
                                            </span>
                                            The medical
                                            certificate should include the date of the consultation, the nature of
                                            the illness, and the expected duration of the absence.
                                        </p>
                                        <br>
                                        <p>
                                            If an employee does not have sufficient accrued PTO to cover the
                                            sick leave period, the deficit will be deducted from their future PTO
                                            accruals.
                                        </p>
                                        <br>
                                        <p>
                                            Employees with Internet or Power Interruptions should give
                                            immediate notice and an estimated time-frame as to when the
                                            connection will come back. If no notice was given within duty hours,
                                            this will be counted as an absence. 
                                        </p>
                                        <br>
                                        <div class="policy_bullet_sm">
                                            <ul>
                                                <li>Case-to-Case Basis</li>
                                                <li>Emergencies include but are not limited to:</li>
                                                <li>Grievances</li>
                                                <li>Vehicular Accident</li>
                                                <li>Hospitalization</li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Offsetting Lost Times</td>
                                    <td>Employees must offset lost minutes/hours before the payroll cut-off. If Employees cannot offset lost time before the payroll cut-off, upcoming payroll will be deducted based on hours lost</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br>
                </div>
            <div class="show_education_background">
                <div class="info_header7 info_header_design2">
                    <p>Regularization Process</p>
                </div>
                <div class="education_background_content show_content7 info_padding">
                    <div class="pic">
                        <h5>Employee Regularization</h5>
                    </div>
                    <hr>
                    <div class="policy_paragraph">
                        <p>Regularization of employee services after a thorough performance assessment and review upon the sixth (3rd) month of service for probationary. After the Q1 Performance Review, this status will entitle the Employee to all benefits and privileges due to a regular employee.                    </p>
                    </div>
                    <br>
                    <div class="pic">
                        <h5>Employee Regularization</h5>
                    </div>
                    <hr>
                    <div class="policy_paragraph">
                        <p>Regularization of employee services after a thorough performance assessment and review upon the sixth (3rd) month of service for probationary. After the Q1 Performance Review, this status will entitle the Employee to all benefits and privileges due to a regular employee.                    </p>
                    </div>
                    <br>
                    <div class="pic">
                        <h5>Employee Probation</h5>
                    </div>
                    <hr>
                    <div class="policy_paragraph">
                        {{-- <p>3 months probationary. Evaluation, if will continue as a regular employee.</p> --}}
                    </div>
                    <br>
                    <div class="pic">
                        <h5>3-DAY Work trial</h5>
                    </div>
                    <hr>
                    <div class="policy_paragraph">
                        <p>The 3-day work trial serves as an assessment period during which candidates or employees can experience the role and work environment firsthand.New hires in the 3-day work trial will not receive monetary compensation for their time during the trial period.</p>
                    </div>
                </div>
            </div>
            <div class="show_work_information">
                <div class="info_header1 info_header_design1">
                    <p>Pay Salary Related</p>
                </div>

                <div class="work_information_content show_content1 info_padding">
                    <div class="pic">
                        <h5>Schedule of pay cycle for the year of 2024</h5>
                    </div>
                    <div>
                        <img src="{{ asset('img/pay_salary_date.png') }}" alt="" style="object-fit: contain; width: 100%;">
                    </div>
                    <div class="pic_input_main_table">
                        <table class="table_schedule" id="normal_schedule_table" >
                            <tbody>
                                <tr>
                                    <td>Payroll Details</td>
                                    <td>Every cut-off before or after Employee receives their pay, they shall receive a payslip that indicates employee information, pay periodand date, Year to Date Earnings, designation, employee type, monthly rate. Included in the non-taxable earnings like regular basic, and regular overtime. Also included are other pay (i.e. commissions), health benefits (I.e. dental and eyecare), other deductions (i.e. loans, undertime). Payslip will only be considered valid if signed by the Founder</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br>
                </div>
            </div>
            <div class="show_goverment_information">
                <div class="info_header4 info_header_design2">
                    <p>Benefits And Monetary Conversions</p>
                </div>
                <div class="work_schedule_content show_content4 info_padding">
                <div class="policy_bullet">
                    <ul>
                        <li>Only regular and full-time employees are entitled for paid leaves.</li>
                        <li>Employees will receive their leave credits upon regularization.</li>
                        <li>All absentees without official leave (AWOL), and approved or unapproved absences without any leave balance shall be unpaid.</li>
                        <li>Employees are required to attain approval from their immediate supervisor and/or manager, seven (7) working days before the date of the start of the vacation leave.</li>
                    </ul>
                </div>
                <br>
                <div class="pic">
                    <h5>Paid Time-off or Vacation leave benefit</h5>
                </div>
                <hr>
                <div class="policy_paragraph">
                    <p>Entitled to a maximum of 10 leave credits annually, if not used, can be converted to cash by the following year.</p>
                </div>
                <br>
                <div class="pic">
                    <h5>Birthday leave benefit</h5>
                </div>
                <hr>
                <div class="policy_paragraph">
                    <p>Paid leave given to a regular employee during their work anniversary with the Company. The earned leave credit shall be valid to use within ninety (30) days from the date of the employee’s work birthday.</p>
                </div>
                <br>
                <div class="pic">
                    <h5>Special Leave Benefits</h5>
                </div>
                <hr>
                <div class="policy_paragraph">
                    <p>Maternity leave.</p>
                </div>
                <br>
                <hr>
                <br>
                <div class="pic_input_main_table">
                    <table class="table_schedule" id="normal_schedule_table" >
                        <tbody>
                            <tr>
                                <td>Paid Time-Off (PTO) Approval</td>
                                <td>Employees are required to submit their PTO requests at least 3 days in advance of the intended time off. This advanced notice helps us plan for staffing and work distribution. Lurtsema Communciations understands that exceptional circumstances can arise. In such cases, employees should communicate with Founder or their supervisor to discuss potential alternatives or accommodations.</td>
                            </tr>
                            <tr>
                                <td>Attend Team Meetings</td>
                                <td>Employee must attend team meetings to briefly discuss the the agenda of the day and overview of client statuses.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="show_goverment_information">
                <div class="info_header2 info_header_design1">
                    <p>Other Employee Benefits</p>
                </div>
                <div class="goverment_information_content show_content2 info_padding">
                    <div class="pic_input_main_table">
                        <table class="table_schedule" id="normal_schedule_table" >
                            <tbody>
                                <tr>
                                    <td>10 Days Paid Leave or the whole year</td>
                                    <td>Gain 1 day paid off every month</td>
                                    <td>For regular employees only</td>
                                    <td>Example: If started July 2023 (Date of regularization) 10 days PTO/12 Months = 0.8 July to December 2023 (5 Months) 0.8x(5months) = 4 PTO credits</td>
                                </tr>
                                <tr>
                                    <td>Conversion of the remaining paid leave</td>
                                    <td>Every January (the next year)</td>
                                    <td>For regular employees only</td>
                                    <td>1 day salary rate = 1 PTO credit</td>
                                </tr>
                                <tr>
                                    <td>Extended Leave</td>
                                    <td>Unpaid</td>
                                    <td>Considered as absent and must offset before the payroll cut-of</td>
                                    <td>Extended Leaves, when taken after exhausting all available PTO, are unpaid. This means that during the period of Extended Leave, the employee will not receive their regular salary or wages.  To compensate for the unpaid hours during Extended Leave, employees are required to offset the lost hours by extending their workdays or making other arrangements before the payroll cut-off date.</td>
                                </tr>
                                <tr>
                                    <td>PH Holiday Off</td>
                                    <td>Must be approved by the Founder</td>
                                    <td>Considered as absent and must offset before the payroll cut-of</td>
                                    <td>Lurtsema Communications recognizes public holidays in the Philippines. Employees eligible for approved PH time off will receive their regular pay for the designated public holiday, even if they do not work on that day. If the employee brought up to work on that day, they will be compensated by getting paid twice of their daily pay.</td>
                                </tr>
                                <tr>
                                    <td>13th Month Pay</td>
                                    <td>Last month of the year</td>
                                    <td>For regular employees only</td>
                                    <td>Example:
                                        If started July 2023 (Date of
                                        regularization)<br><br> July to December 2023 (5 Months in the company) <br><br>Monthly salary: 20,000 X 5 Months = 100,000<br><br> 100,000 (5months salary combined) / 12 Months <br><br>= 8,333 (13th Month Pay)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="show_attendance_related">
                <div class="info_header3 info_header_design2">
                    <p>Health And Medical Benefits</p>
                </div>
                <div class="attendance_related_content show_content3 info_padding">
                    <div class="policy_paragraph">
                        <p>All medical expenses should have receipts for the reimbursement. The following benefits are valid and must be utilized within the year. Otherwise, it will not be converted to cash, or added to the following year’s benefits</p>
                    </div>
                    <br>
                    <br>
                    <div class="pic_input_main_table">
                        <table class="table_schedule" id="normal_schedule_table" >
                            <tbody>
                                <tr>
                                    <td>Healthcare Benefits</td>
                                    <td>Medical Checkups and laboratories</td>
                                    <td>PHP 6,000.00</td>
                                </tr>
                                <tr>
                                    <td>Vision Benefits</td>
                                    <td>Eye tests or eyeglass</td>
                                    <td>PHP 3,500.00</td>
                                </tr>
                                <tr>
                                    <td>Dental Benefits</td>
                                    <td>Dental Checkups and others</td>
                                    <td>PHP 6,000.00</td>
                                </tr>
                                <tr>
                                    <td rowspan="2">Pregnancy and Maternity Care</td>
                                    <td>Expenses</td>
                                    <td>PHP 5,000.00 </td>
                                </tr>
                                <tr>
                                    <td colspan="2">1 Month Salary (Paid Maternity Leave)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="show_contact_information">
                <div class="info_header5 info_header_design1">
                    <p>Overtime Pay Sample Computations</p>
                </div>
                <div class="contact_information_content show_content5 info_padding">
                    <br>
                    <div class="pic_input_main_table">
                        <table class="table_schedule" id="normal_schedule_table" >
                            <tbody>
                                <tr>
                                    <td>Additional 30% on OT</td>
                                    <td>OT must be approved by the Founder</td>
                                    <td>Weekdays (1.5x) <br><br>Weekend (1.5x) <br><br>Holiday (2x)</td>
                                    <td>Example: <br><br>2nd cut-off salary: 10,000 10 working days <br><br>1,000 per day / (8hrs shift) 125 (per hour) X 1.5 = 187.5 (OT per hour) <br><br>Overtime hours: 10 <br><br>187.5 PER HOUR X 10 OT = 1,875 </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="show_education_background">
                <div class="info_header6 info_header_design2">
                    <p>Document Change Tracker</p>
                </div>
                <div class="education_background_content show_content6 info_padding">
                    <div class="pic_input_main_table">
                        <table class="table_schedule" id="normal_schedule_table" >
                            <thead>
                                <td>Version</td>
                                <td>Modified by</td>
                                <td>Date Modified</td>
                                <td>Effectivity Date</td>
                                <td>Status</td>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.0</td>
                                    <td>Jubie Nebalga</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>


    @section('script_content')
        <script>
            $('.attendance_summary_content').fadeIn('slow');

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
                $('.info_header6').click(function(){
                    $('.show_content6').slideToggle('fast');
                })
                $('.info_header7').click(function(){
                    $('.show_content7').slideToggle('fast');
                })


                // Select2
                $('.js-example-basic-single').select2({
                    placeholder: 'None Selected',
                    width: '100%',
                });


            // function showTable(){
            //     $('#table_generate').attr('hidden',false);
            // }


        </script>
    @endsection
@endsection

