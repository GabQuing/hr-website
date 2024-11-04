<?php

namespace App\Http\Controllers;

use App\Models\OfficialBusiness;
use App\Models\Overtime;
use App\Models\Leave;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\EmployeeLeaves;
use App\Models\WorkSchedule;
use Illuminate\Support\Facades\DB;

class EmployeeRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $queryParams = request()->all();
        $openTab = sizeof($queryParams) ? array_keys($queryParams)[0] : ['official_businesses'];
        $openTab = in_array($openTab, ['official_businesses', 'overtimes', 'leaves']) ? $openTab : 'official_businesses';
        $data = [];
        $data['official_businesses'] = OfficialBusiness::leftJoin('users', 'users.id', 'official_businesses.created_by')
            ->select(
                'users.*',
                'users.name',
                'official_businesses.*'
            )
            ->orderBy(DB::raw('status = "PENDING"'), 'desc')
            ->orderBy('official_businesses.created_at', 'desc')
            ->paginate(10, ['*'], 'official_businesses');

        $data['overtimes'] = Overtime::leftJoin('users', 'users.id', 'overtimes.created_by')
            ->select(
                'users.*',
                'users.name',
                'overtimes.*'
            )
            ->orderBy(DB::raw('status = "PENDING"'), 'desc')
            ->orderBy('overtimes.created_at', 'desc')
            ->paginate(10, ['*'], 'overtimes');
        $data['leaves'] = Leave::leftJoin('users', 'users.id', 'leaves.created_by')
            ->select(
                'users.*',
                'users.name',
                'leaves.*'
            )
            ->orderBy(DB::raw('status = "PENDING"'), 'desc')
            ->orderBy('leaves.created_at', 'desc')
            ->paginate(10, ['*'], 'leaves');
        $data['pending_ob'] = OfficialBusiness::where('status', 'PENDING')->count();
        $data['pending_ot'] = Overtime::where('status', 'PENDING')->count();
        $data['pending_leaves'] = Leave::where('status', 'PENDING')->count();
        $data['openTab'] = $openTab;

        return view('employee_request', $data);
    }


    public function officialBusinessData(Request $request, string $id)
    {
        return OfficialBusiness::find($id);
    }

    public function overtimeData(Request $request, string $id)
    {
        return Overtime::find($id);
    }

    public function leaveData(Request $request, string $id)
    {
        return Leave::leftJoin('employee_leaves', 'employee_leaves.user_id', 'leaves.created_by')
            ->where('leaves.id', $id)
            ->select(
                'leaves.*',
                'employee_leaves.sick_credit',
                'employee_leaves.vacation_credit',
            )
            ->first();
    }

    public function obForm(Request $request)
    {
        $user_input = $request->all();
        $ob = OfficialBusiness::find($user_input['ob_id']);

        if ($user_input['ob_form_btn'] == 'approve') {
            $is_adjusted = self::adjustUserLog('ob', $ob);
            if ($is_adjusted) {
                $ob->update([
                    'status' => 'APPROVED',
                    'approved_at' => date('Y-m-d H:i:s'),
                    'approved_by' => auth()->user()->id
                ]);
            }
        } else {
            $ob->update([
                'status' => 'REJECTED',
                'rejected_at' => date('Y-m-d H:i:s'),
                'rejected_by' => auth()->user()->id
            ]);
        }
        return redirect()->route('employee_request', ['official_businesses' => 1])->with('ob-success', 'The request has been updated.');
    }

    public function otForm(Request $request)
    {
        $user_input = $request->all();
        $ot = Overtime::find($user_input['ot_id']);

        if ($user_input['ot_form_btn'] == 'approve') {
            $is_adjusted = self::adjustUserLog('ot', $ot);
            if ($is_adjusted) {
                $ot->update([
                    'status' => 'APPROVED',
                    'approved_at' => date('Y-m-d H:i:s'),
                    'approved_by' => auth()->user()->id
                ]);
            }
        } else {
            $ot->update([
                'status' => 'REJECTED',
                'rejected_at' => date('Y-m-d H:i:s'),
                'rejected_by' => auth()->user()->id
            ]);
        }

        return redirect()->route('employee_request', ['overtimes' => 1])->with('ot-success', 'The request has been updated.');
    }

    public function leaveForm(Request $request)
    {
        $user_input = $request->all();
        $leave = Leave::find($user_input['leave_id']);
        $employee_request = EmployeeLeaves::where('user_id', $leave->created_by)->first();

        if ($user_input['leave_form_btn'] == 'approve') {

            $is_updated = self::adjustUserLog('leave', $leave);
            if ($is_updated) {
                if ($leave->leave_type == 'BIRTHDAY' && $employee_request->sick_credit > 0) {
                    $employee_request->decrement('sick_credit');
                } elseif ($leave->leave_type == 'VACATION' && $employee_request->vacation_credit > 0) {
                    $employee_request->decrement('vacation_credit');
                } else {
                    return redirect()->back()->with('ot-failed', 'No more credit for his/her account');
                }

                $leave->update([
                    'status' => 'APPROVED',
                    'approved_at' => now(),
                    'approved_by' => auth()->user()->id
                ]);
            }
        } else {
            $leave->update([
                'status' => 'REJECTED',
                'rejected_at' => date('Y-m-d H:i:s'),
                'rejected_by' => auth()->user()->id
            ]);
        }

        return redirect()->route('employee_request', ['leaves' => 1])->with('ot-success', 'The request has been updated.');
    }

    public function adjustUserLog($request_type, $request_item)
    {
        if ($request_type === 'ob') {
            $date = $request_item->date_from;
            $user_id = $request_item->created_by;
            $log_in_time = $request_item->time_from;
            $log_out_time = $request_item->time_to;
            $log_in = UserLog::where([
                'user_id' => $user_id,
                'log_type_id' => 1,
                'log_date' => $date,
            ])?->first();
            $log_out = UserLog::where([
                'user_id' => $user_id,
                'log_type_id' => 2,
                'log_date' => $date,
            ])->first();
            $is_login_existing = $log_in?->exists();
            $is_logout_existing = $log_out?->exists();
            if ($is_login_existing) {
                $log_in->update([
                    'schedule_types_id' => $request_item->schedule_types_id,
                    'log_at' => "$date $log_in_time",
                ]);
            } else {
                UserLog::create([
                    'user_id' => $user_id,
                    'log_type_id' => 1,
                    'schedule_types_id' => $request_item->schedule_types_id,
                    'log_at' => "$date $log_in_time",
                ]);
            }
            if ($is_logout_existing) {
                $log_out->update([
                    'schedule_types_id' => $request_item->schedule_types_id,
                    'log_at' => "$date $log_out_time",
                ]);
            } else {
                UserLog::create([
                    'user_id' => $user_id,
                    'log_type_id' => 2,
                    'schedule_types_id' => $request_item->schedule_types_id,
                    'log_at' => "$date $log_out_time",
                ]);
            }
            return true;
        } else if ($request_type === 'ot') {
            $date = $request_item->shift_date;
            $user_id = $request_item->created_by;
            $time_out = $request_item->time_end;
            $time_start = $request_item->time_start;

            $log_in = UserLog::where([
                'user_id' => $user_id,
                'log_type_id' => 1,
                'log_date' => $date,
            ]);

            if (!$log_in?->exists()) {
                UserLog::create([
                    'user_id' => $user_id,
                    'log_type_id' => 1,
                    'schedule_types_id' => $request_item->schedule_types_id,
                    'log_at' => "$date $time_start",
                ]);
            }

            $log_out = UserLog::where([
                'user_id' => $user_id,
                'log_type_id' => 2,
                'log_date' => $date,
            ]);

            if ($log_out?->exists()) {
                $log_out->update([
                    'schedule_types_id' => $request_item->schedule_types_id,
                    'log_at' => "$date $time_out",
                ]);
            } else {
                UserLog::create([
                    'user_id' => $user_id,
                    'log_type_id' => 2,
                    'schedule_types_id' => $request_item->schedule_types_id,
                    'log_at' => "$date $time_out",
                ]);
            }

            return true;
        } else if ($request_type === 'leave') {
            if ($request_item->duration === 'WHOLEDAY') {
                $date = $request_item->leave_from;
                $user_id = $request_item->created_by;
                $schedule_types_id = $request_item->schedule_types_id;
                $dayname = date("l", strtotime($date));
                $schedule = WorkSchedule::where([
                    'schedule_types_id' => $schedule_types_id,
                    'work_day' => $dayname
                ])->first();

                $log_in = UserLog::where([
                    'user_id' => $user_id,
                    'log_type_id' => 1,
                    'log_date' => $date,
                ])?->first();
                $log_out = UserLog::where([
                    'user_id' => $user_id,
                    'log_type_id' => 2,
                    'log_date' => $date,
                ])->first();
                $is_login_existing = $log_in?->exists();
                $is_logout_existing = $log_out?->exists();
                if ($is_login_existing) {
                    $log_in->update([
                        'schedule_types_id' => $schedule_types_id,
                        'log_at' => "$date $schedule->work_from",
                    ]);
                } else {
                    UserLog::create([
                        'user_id' => $user_id,
                        'log_type_id' => 1,
                        'schedule_types_id' => $schedule_types_id,
                        'log_at' => "$date $schedule->work_from",
                    ]);
                }
                if ($is_logout_existing) {
                    $log_out->update([
                        'schedule_types_id' => $schedule_types_id,
                        'log_at' => "$date $schedule->work_to",
                    ]);
                } else {
                    UserLog::create([
                        'user_id' => $user_id,
                        'log_type_id' => 2,
                        'schedule_types_id' => $schedule_types_id,
                        'log_at' => "$date $schedule->work_to",
                    ]);
                }
            }
            return true;
        }
    }
}
