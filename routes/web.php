<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ActivityLogsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeInformationsController;
use App\Http\Controllers\LeavesController;
use App\Http\Controllers\LoginAuthController;
use App\Http\Controllers\OfficialBusinessController;
use App\Http\Controllers\OvertimesController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SideTopContentController;
use App\Http\Controllers\UndertimesController;
use App\Http\Controllers\ApproveAccountsController;
use App\Http\Controllers\UserAccountsController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AttendanceSystemController;
use App\Http\Controllers\LogUserAccessController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ManageAddressController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\MacAddressController;
use App\Http\Controllers\ScheduleProfileController;



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



// Gab's Register
Route::get('/registerInfo', function () {
    return view('registerInfo');
});
Route::post('users/register', [RegisterController::class, 'create'])->name("registerUser");

// Register Face Biometrics
Route::get('/registerFace/{id}', [RegisterController::class, 'index'])->name('registerface');
Route::post('webcam', [RegisterController::class, 'store'])->name('get-image');


//Registered Successfully
Route::get('/successRegister', function () {
    return view('successRegister');
});

//Face Biometric Attendance
Route::get('/Attendance',[AttendanceSystemController::class, 'index'] );
Route::post('Attendance',[AttendanceSystemController::class, 'create'])->name("attendanceLogin");


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
Route::get('/geofencing', function () {
    return view('/geofencing');
});
Route::get('/geolocation', function () {
    return view('/geolocation');
});


// Register
// Route::get('/register', [RegisterUserController::class, 'index']);
// Route::post('/register', [RegisterUserController::class, 'store'])->name('register');

// Login
Route::get('/login', [LoginAuthController::class, 'index']);
Route::post('/login', [LoginAuthController::class, 'authenticate'])->name('login');

//Change Password
Route::get('/change_password/{id}', [ChangePasswordController::class, 'index'])->name('newProfile');
Route::post('/profile/{id}/newPassword',[ChangePasswordController::class, 'newPassword'])->name('new_password');


