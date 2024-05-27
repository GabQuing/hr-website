<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ActivityLogsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeInformationsController;
use App\Http\Controllers\LeavesController;
use App\Http\Controllers\BenefitController;
use App\Http\Controllers\LoginAuthController;
use App\Http\Controllers\OfficialBusinessController;
use App\Http\Controllers\OvertimesController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SideTopContentController;
use App\Http\Controllers\UndertimesController;
use App\Http\Controllers\ApproveAccountsController;
use App\Http\Controllers\UserAccountsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AttendanceSystemController;
use App\Http\Controllers\LogUserAccessController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\EmployeeRequestController;
use App\Http\Controllers\ScheduleProfileController;
use App\Http\Controllers\PolicyProcedureController;
use App\Http\Controllers\EmployeeLeavesController;
use App\Http\Controllers\EmployeeAttendanceController;
use App\Http\Controllers\EmployeePayrollController;
use App\Http\Controllers\EmployeeBenefitController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::post('users/register', [RegisterController::class, 'create'])->name("registerUser");

// Register Face Biometrics
Route::get('/registerFace/{id}', [RegisterController::class, 'index'])->name('registerface');
Route::post('webcam', [RegisterController::class, 'store'])->name('get-image');


//Registered Successfully
Route::get('/successRegister', function () {
    return view('successRegister');
});

//Face Biometric Attendance
Route::get('/Attendance', [AttendanceSystemController::class, 'index']);
Route::post('Attendance', [AttendanceSystemController::class, 'create'])->name("attendanceLogin");


//get Photo
Route::get('/approve_accounts', 'ApproveAccountsController@displayPhoto')->name('display.photo');

//Access Denied
Route::get('/accessDenied', function () {
    return view('accessDenied');
});

Route::get('/', function () {
    return view('/login');
});
Route::get('/welcome', function () {
    return view('/welcome');
});
Route::get('/contact_HR', function () {
    return view('/contact_HR');
});

// Login
Route::get('/login', [LoginAuthController::class, 'index']);
Route::post('/login', [LoginAuthController::class, 'authenticate'])->name('login');

