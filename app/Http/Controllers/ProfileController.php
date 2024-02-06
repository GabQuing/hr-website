<?php

namespace App\Http\Controllers;

use App\Models\BasicInformation;
use App\Models\GovernmentInformation;
use App\Models\EducationBackground;
use App\Models\ContactInformation;
use App\Models\WorkSchedule;
use App\Models\CivilStatus;
use App\Models\Gender;
use App\Models\User;
use App\Models\company;
use App\Models\department;
use App\Models\employee_type;
use App\Models\immediate_supervisor;
use App\Models\employment_status;
use App\Models\user_type;
use App\Models\work_information;
use App\Models\education_type;
use App\Models\schedule_type;
use App\Models\work_hours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ProfileController extends Controller
{
    public function index()
    {

        $data = [];
        $data['work_days'] = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $data['genders'] = Gender::get();
        $data['civil_status'] = CivilStatus::get();
        $data['companies'] = company::get();
        $data['departments'] = department::get();
        $data['employee_types'] = employee_type::get();
        $data['employment_statuses'] = employment_status::get();
        $data['user_types'] = user_type::get();
        $data['education_types'] = education_type::get();
        $data['schedule_types'] = schedule_type::get();
        $data['work_hour'] = work_hours::get();
        $data['basic_information'] = BasicInformation::where('user_id', auth()->user()->id)->first();
        $data['work_information'] = work_information::where('user_id', auth()->user()->id)->first();
        $data['government_information'] = GovernmentInformation::where('user_id', auth()->user()->id)->first();
        $data['education_background'] = EducationBackground::where('user_id', auth()->user()->id)->first();
        $data['contact_information'] = ContactInformation::where('user_id', auth()->user()->id)->first();
        $data['user_sched'] = User::where('id', auth()->user()->id)->first();
        $data['work_schedule'] = User::where('users.id', auth()->user()->id)
            ->leftJoin('schedule_types', 'schedule_types.id', 'users.schedule_types_id')
            ->leftJoin('work_schedules', 'work_schedules.schedule_types_id', 'schedule_types.id')
            ->get()
            ->toArray();
        $data['user_id'] = auth()->user()->id;
        $data['show_password'] = true;


        return view('my_profile', $data);
    }

    public function show(string $id)
    {
        $data = [];
        $data['work_days'] = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $data['user_info'] = User::find($id);
        $data['genders'] = Gender::get();
        $data['civil_status'] = CivilStatus::get();
        $data['companies'] = company::get();
        $data['departments'] = department::get();
        $data['employee_types'] = employee_type::get();
        $data['employment_statuses'] = employment_status::get();
        $data['user_types'] = user_type::get();
        $data['education_types'] = education_type::get();
        $data['schedule_types'] = schedule_type::get();
        $data['work_hour'] = work_hours::get();
        $data['basic_information'] = BasicInformation::where('user_id', $id)->first();
        $data['work_information'] = work_information::where('user_id', $id)->first();
        $data['government_information'] = GovernmentInformation::where('user_id', $id)->first();
        $data['education_background'] = EducationBackground::where('user_id', $id)->first();
        $data['contact_information'] = ContactInformation::where('user_id', $id)->first();
        $data['user_sched'] = User::where('id', $id)->first();
        $data['work_schedule'] = User::where('users.id', $id)
            ->leftJoin('schedule_types', 'schedule_types.id', 'users.schedule_types_id')
            ->leftJoin('work_schedules', 'work_schedules.schedule_types_id', 'schedule_types.id')
            ->get()
            ->toArray();
        $data['user_id'] = $id;

        $data['show_password'] = false;

        return view('my_profile', $data);
    }

    public function update(Request $request, string $id)
    {

        $firstName = strtoupper($request->input('first_name'));
        $middleName = strtoupper($request->input('middle'));
        $lastName = strtoupper($request->input('last_name'));

        BasicInformation::where('user_id', $id)->update([
            'first_name' => $firstName,
            'middle' => $middleName,
            'last_name' => $lastName,
            'mobile_number' => $request->input('mobile_number'),
            'gender_id' => $request->input('gender'),
            'civil_status_id' => $request->input('civil_status'),
            'date_of_birth' => $request->input('date_of_birth'),
            'email' => $request->input('email'),
        ]);

        return response()->json([
            'user' => 'success',
        ]);
    }


    public function updateWorkInfo(Request $request, string $id)
    {

        $title = strtoupper($request->input('title'));
        $designated_work_place = strtoupper($request->input('designated_work_place'));
        $regularization_date = strtoupper($request->input('regularization_date'));
        $immediate_supervisor = strtoupper($request->input('immediate_supervisor'));

        work_information::where('user_id', $id)->update([
            'company_id' => $request->input('company'),
            'department_id' => $request->input('department'),
            'title' => $title,
            'employee_type_id' => $request->input('employee_type'),
            'immediate_supervisor' => $immediate_supervisor,
            'designated_work_place' => $designated_work_place,
            'employment_status_id' => $request->input('employment_status'),
            'user_type_id' => $request->input('user_type'),
            'job_code' => $request->input('job_code'),
            'hire_date' => $request->input('hire_date'),
            'expected_regularization_date' => $request->input('expected_regularization_date'),
            'regularization_date' => $regularization_date,
        ]);

        return response()->json([
            'user' => 'success',
        ]);
    }

    public function updateGovernmentInfo(Request $request, string $id)
    {

        GovernmentInformation::where('user_id', $id)->update([
            'sss' => $request->input('sss'),
            'phil_health' => $request->input('phil_health'),
            'tin' => $request->input('tin'),
            'hdmf' => $request->input('hdmf'),
            'pag_ibig' => $request->input('pag_ibig'),
            'tax_status' => $request->input('tax_status'),
        ]);

        return response()->json([
            'user' => 'success',
        ]);
    }

    public function updateEducationBackground(Request $request, string $id)
    {

        $school = strtoupper($request->input('school'));
        $degree = strtoupper($request->input('degree'));

        EducationBackground::where('user_id', $id)->update([
            'education_type_id' => $request->input('education_type'),
            'school' => $school,
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'degree' => $degree,
        ]);

        return response()->json([
            'user' => 'success',
        ]);
    }

    public function updateContactInformation(Request $request, string $id)
    {

        $home_address = strtoupper($request->input('home_address'));
        $home_city = strtoupper($request->input('home_city'));
        $state_province = strtoupper($request->input('state_province'));
        $country = strtoupper($request->input('country'));
        $contact_name = strtoupper($request->input('contact_name'));
        $relationship = strtoupper($request->input('relationship'));
        $address = strtoupper($request->input('address'));

        ContactInformation::where('user_id', $id)->update([
            'mobile_number' => $request->input('mobile_number'),
            'local_trunk_line' => $request->input('local_trunk_line'),
            'pin' => $request->input('pin'),
            'home_address' => $home_address,
            'home_city' => $home_city,
            'state_province' => $state_province,
            'zip_code' => $request->input('zip_code'),
            'country' => $country,
            'contact_number' => $request->input('contact_number'),
            'contact_name' => $contact_name,
            'relationship' => $relationship,
            'address' => $address,
        ]);

        return response()->json([
            'user' => 'success',
        ]);
    }

    public function getSchedule(Request $request)
    {
        $user_request = $request->all();
        $user_schedule_type = $user_request['scheduleType'];
        $working_hours = schedule_type::where('id', $user_schedule_type)->pluck('working_hours')->first();
        $work_schedules = WorkSchedule::where('schedule_types_id', $user_schedule_type)->get();
        return response()->json(['working_hours' => $working_hours, 'entry' => $work_schedules]);
        // return view('schedule_profile', $user_schedule_type );
    }

    public function updateWorkSchedule(Request $request, string $id)
    {
        User::where('id', $id)->update([
            'schedule_types_id' => $request->input('schedule_type'),
        ]);

        return response()->json([
            'user' => 'success',
        ]);
    }



    public function updatePassword(Request $request, $id)
    {


        $user = User::find($id);
        if (Hash::check($request->all()['current_password'], $user->password)) {

            $request->validate([

                'new_password' => 'required|min:8',
                'confirmation_password' => 'required|min:8|same:new_password'
            ]);

            $user->password = Hash::make($request->get('new_password'));
            $user->save();

            return redirect()->back()->with('success', 'Password Updated, You will be Log-out.');
        } else {
            return redirect()->back()->with('error', 'Incorrect Current Password.');
        }
    }
}