// Logout
Route::get('/logout', [LoginAuthController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

// Attendance
Route::get('/my_attendance', [AttendanceController::class, 'index'])->name('attendance');
Route::post('/my_attendance/show',[AttendanceController::class, 'daysPresent'])->name('generateTable');
Route::get('/export', [AttendanceController::class, 'export'])->name('export');

// Activity Logs
Route::get('/my_activity_logs', [ActivityLogsController::class, 'index'])->name('activitylogs');
Route::post('/my_activity_logs/show',[ActivityLogsController::class, 'generateFile'])->name('generate_file');
Route::get('/my_activity_logs/export',[ActivityLogsController::class, 'exportFile'])->name('export_activity_log');




// Official Business
Route::get('/my_official_business', [OfficialBusinessController::class, 'index'])->name('officialbusiness');

// Overtimes
Route::get('/my_overtimes', [OvertimesController::class, 'index'])->name('overtimes');

// Undertimes
Route::get('/my_undertimes', [UndertimesController::class, 'index'])->name('undertimes');

// Leaves
Route::get('/my_leaves', [LeavesController::class, 'index'])->name('leaves');

// Payroll
Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll');

// Profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile/{id}/update', [ProfileController::class , 'update'])->name('mp_update');
Route::post('/profile/{id}/updateWorkInfo', [ProfileController::class , 'updateWorkInfo'])->name('updateWorkInfo');
Route::post('/profile/{id}/updateWorkSchedule', [ProfileController::class , 'updateWorkSchedule'])->name('updateWorkSchedule');
Route::post('/profile/{id}/updateGovernmentInfo', [ProfileController::class , 'updateGovernmentInfo'])->name('updateGovernmentInfo');
Route::post('/profile/{id}/updateEducationBackground', [ProfileController::class , 'updateEducationBackground'])->name('updateEducationBackground');
Route::post('/profile/{id}/updateContactInformation', [ProfileController::class , 'updateContactInformation'])->name('updateContactInformation');
Route::post('/profile/{id}/updatePassword',[ProfileController::class, 'updatePassword'])->name('update_password');

// User Accounts
Route::get('/user_accounts', [UserAccountsController::class, 'index'])->name('user_accounts');
Route::get('/user_accounts/{id}/delete', [UserAccountsController::class, 'destroy'])->name('delete');
Route::get('/user_accounts/{id}/activate', [UserAccountsController::class, 'activate'])->name('activate');
Route::get('/user_accounts/{id}/edit', [UserAccountsController::class, 'edit'])->name('edit');
Route::get('/user_accounts/{id}/retakePhoto', [UserAccountsController::class, 'retakePhoto'])->name('retake');
Route::post('/user_accounts/{id}/update', [UserAccountsController::class, 'update'])->name('update');



//Approve Accounts
Route::get('/approve_accounts', [ApproveAccountsController::class, 'index'])->name('approve_accounts');
Route::post('/approve_accounts', [ApproveAccountsController::class, 'add'])->name('add_user');
Route::get('/approve_accounts/downloadTemplate',[ApproveAccountsController::class, 'downloadNewEmployeeTemplate'])->name('downloadNewEmployeeTemplate');
Route::post('/approve_accounts/importUser', [ApproveAccountsController::class, 'importUser'])->name('importUser');
Route::get('/approve_accounts/{id}/image', [ApproveAccountsController::class, 'displayPhoto'])->name('display_photo');
Route::get('/approve_accounts/{id}/decline', [ApproveAccountsController::class, 'decline'])->name('reject');
Route::get('/approve_accounts/{id}/accept', [ApproveAccountsController::class, 'accept'])->name('approve');


// Employee Informations
Route::get('/employee_informations', [EmployeeInformationsController::class, 'index'])->name('employee_informations');
Route::get('/employee_information/{id}/show', [ProfileController::class, 'show'])->name('edit_profile');
Route::get('/employee_informations/downloadEditProfileTemplate',[EmployeeInformationsController::class, 'downloadEditProfileTemplate'])->name('downloadEditProfileTemplate');
Route::post('/employee_informations/editUser', [EmployeeInformationsController::class, 'editUser'])->name('editUser');
Route::post('/employee_informations/getSchedule',[ProfileController::class,'getSchedule'])->name('getSchedule');



//Log User Access
Route::get('/log_user_access', [LogUserAccessController::class, 'index'])->name('log_user_access');
Route::post('/log_user_access/show',[LogUserAccessController::class, 'generateEmployeeFile'])->name('generate_user_file');
Route::get('/log_user_access/show/export',[LogUserAccessController::class, 'exportEmployeeFile'])->name('export_user_activity_log');
Route::post('/log_user_access/uuid',[LogUserAccessController::class, 'getGoogleImages'])->name('getGoogleImages');

//Schedule Profile
Route::get('/schedule_profile',[ScheduleProfileController::class,'index'])->name('schedule_profile');
Route::post('/schedule_profile_view',[ScheduleProfileController::class,'viewSchedule'])->name('viewSchedule');
Route::post('/schedule_profile_create',[ScheduleProfileController::class,'createSchedule'])->name('createSchedule');
Route::post('/schedule_profile_edit',[ScheduleProfileController::class,'edit'])->name('editSchedule');

//Manage Store Address
Route::get('/storeAddress',[ManageAddressController::class,'index'])->name('storeAddress');
Route::post('/storeAddress',[ManageAddressController::class,'addStoreAddress'])->name('newAddress');
Route::get('/storeAddress/{id}/show', [ManageAddressController::class, 'show'])->name('showAddress');
Route::post('/storeAddress/{id}/update', [ManageAddressController::class, 'update'])->name('updateAddress');



// SideTopContent
Route::post('/profile_image', [SideTopContentController::class, 'profile_image'])->name('upload_img');

