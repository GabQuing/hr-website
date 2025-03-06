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
</style>
@section('content')
    <div>
        <br>
        @if (session('success'))
            <h5 class="u-fw-b" style="color: green; display:block;">{{ session('success') }}</h5>
        @endif
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
                    <div class="policy_paragraph">
                        <p>
                            *Note: Only advanced notices at least 2 hours before shift will count. If Employee gives no notice or gives
                            their notice in less than 2 hours, Employee’s salary will be reduced based on how many minutes are lost.
                            This is a case-by-case basis and if a reasonable explanation for the tardiness is given, lost minutes can be
                            recovered and paid.
                        </p>
                    </div>
                    <br>
                    <div class="pic_input_main_table">
                        <table class="table_schedule" id="normal_schedule_table" >
                            <tbody>
                                <tr>
                                    <td>Absences</td>
                                    <td>
                                        <p>Employees who will take a day off due to </p>
                                        <div class="policy_bullet_sm">
                                            <ul>
                                                <li>Sick</li>
                                                <li>Emergencies</li>
                                                <li>Internet Interruptions</li>
                                                <li>Power Interruptions</li>
                                                <li>Bad Weather (affecting connections for remote work)</li>
                                                <li>Case-to-Case Basis; Emergencies include but are not limited to:</li>
                                                <li>Grievances</li>
                                                <li>Vehicular Accident</li>
                                                <li>Hospitalization</li>
                                            </ul>
                                        </div>
                                        <br>
                                        <p>
                                            Must send an advance notice 2 hours before the shift. If not, the
                                            absence will be credited in the employee's paid time leave (PTO).
                                        </p>
                                        <br>
                                        <br>
                                        <p>
                                            Employees on leave are responsible for covering the lost hours of
                                            work. This can be achieved by either using accrued Paid Time Off
                                            (PTO) if available or making up for the lost hours.
                                        </p>
                                        <br>
                                        <p>
                                            If an employee does not have sufficient accrued PTO to cover the
                                            leave period, the deficit will be deducted from their pay.
                                        </p>
                                        <br>
                                        <p>
                                            If an employee is unable to attend work due to illness, they must
                                            notify their immediate supervisor or the designated contact within
                                            the first hour of the workday. Failure to provide timely notice may
                                            result in disciplinary action. Employees are required to provide a
                                            <span class="t-underline">medical certificate from a licensed healthcare professional for
                                            absences.</span> The medical certificate should include the date of the
                                            consultation, the nature of the illness, and the expected duration of
                                            the absence. 
                                        </p>
                                        <br>
                                        <br>
                                        <p>
                                            Employees with scheduled <strong>Internet or Power Interruptions</strong> should
                                            give immediate notice and an estimated time-frame as to when the
                                            connection will come back. <span class="t-underline">If no notice was given beyond 2 hours
                                            BEFORE shift, this will be counted as an absence for the day.</span> This
                                            will included as 8 Lost hours for employee to cover.
                                        </p>
                                        <br>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                                    <td>
                                        <p>
                                            Continue to update your post for the day with the tasks you’re
                                            starting to do for task-time monitoring purposes
                                        </p>
                                        <br>
                                        <p>
                                            Example:
                                        </p>
                                        <br>
                                        <p>
                                            Good Morning, grateful for...
                                        </p>
                                        <p>
                                            [the things that you are grateful for today]
                                        </p>
                                        <br>
                                        <p>
                                            Today, I’m working on...
                                        </p>
                                        <p>
                                            [the things that you are grateful for today]
                                        </p>
                                        <br>
                                    </td>
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
                                    <td>
                                        Respond to a Task Roll Call by Founder
                                        <div class="policy_bullet_sm">
                                            <ul>
                                                <li>Task Roll Call by Founder</li>
                                                <li>Important Inquiries from the Manager</li>
                                                <li>Urgent assignments</li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        <p>
                                            Founder will randomly call out a Task Roll Call at any time during work hours. Employee must be ready to comment on the post what they’re working on.
                                        </p>
                                        <br>
                                        <p>
                                            <span class="t-underline">Unresponsive Employee </span>
                                        </p>
                                        <p>Strikes per Day:</p>
                                        <div class="policy_bullet_sm">
                                            <ul>
                                                <li>First Strike: Ten minutes (10) of unresponsiveness</li>
                                                <li>Second Strike: Twenty minutes (20) of unresponsiveness</li>
                                                <li>Third Strike: One hour (60) of unresponsiveness</li>
                                            </ul>
                                        </div>
                                        <br>
                                        <p>First Offense (10 Working Days) – 1st Warning</p>
                                        <div class="policy_bullet_sm">
                                            <ul>
                                                <li>Accumulation of two hours (2) of unresponsiveness </li>
                                            </ul>
                                        </div>
                                        <br>
                                        <p>Second Offense (20 Working Days) – 2nd Warning</p>
                                        <div class="policy_bullet_sm">
                                            <ul>
                                                <li>Accumulation of four hours (4) of unresponsiveness </li>
                                            </ul>
                                        </div>
                                        <br>
                                        <p>Third Offense (20 Working Days) – 3rd Warning and Notice of Termination</p>
                                        <div class="policy_bullet_sm">
                                            <ul>
                                                <li>Accumulation of six hours or more (6) of unresponsiveness</li>
                                            </ul>
                                        </div>
                                        <br>
                                        <p>
                                            Note that the Employee does not need to cover minutes, however,
                                            the manager will monitor and keep track on the employee’s
                                            attendance during working hours. 
                                        </p>
                                        <br>
                                        <p>
                                            If sudden Internet or Power Interruptions occur DURING working
                                            hours, employee must give immediate notice through text or call to
                                            their manager.
                                        </p>
                                        <br>
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
                        <h5>Employee Probation</h5>
                    </div>
                    <hr>
                        <p>3 months probationary. Evaluation, if will continue as a regular employee.</p>
                        <br>
                        <div class="policy_bullet_sm">
                            <ul>
                                <li>
                                    LC has established a probationary period of 3 months for new hires. This period is designed to
                                    provide an initial assessment and acclimatization period for both the employee and the company
                                </li>
                                <li>
                                    At the end of the 3-month probationary period, your employment may be confirmed if both you and
                                    the company are satisfied with the working relationship.
                                </li>
                                <li>
                                    In some cases, if additional time is needed for assessment, the probationary period may be extended,
                                    with clear expectations communicated to you.
                                </li>
                                <li>
                                    If it is determined that the role is not a suitable fit for you or if you decide to pursue other
                                    opportunities, either party may terminate the employment relationship with notice as per company
                                    policies.
                                </li>
                            </ul>
                        </div>
                    <br>
                    <div class="pic">
                        <h5>3-DAY Work trial</h5>
                    </div>
                    <hr>
                    <div class="policy_paragraph">
                        <p>The 3-day work trial serves as an assessment period during which candidates or employees can experience the role and work environment firsthand.New hires in the 3-day work trial will not receive monetary compensation for their time during the trial period.</p>
                    </div>
                    <br>
                </div>
            </div>
            <div class="show_work_information">
                <div class="info_header1 info_header_design1">
                    <p>Pay Salary Related</p>
                </div>

                <div class="work_information_content show_content1 info_padding">
                    <div class="pic" style="display: flex; justify-content: space-between; align-items: center;">
                        <h5>Schedule of pay cycle for the year of {{ $payroll_calendar?->calendar_year ?: '2024' }}</h5>
                        @role('hr|admin')
                        <button type="button" class="u-action-btn u-bg-primary btn-edit edit-payroll-calendar">
                            <span class="material-symbols-outlined" style="vertical-align: bottom; font-size: 20px; font-weight: bold;">
                                edit
                            </span>
                        </button>
                        @endrole
                    </div>
                    <div>
                        <img src="{{ $payroll_calendar?->file_path ?: asset('img/pay_salary_date.png') }}" alt="" style="object-fit: contain; width: 100%;">
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
                    <p>Paid leave given to a regular employee during their work anniversary with the Company. The earned leave credit shall be valid to use within ninety (30) days from the date of the employee’s work birthday, if not used, it will NOT be converted into cash. </p>
                </div>
                <br>
                <div class="pic">
                    <h5>Special Leave Benefits</h5>
                </div>
                <hr>
                <div class="policy_paragraph">
                    <p>Maternity leave - 1 Month Salary (Paid Maternity Leave)</p>
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
                                <td>Flexible work arrangements(for approval)</td>
                                <td>
                                    <p>Flexible work arrangements refer to non-traditional work schedules
                                        or setups that deviate from the standard working hours or
                                        location. These arrangements are designed to better align with an
                                        employee’s unique circumstances.
                                    </p>
                                    <br>
                                    <p>Flexible work arrangements can include options such as:</p>
                                    <div class="policy_bullet">
                                        <ul>
                                            <li>Adjusted working hours (e.g., staggered start and end times).</li>
                                            <li>Compressed workweeks (e.g., four 10-hour workdays).</li>
                                            <li>Remote or telecommuting arrangements.</li>
                                            <li> Part-time schedules.</li>
                                        </ul>
                                    </div>
                                    <p>
                                        Flexible work arrangements are subject to periodic review to assess
                                        their effectiveness and impact on team dynamics.
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
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
                        <br>
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
                                    <td>PHP 10,000.00</td>
                                </tr>
                                {{-- <tr>
                                    <td>Vision Benefits</td>
                                    <td>Eye tests or eyeglass</td>
                                    <td>PHP 3,500.00</td>
                                </tr> --}}
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
                        <br>
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
                        <br>
                    </div>
                </div>
            </div>
            <div class="show_education_background">
                <div class="info_header8 info_header_design2">
                    <p>Confidentiality And data Protection</p>
                </div>
                <div class="education_background_content show_content8 info_padding">
                    <p>We want to ensure that private information about clients, employees, partners and our company is wellprotected. Examples of confidential information are:</p>
                    <br>
                    <div class="policy_bullet_sm">
                        <ul>
                            <li>Employee records</li>
                            <li>Unpublished financial information</li>
                            <li>Data of customers/partners/vendors</li>
                            <li>Customer lists (existing and prospective)</li>
                            <li>Unpublished goals, forecasts and initiatives marked as confidential</li>
                        </ul>
                    </div>
                    <br>
                    <p>
                        As part of our hiring process, we may ask you to sign non-compete and non-disclosure agreements (NDAs.)
                        We are also committed to: 
                    </p>
                    <br>
                    <div class="policy_bullet_sm">
                        <ul>
                            <li>Restrict and monitor access to sensitive data.</li>
                            <li>Develop transparent data collection procedures. </li>
                            <li>Train employees in online privacy and security measures.</li>
                            <li>Build secure networks to protect online data from cyberattacks.</li>
                            <li>Establish data protection practices (e.g. secure locks, data encryption, frequent
                                backups, access authorization.)</li>
                        </ul>
                    </div>
                    <br>
                    <p>We also expect you to act responsibly when handling confidential information. You must:</p>
                    <br>
                    <div class="policy_bullet_sm">
                        <ul>
                            <li>Lock or secure confidential information at all times.</li>
                            <li>Shred confidential documents when they’re no longer needed.</li>
                            <li>Make sure you view confidential information on secure devices only</li>
                            <li>Only disclose information to other employees when it’s necessary and authorized.</li>
                            <li>Keep confidential documents inside our company’s premises unless it’s absolutely
                                necessary to move them.</li>
                        </ul>
                    </div>
                    <br>
                    <p>You must not: </p>
                    <br>
                    <div class="policy_bullet_sm">
                        <ul>
                            <li>Use confidential information for your personal benefit or profit.</li>
                            <li>Disclose confidential information to anyone outside of our company.</li>
                            <li>Replicate confidential documents and files and store them on insecure devices.</li>
                        </ul>
                    </div>
                    <br>
                    <p>
                        This policy is important for our company’s legality and reputation. We will terminate any employee who
                        breaches our confidentiality guidelines for personal profit. We may also discipline any unintentional breach
                        of this policy depending on its frequency and seriousness. We will terminate employees who repeatedly
                        disregard this policy, even when they do so unintentionally.
                    </p>
                    <br>
                    <div class="pic">
                        <h5>Corporate Email</h5>
                    </div>
                    <hr>
                    <p>Email is essential to our work. You should use your company email primarily for work.</p>
                    <br>
                    <div class="policy_bullet_sm">
                        <ul>
                            <li>
                                Work-related use. You can use your corporate email for work-related purposes without limitations.
                                For example, you can sign up for newsletters and online services that will help you in your job or
                                professional growth. 
                            </li>
                        </ul>
                    </div>
                    <br>
                    <div class="pic">
                        <h5>Our General Expectations</h5>
                    </div>
                    <hr>
                    <p>No matter how you use your corporate email, we expect you to avoid: </p>
                    <br>
                    <div class="policy_bullet_sm">
                        <ul>
                            <li>Signing up for illegal, unreliable, disreputable or suspect websites and services. </li>
                            <li>Sending unauthorized marketing content or emails. </li>
                            <li>Registering for a competitor’s services, unless authorized. </li>
                            <li>Sending insulting or discriminatory messages and content. </li>
                            <li>Intentionally spamming other people’s emails, including your coworkers.  </li>
                        </ul>
                    </div>
                    <p>
                        In general, use strong passwords and be vigilant in catching emails that carry malware or phishing
                        attempts.
                    </p>
                    <br>
                    <div class="pic">
                        <h5>Social Media</h5>
                    </div>
                    <hr>
                    <p>
                        We want to provide practical advice to prevent careless use of social media in our workplace. We address
                        two types of social media uses: using personal social media at work and representing our company
                        through social media. 
                    </p>
                    <br>
                    <div class="pic">
                        <h5>Using Personal Social Media At Work</h5>
                    </div>
                    <hr>
                    <p>
                        You are permitted to access your personal accounts at work. However, we expect you to act responsibly,
                        according to our policies and ensure that you stay productive. Specifically, we ask you to: 
                    </p>
                    <br>
                    <div class="policy_bullet_sm">
                        <ul>
                            <li>Discipline yourself. Avoid getting sidetracked by your social platforms.</li>
                            <li>Ensure others know that your personal account or statements don’t represent our company. For
                                example, use a disclaimer such as “opinions are my own.” </li>
                            <li>Avoid sharing intellectual property (e.g trademarks) or confidential information. Ask your manager or PR
                                first before you share company news that’s not officially announced</li>
                            <li>Avoid any defamatory, offensive or derogatory content. You may violate our company’s anti-harassment
                                policy if you direct such content towards colleagues, clients or partners.</li>
                        </ul>
                    </div>
                    <br>
                    <div class="pic">
                        <h5>Representing Our Company Through Social Media</h5>
                    </div>
                    <hr>
                    <p>
                        If you handle our social media accounts or speak on our company’s behalf, we expect you to protect our
                        company’s image and reputation. Specifically, you should: 
                    </p>
                    <br>
                    <div class="policy_bullet_sm">
                        <ul>
                            <li>Be respectful, polite and patient.</li>
                            <li>Avoid speaking on matters outside your field of expertise when possible. </li>
                            <li>Follow our confidentiality and data protection policies and observe laws governing copyrights,
                                trademarks, plagiarism and fair use. </li>
                            <li>Coordinate with Joe when you’re about to share any major-impact content. </li>
                            <li>Avoid deleting or ignoring comments for no reason. </li>
                            <li>Correct or remove any misleading or false content as quickly as possible</li>
                        </ul>
                    </div>
                    <br>
                </div>
            </div>
            <div class="show_education_background">
                <div class="info_header9 info_header_design1">
                    <p>Conflict Of Interest</p>
                </div>
                <div class="education_background_content show_content9 info_padding">
                    <div class="policy_paragraph">
                        <p>
                            When you are experiencing a conflict of interest, your personal goals are no longer aligned with your
                            responsibilities towards us. For example, accepting a bribe may benefit you financially, but it is illegal and
                            against our business code of ethics. If we become aware of such behaviour, you will lose your job and may
                            face legal trouble. 
                        </p>
                    </div>
                    <br>
                    <div class="policy_paragraph">
                        <p>
                            For this reason, conflicts of interest are a serious issue for all of us. We expect you to be vigilant to spot
                            circumstances that create conflicts of interest, either to yourself or for your direct reports. Follow our policies
                            and always act in our company’s best interests. Whenever possible, do not let personal or financial interests
                            get in the way of your job. If you are experiencing an ethical dilemma, talk to your manager or Joe and we will
                            try to help you resolve it.
                        </p>
                    </div>
                    <br>
                </div>
            </div>
            <div class="show_education_background">
                <div class="info_header11 info_header_design2">
                    <p>Bereavement Leave</p>
                </div>
                <div class="education_background_content show_content11 info_padding">
                    <p>Losing a loved one is traumatizing.</p>
                    <br>
                    <p>
                        If this happens to you while you work with us, we want to support you and give you time to cope and mourn.
                        For this reason, we offer a week (7 days) of UNPAID BEREAVEMENT LEAVE. If you require more time or want
                        paid bereavement leaves, please use your PTO. Employee should send a proof of loss usually in form of a
                        death certificate. You may take your bereavement leave on consecutive days to: 
                    </p>
                    <br>
                    <div class="policy_bullet_sm">
                        <ul>
                            <li>Arrange a funeral or memorial service.</li>
                            <li>Attend a funeral or memorial service.</li>
                            <li>Resolve matters of inheritance. </li>
                            <li>Fulfill other family obligations.</li>
                            <li>Mourn</li>
                        </ul>
                    </div>
                    <br>
                </div>
            </div>
            <div class="show_education_background">
                <div class="info_header12 info_header_design1">
                    <p>Leaving Our Company</p>
                </div>
                <div class="education_background_content show_content12 info_padding">
                    <p>
                        In this section, we describe our procedures regarding resignation and termination of our employees. We also
                        refer to our progressive discipline process that may sometimes result in termination. 
                    </p>
                    <br>
                    <div class="pic">
                        <h5>Progressive Discipline</h5>
                    </div>
                    <hr>
                    <p>
                        Here we outline steps we will take to address employee misconduct. We want to give employees a chance to
                        correct their behavior when possible and assist them in doing so. We also want to ensure that we thoroughly
                        investigate and handle serious offenses. 
                    </p>
                    <br>
                    <p>Our progressive discipline process has six steps of increasing severity. These steps are:</p>
                    <p>
                        Here we outline steps we will take to address employee misconduct. We want to give employees a chance to
                        correct their behavior when possible and assist them in doing so. We also want to ensure that we thoroughly
                        investigate and handle serious offenses.
                    </p>
                    <br>
                    <div class="policy_bullet_sm">
                        <ul>
                            <li>Verbal warning</li>
                            <li> Informal meeting with supervisor</li>
                            <li>Formal reprimand </li>
                            <li>Formal disciplinary meeting</li>
                            <li>Penalties</li>
                            <li>Termination</li>
                        </ul>
                    </div>
                    <br>
                    <p>
                        Different offenses correspond to different steps in our disciplinary process. For example, minor, onetime offenses (e.g. breach of our dress code policy) will trigger Step 1. More severe violations (e.g. sexual
                        harassment) will trigger step 5. 
                    </p>
                    <br>
                    <p>
                        If you manage employees, inform them when you launch a progressive discipline process. Pointing out a
                        performance issue is not necessarily a verbal warning and may be part of your regular feedback. If you judge
                        that progressive discipline is appropriate, let your team member know and ask Joe to help you explain our full
                        procedure. 
                    </p>
                    <br>
                    <p>
                        <span class="t-underline"><strong>Managers may skip or repeat steps at their discretion. Our company may treat circumstances differently
                            from those described in this policy. However, we are always obliged to act fairly and lawfully and document
                            every stage of our progressive discipline process.</strong></span>
                    </p>
                    <br>
                    <p>
                        Keep in mind that our company isn’t obliged to follow the steps of our progressive discipline process.
                        As you are employed “at-will” in the U.S, we may terminate you directly without launching a progressive
                        discipline process. For serious offenses (e.g. sexual harassment), we may terminate you without warning. 
                    </p>
                    <br>
                    <div class="pic">
                        <h5>Progressive Discipline</h5>
                    </div>
                    <hr>
                    <p>
                        You resign when you voluntarily inform Joe or your manager that you will stop working for our company. We
                        also consider you resigned if you don’t come to work for three (3) consecutive days without notice
                    </p>
                    <br>
                    <p>
                        For efficiency’s sake, and to make sure our workplace runs smoothly, we ask that you give at least two (2)
                        notice, if possible. If you hold a highly specialized or executive position, we ask that you give us at least one (1)
                        month’s notice.
                    </p>
                    <br>
                    <div class="pic">
                        <h5>Forced Resignation</h5>
                    </div>
                    <hr>
                    <p>
                        You can resign anytime at your own free will and nobody should force you into resignation. Forcing someone
                        into resigning (directly or indirectly) is constructive dismissal and we won’t tolerate it. Specifically, we prohibit
                        employees from: 
                    </p>
                    <br>
                    <div class="policy_bullet_sm">
                        <ul>
                            <li>Creating a hostile or unpleasant environment. </li>
                            <li>Demanding or coaxing an employee to resign. </li>
                            <li>Victimizing, harassing or retaliating against an employee.</li>
                            <li>Forcing an employee to resign by taking unofficial adverse actions (e.g. demotions, increased workload).</li>
                        </ul>
                    </div>
                    <br>
                    <div class="pic">
                        <h5>Forced Resignation</h5>
                    </div>
                    <hr>
                    <div class="policy_bullet_sm">
                        <ul>
                            <li>
                                For cause termination is justified when an employee breaches their contract, engages in illegal activities
                                (e.g. embezzlement), disrupts our workplace (e.g. harasses colleagues), performs below acceptable
                                standards or causes damage or financial loss to our company. 
                            </li>
                            <li>
                                Without cause termination refers to redundancies or layoffs that may be necessary if we cease some of
                                our operations or re-assign job duties within teams. We will follow applicable laws regarding notice and
                                payouts.
                            </li>
                        </ul>
                    </div>
                    <br>
                    <p>
                        We will offer severance pay to eligible employees. We may also compensate accrued vacation and sick leave
                        upon termination. Whenever local law doesn’t have relevant stipulations, we will pay accrued leave only to
                        those who weren’t terminated for cause.
                    </p>
                    <br>
                    <p>
                        If you manage team members, avoid wrongful dismissal. When you terminate an employee for cause, we
                        expect you to be certain you made the right choice and keep accurate performance and/or disciplinary records
                        to support your decision.
                    </p>
                    <br>
                    <div class="pic">
                        <h5>References</h5>
                    </div>
                    <hr>
                    <div class="policy_paragraph">
                        <p>
                            When we terminate employees, we may provide references for those who leave in good standing. This means
                            that employees shouldn’t have been terminated for cause. If you are laid off, you may receive references.
                            Please ask your manager. If you resign, you may ask for references and your manager has a right to oblige or
                            refuse.
                        </p>
                    </div>
                    <br>
                </div>
            </div>
            <div class="show_education_background">
                <div class="info_header6 info_header_design2">
                    <p>Policy Revision</p>
                </div>
                <div class="education_background_content show_content6 info_padding">
                    <p>
                        We will always strive for fairness and equal opportunity and penalize offensive and illegal behaviors. But, as
                        laws and our environment change, we may revise and modify some of our policies
                    </p>
                    <br>
                    <p>
                        We also ask you to contact Joe if you spot any inconsistencies or mistakes. And, if you have any ideas about
                        how to improve our workplace, we are happy to hear them.
                    </p>
                    <br>
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
                    <br>
                </div>
            </div>
        </div>
        </div>
    </div>


    @section('script_content')
        <script>
            $('.attendance_summary_content').fadeIn('slow');
            $('.btn-close').on('click', function(){
                $('.modal-center').hide();
            })

            $('.edit-payroll-calendar').on('click', function() {
                $('#payroll-calendar-modal').show();
            });


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
                $('.info_header8').click(function(){
                    $('.show_content8').slideToggle('fast');
                })
                $('.info_header9').click(function(){
                    $('.show_content9').slideToggle('fast');
                })
                $('.info_header10').click(function(){
                    $('.show_content10').slideToggle('fast');
                })
                $('.info_header11').click(function(){
                    $('.show_content11').slideToggle('fast');
                })
                $('.info_header12').click(function(){
                    $('.show_content12').slideToggle('fast');
                })


                // Select2
                $('.js-example-basic-single').select2({
                    placeholder: 'None Selected',
                    width: '100%',
                });




        </script>
    @endsection
@endsection