// Logout
Route::get('/logout', [LoginAuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    //Change Password
    Route::get('/change_password/{id}', [ChangePasswordController::class, 'index'])->name('newProfile');
    Route::post('/profile/{id}/newPassword', [ChangePasswordController::class, 'newPassword'])->name('new_password');



    // Dashboard
    Route::get('/dashboard1', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
    Route::post('/dashboard1/announcement/create', [DashboardController::class, 'createAnnouncement'])->middleware(['auth'])->name('announcement.create');
    Route::post('/dashboard1/announcement/update', [DashboardController::class, 'updateAnnouncement'])->middleware(['auth'])->name('announcement.update');
    Route::get('/dashboard1/announcement/delete', [DashboardController::class, 'deleteAnnouncement'])->middleware(['auth'])->name('announcement.delete');

    //Clock in, Clock Out, Break Start, Break End
    Route::post('/dashboard/log-action', [DashboardController::class, 'log_action'])->middleware(['auth'])->name('dashboard.log-action');

    // Attendance
    Route::get('/my_attendance', [AttendanceController::class, 'index'])->name('attendance');
    Route::post('/my_attendance/show', [AttendanceController::class, 'daysPresent'])->name('generateTable');
    Route::get('/export', [AttendanceController::class, 'export'])->name('export');

    //Employee Attendance
    Route::get('/employee_attendance', [EmployeeAttendanceController::class, 'index'])->name('employee_attendance');
    Route::post('/employee_attendance/show', [EmployeeAttendanceController::class, 'employeeDaysPresent'])->name('employeeGenerateTable');




    // Activity Logs
    Route::get('/my_activity_logs', [ActivityLogsController::class, 'index'])->name('activitylogs');
    Route::get('/my_activity_logs/show', [ActivityLogsController::class, 'generateFile'])->name('generate_file');
    Route::get('/my_activity_logs/export', [ActivityLogsController::class, 'exportFile'])->name('export_activity_log');

    // Employee Request
    Route::get('/employee_request', [EmployeeRequestController::class, 'index'])->name('employee_request');
    Route::get('/employee_request/obd/{id}', [EmployeeRequestController::class, 'officialBusinessData'])->name('obd');
    Route::get('/employee_request/ot/{id}', [EmployeeRequestController::class, 'overtimeData'])->name('otd');
    Route::get('/employee_request/leave/{id}', [EmployeeRequestController::class, 'leaveData'])->name('leaved');
    Route::post('/employee_request/obForm', [EmployeeRequestController::class, 'obForm'])->name('obForm');
    Route::post('/employee_request/otForm', [EmployeeRequestController::class, 'otForm'])->name('otForm');
    Route::post('/employee_request/leaveForm', [EmployeeRequestController::class, 'leaveForm'])->name('leaveForm');

    //Employee Leaves
    Route::get('/employee_leave', [EmployeeLeavesController::class, 'index'])->name('employee_leaves');
    Route::post('/employee_leave/add', [EmployeeLeavesController::class, 'add'])->name('employeeLeavesAdd');
    Route::get('/employee_leave/{id}/edit', [EmployeeLeavesController::class, 'edit'])->name('editEmployeeLeave');
    Route::post('/employee_leave/{id}/update', [EmployeeLeavesController::class, 'updateEmployeeLeave'])->name('employee_leaves.update');

    //Employee Payroll
    Route::get('/employee_payroll', [EmployeePayrollController::class, 'index'])->name('employee_payroll');
    Route::get('/employee_payroll/edit/{id}', [EmployeePayrollController::class, 'edit'])->name('employee_payroll_edit');
    Route::post('/employee_payroll/store', [EmployeePayrollController::class, 'add'])->name('employee_payroll_add');
    Route::post('/employee_payroll/update/{id}', [EmployeePayrollController::class, 'update'])->name('employee_payroll_update');
    Route::get('/employee_payroll/pdfShow/{file_name}', [EmployeePayrollController::class, 'showPDF'])->name('showPDF');
    Route::get('/employee_payroll/delete', [EmployeePayrollController::class, 'deletePayroll'])->name('employee_payroll_delete');
    Route::get('/employee_payroll/download', [EmployeePayrollController::class, 'downloadPDF'])->name('employee_payroll_download');

    //Employee Benefit
    Route::get('/employee_benefit', [EmployeeBenefitController::class, 'index'])->name('employee_benefit');
    Route::post('/employee_benefit/add', [EmployeeBenefitController::class, 'add'])->name('employeeBenefitAdd');
    Route::get('/employee_benefit/{id}/edit', [EmployeeBenefitController::class, 'edit'])->name('editEmployeeBenefit');
    Route::post('/employee_benefit/{id}/update', [EmployeeBenefitController::class, 'updateEmployeeBenefit'])->name('employee_benefit.update');
    Route::get('/employee_benefit/{id}/view', [EmployeeBenefitController::class, 'viewEmployeeBenefit'])->name('employee_benefit.view');
    Route::get('employee_benefit/download-receipt/{history_id}', [EmployeeBenefitController::class, 'downloadReceipt'])->name('employee_benefit.download-receipt');



    // Official Business
    Route::post('/my_official_business/{id}/update', [OfficialBusinessController::class, 'updateOB'])->name('my_official_business.update');
    Route::get('/my_official_business/{id}/edit', [OfficialBusinessController::class, 'edit'])->name('editInfo');
    Route::get('/my_official_business/{id}/delete', [OfficialBusinessController::class, 'deleteOB'])->name('deleteOB');
    Route::get('/my_official_business', [OfficialBusinessController::class, 'index'])->name('officialbusiness');
    Route::post('/my_official_business/submit', [OfficialBusinessController::class, 'createOB'])->name('submitOB');

    // Overtimes
    Route::get('/my_overtimes', [OvertimesController::class, 'index'])->name('overtimes');
    Route::get('/my_overtimes/{id}/edit', [OvertimesController::class, 'edit'])->name('editOT');
    Route::get('/my_overtimes/{id}/delete', [OvertimesController::class, 'deleteOT'])->name('deleteOT');
    Route::post('/my_overtimes/submit', [OvertimesController::class, 'createOT'])->name('submitOT');
    Route::post('/my_overtimes/{id}/update', [OvertimesController::class, 'updateOT'])->name('my_overtimes.update');


    // Undertimes
    Route::get('/my_undertimes', [UndertimesController::class, 'index'])->name('undertimes');

    // Leaves
    Route::get('/my_leaves', [LeavesController::class, 'index'])->name('leaves');
    Route::get('/my_leaves/{id}/edit', [LeavesController::class, 'edit'])->name('editLeave');
    Route::get('/my_leaves/{id}/delete', [LeavesController::class, 'deleteLeave'])->name('deleteLeave');
    Route::post('/my_leaves/{id}/update', [LeavesController::class, 'updateLeave'])->name('my_leaves.update');
    Route::post('/my_leaves/submit', [LeavesController::class, 'createLeave'])->name('submitLeave');



    // Benefit
    Route::get('/my_benefits', [BenefitController::class, 'index'])->name('benefits');


    // Payroll
    Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/{id}/update', [ProfileController::class, 'update'])->name('mp_update');
    Route::post('/profile/{id}/updateWorkInfo', [ProfileController::class, 'updateWorkInfo'])->name('updateWorkInfo');
    Route::post('/profile/{id}/updateWorkSchedule', [ProfileController::class, 'updateWorkSchedule'])->name('updateWorkSchedule');
    Route::post('/profile/{id}/updateGovernmentInfo', [ProfileController::class, 'updateGovernmentInfo'])->name('updateGovernmentInfo');
    Route::post('/profile/{id}/updateEducationBackground', [ProfileController::class, 'updateEducationBackground'])->name('updateEducationBackground');
    Route::post('/profile/{id}/updateContactInformation', [ProfileController::class, 'updateContactInformation'])->name('updateContactInformation');
    Route::post('/profile/{id}/updatePassword', [ProfileController::class, 'updatePassword'])->name('update_password');

    // User Accounts
    Route::get('/user_accounts', [UserAccountsController::class, 'index'])->name('user_accounts');
    Route::get('/user_accounts/{id}/delete', [UserAccountsController::class, 'destroy'])->name('delete');
    Route::get('/user_accounts/{id}/activate', [UserAccountsController::class, 'activate'])->name('activate');
    Route::get('/user_accounts/{id}/edit', [UserAccountsController::class, 'edit'])->name('edit');
    Route::get('/user_accounts/{id}/retakePhoto', [UserAccountsController::class, 'retakePhoto'])->name('retake');
    Route::post('/user_accounts/{id}/update', [UserAccountsController::class, 'update'])->name('ua_update');



    //Approve Accounts
    Route::get('/approve_accounts', [ApproveAccountsController::class, 'index'])->name('approve_accounts');
    Route::post('/approve_accounts', [ApproveAccountsController::class, 'add'])->name('add_user');
    Route::get('/approve_accounts/downloadTemplate', [ApproveAccountsController::class, 'downloadNewEmployeeTemplate'])->name('downloadNewEmployeeTemplate');
    Route::post('/approve_accounts/importUser', [ApproveAccountsController::class, 'importUser'])->name('importUser');
    Route::get('/approve_accounts/{id}/image', [ApproveAccountsController::class, 'displayPhoto'])->name('display_photo');
    Route::get('/approve_accounts/{id}/decline', [ApproveAccountsController::class, 'decline'])->name('reject');
    Route::get('/approve_accounts/{id}/accept', [ApproveAccountsController::class, 'accept'])->name('approve');


    // Employee Informations
    Route::get('/employee_informations', [EmployeeInformationsController::class, 'index'])->name('employee_informations');
    Route::get('/employee_information/{id}/show', [ProfileController::class, 'show'])->name('edit_profile');
    Route::get('/employee_informations/downloadEditProfileTemplate', [EmployeeInformationsController::class, 'downloadEditProfileTemplate'])->name('downloadEditProfileTemplate');
    Route::post('/employee_informations/getSchedule', [ProfileController::class, 'getSchedule'])->name('getSchedule');
    Route::post('/employee_informations/addContract', [ProfileController::class, 'addContract'])->name('employee_contract_add');
    Route::get('/employee_informations/showContract/{file_name}', [ProfileController::class, 'showContract'])->name('show_contract');
    Route::get('/employee_informations/download', [ProfileController::class, 'downloadPDF'])->name('employee_contract_download');



    //Log User Access
    Route::get('/log_user_access', [LogUserAccessController::class, 'index'])->name('log_user_access');
    Route::get('/log_user_access/show', [LogUserAccessController::class, 'generateEmployeeFile'])->name('generate_user_file');
    Route::get('/log_user_access/show/export', [LogUserAccessController::class, 'exportEmployeeFile'])->name('export_user_activity_log');
    Route::post('/log_user_access/uuid', [LogUserAccessController::class, 'getGoogleImages'])->name('getGoogleImages');

    //Schedule Profile
    Route::get('/schedule_profile', [ScheduleProfileController::class, 'index'])->name('schedule_profile');
    Route::post('/schedule_profile_view', [ScheduleProfileController::class, 'viewSchedule'])->name('viewSchedule');
    Route::post('/schedule_profile_create', [ScheduleProfileController::class, 'createSchedule'])->name('createSchedule');
    Route::post('/schedule_profile_edit', [ScheduleProfileController::class, 'edit'])->name('editSchedule');

    //Policy & Procedure
    Route::get('/policy_procedure', [PolicyProcedureController::class, 'index'])->name('policy_procedure');
    Route::post('/policy_procedure/payroll-calendar/add', [PolicyProcedureController::class, 'addPayrollCalendar'])->name('policy_procedure.add_payroll_calendar');


    // SideTopContent
    Route::post('/profile_image', [SideTopContentController::class, 'profile_image'])->name('upload_img');
});
