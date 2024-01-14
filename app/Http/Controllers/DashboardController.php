<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSummary;
use App\Models\User;
use App\Models\Gender;
use App\Models\CivilStatus;
use App\Models\company;
use App\Models\department;
use App\Models\employee_type;
use App\Models\user_type;
use App\Models\immediate_supervisor;
use App\Models\employment_status;
use App\Models\education_type;
use App\Models\LogType;
use App\Models\schedule_type;
use App\Models\UserLog;
use App\Models\work_hours;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    //
    public function index()
    {

        // $inserted_id = Gender::insertGetId([
        //     'name' => 'Man',
        //     'status' => 'active',
        // ]);

        // dd($inserted_id);

        // $Gender_names = [
        //     ['name' => 'MALE', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'FEMALE','status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        // ];

        // foreach($Gender_names as $Gender_name){
        //     Gender::insert(
        //         $Gender_name
        //     );
        // }

        // $CivilStatus_names = [
        //     ['name' => 'SINGLE', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'MARRIED','status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'WIDOWED','status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')]
        // ];

        // foreach($CivilStatus_names as $CivilStatus_name){
        //     CivilStatus::insert(
        //         $CivilStatus_name
        //     );
        // }

        // $company_names = [
        //     ['name' => 'DIGITS TRADING', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'BEYOND CONCEPT INC', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'TASTELESS','status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')]
        // ];

        // foreach($company_names as $company_name){
        //     company::insert(
        //         $company_name
        //     );
        // }

        // $department_names = [
        //     ['name' => 'AUDIT', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')], 
        //     ['name' => 'ADMIN', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')], 
        //     ['name' => 'BUSINESS PROCESS GROUP', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')], 
        //     ['name' => 'DTC ACCOUNTING', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'HUMAN RESOURCES', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')], 
        //     ['name' => 'INFORMATION SYSTEM DEVELOPMENT', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'LEGAL', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'MARKETING','status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')]
        // ];

        // foreach($department_names as $department_name){
        //     department::insert(
        //         $department_name
        //     );
        // }

        // $employee_type_names = [
        //     ['name' => 'EXECUTIVE', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'MANAGER', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'OFFICER/SUPERVISOR', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'RANK AND FILE', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'RETAINER/CONSULTANT', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        // ];

        // foreach($employee_type_names as $employee_type_name){
        //     employee_type::insert(
        //         $employee_type_name
        //     );
        // }

        // $immediate_supervisor_names = [
        //         ['name' => 'JAENICEN LAMSEN', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'MICHEAL ADRIAN RODALES', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'MARY JOY FAJARDO', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'OTHERS', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')]
        // ];

        // foreach($immediate_supervisor_names as $immediate_supervisor_name){
        //     immediate_supervisor::insert(
        //         $immediate_supervisor_name
        //     );
        // }

        // $employment_status_names = [
        //     ['name' => 'AWOL', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'CONTRACTUAL/PROJECT BASED', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'END OF CONTRACT', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'MATERNITY LEAVE', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'OJT', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'PART-TIME', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'PATERNITY', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'PROBATIONARY', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'REGULAR', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'RESIGNED', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'SABBATICAL', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'TERMINATED', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        // ];

        // foreach($employment_status_names as $employment_status_name){
        //     employment_status::insert(
        //         $employment_status_name
        //     );
        // }

        //             $user_type_names = [
        //     ['name' => 'ADMIN', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'CONSULTANT', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'EMPLOYEE', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'INTERN (ACTIVE)', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'INTERN (ENDED)', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'MANAGER', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        // ];

        // foreach($user_type_names as $user_type_name){
        //     user_type::insert(
        //         $user_type_name
        //     );
        // }

        //             $education_type_names = [
        //     ['name' => 'SECONDARY (JUNIOR HIGHSCHOOL)', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'SECONDARY (SENIOR HIGHSCHOOL)', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'VOCATIONAL', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'TERTIARY (COLLEGE)', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'POSTGRADUATE (MASTERAL)', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'POSTGRADUATE (DOCTORAL)', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        // ];

        // foreach($education_type_names as $education_type_name){
        //     education_type::insert(
        //         $education_type_name
        //     );
        // }
        //             $schedule_type_names = [
        //     ['name' => 'NORMAL SCHEDULE', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => 'FLEXIBLE SCHEDULE', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        // ];

        // foreach($schedule_type_names as $schedule_type_name){
        //     schedule_type::insert(
        //         $schedule_type_name
        //     );
        // }
        //             $work_hours_names = [
        //     ['name' => '8', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => '9', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        //     ['name' => '10.6', 'status' => 'active', 'created_by' => auth()->user()->id, 'created_at' => date('Y-m-d H:i:s')],
        // ];

        // foreach($work_hours_names as $work_hours_name){
        //     work_hours::insert(
        //         $work_hours_name
        //     );
        // }

        // $macAddress = '';
        // exec('ipconfig /all', $output);
        // $output = implode("\n", $output);

        // if (preg_match('/Wireless LAN adapter Wi-Fi:\s.*?Physical Address[\. ]+: ([\w-]+)/s', $output, $matches)) {
        //     $macAddress = $matches[1];
        // }

        // dd($macAddress);
        $data = [];
        $data['today_log'] = (new AttendanceSummary())->getByDate(date('Y-m-d'), auth()->user()->id);

        return view('dashboard', $data);
    }

    public function log_action(Request $request)
    {
        $user_id = $request->get('user_id');
        $timestamp = date('Y-m-d H:i:s');
        $action = $request->get('action');

        $log_type = (new LogType())->getByDescription($action);

        if (!$log_type) {
            abort(404, 'The request action type does not exist in the database.');
        }

        $user_log = UserLog::create([
            'log_type_id' => $log_type->id,
            'log_at' => $timestamp,
            'user_id' => $user_id
        ]);

        $log_details = $user_log->getDetails();
        $response = [];
        $response['log_details'] = $log_details;
        $response['log_today'] = (new AttendanceSummary())->getByDate(date('Y-m-d'), $user_id);

        return $response;
    }
}
