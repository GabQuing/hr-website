<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Gender;
use App\Models\CivilStatus;
use App\Models\BasicInformation;
use App\Models\company;
use App\Models\department;
use App\Models\work_information;
use App\Models\employment_status;
use App\Models\GovernmentInformation;
use App\Models\EducationBackground;
use App\Models\ContactInformation;
use App\Models\WorkSchedule;
use App\Models\immediate_supervisor;
use App\Models\user_type;
use App\Models\employee_type;
use App\Models\schedule_type;
use App\Models\work_hours;
use App\Models\education_type;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use DateTime;
use Illuminate\Support\Facades\Hash;


class EditUserAccounts implements 
    ToModel, 
    WithValidation, 
    WithHeadingRow,
    WithBatchInserts,
    WithChunkReading
{
    use Importable;
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        date_default_timezone_set('Asia/Manila');

        

        $lastName = strtoupper($row['last_name']);
        $middleName = strtoupper($row['middle_name']);
        $firstName = strtoupper($row['first_name']);
        $immediate_supervisor = strtoupper($row['immediate_supervisor']);
        $designated_work_place = strtoupper($row['designated_work_place']);
        $title = strtoupper($row['title']);
        $job_code = strtoupper($row['job_code']);
        $school = strtoupper($row['school']);
        $degree = strtoupper($row['degree']);
        $local_trunk_line = strtoupper($row['local_trunk_line']);
        $pin = strtoupper($row['pin']);
        $home_address = strtoupper($row['home_address']);
        $city = strtoupper($row['city']);
        $province = strtoupper($row['province']);
        $country = strtoupper($row['country']);
        $contact_name = strtoupper($row['emergency_contact_name']);
        $relationship = strtoupper($row['emergency_contact_relationship']);
        $contact_address = strtoupper($row['emergency_contact_address']);
        $regularizationDate = strtoupper($row['regularization_date']);
        $taxStatus = strtoupper($row['tax_status']);
        $mobile_number = $row['mobile_number'];
        $sss = $row['sss'];
        $philHealth = $row['philhealth'];
        $tin = $row['tin'];
        $hdmf = $row['hdmf'];
        $pagIbig = $row['pag_ibig'];
        $zip_code = $row['zip_code'];
        $contact_number = $row['emergency_contact_number'];
        $dateOfBirth = Date::excelToDateTimeObject($row['date_of_birth']);
        $dateOfBirth = $dateOfBirth->format('Y-m-d');
        $hireDate = Date::excelToDateTimeObject($row['hire_date']);
        $hireDate = $hireDate->format('Y-m-d');
        $expectRegularDate = Date::excelToDateTimeObject($row['hire_date']);
        $expectRegularDate = $expectRegularDate->format('Y-m-d');
        $from = Date::excelToDateTimeObject($row['hire_date']);
        $from = $from->format('Y-m-d');
        $to = Date::excelToDateTimeObject($row['hire_date']);
        $to = $to->format('Y-m-d');
        $genders = Gender::pluck('id', 'name')->all();
        $gender =  $genders[strtoupper($row['gender'])];
        $civilStatuses = CivilStatus::pluck('id','name')->all();
        $civilStatus = $civilStatuses[strtoupper($row['civil_status'])];
        $companies = company::pluck('id','name')->all();
        $company = $companies[strtoupper($row['company'])];
        $departments = department::pluck('id','name')->all();
        $department = $departments[strtoupper($row['department'])];
        $employment_statuses = employment_status::pluck('id','name')->all();
        $employment_status = $employment_statuses[strtoupper($row['employment_status'])];
        $user_types = user_type::pluck('id','name')->all();
        $user_type = $user_types[strtoupper($row['user_type'])];
        $employee_types = employee_type::pluck('id','name')->all();
        $employee_type = $employee_types[strtoupper($row['employee_type'])];
        $schedule_types = schedule_type::pluck('id', 'name')->all();
        $schedule_type =  $schedule_types[strtoupper($row['schedule_type'])]; 
        $workHours = work_hours::pluck('id', 'name')->all();
        $workHour =  $workHours[strtoupper($row['working_hours'])];
        $education_types = education_type::pluck('id', 'name')->all();
        $education_type =  $education_types[strtoupper($row['education_type'])];

        User::leftJoin(
            'basic_information',
            'basic_information.user_id',
            '=',
            'users.id'
        )
        ->leftJoin(
            'work_informations',
            'work_informations.user_id',
            '=',
            'users.id'
        )
        ->leftJoin(
            'work_schedules',
            'work_schedules.user_id',
            '=',
            'users.id'
        )
        ->leftJoin(
            'government_information',
            'government_information.user_id',
            '=',
            'users.id'
        )
        ->leftJoin(
            'education_backgrounds',
            'education_backgrounds.user_id',
            '=',
            'users.id'
        )
        ->leftJoin(
            'contact_information',
            'contact_information.user_id',
            '=',
            'users.id'
        )
        ->where('users.mobile_number', $row['mobile_number'])
        ->update([
            'basic_information.last_name' => $lastName,
            'basic_information.middle' => $middleName,
            'basic_information.first_name' => $firstName,
            'basic_information.gender_id' => $gender,
            'basic_information.civil_status_id' => $civilStatus,
            'basic_information.date_of_birth' => $dateOfBirth,
            'basic_information.mobile_number' => $mobile_number,
            'basic_information.email' => $row['email_optional'],
            'basic_information.updated_at' => date('Y-m-d H:i:s'),
            'work_informations.company_id' => $company,
            'work_informations.department_id' => $department,
            'work_informations.immediate_supervisor' => $immediate_supervisor,
            'work_informations.designated_work_place' => $designated_work_place,
            'work_informations.title' => $title,
            'work_informations.employment_status_id' => $employment_status,
            'work_informations.user_type_id' => $user_type,
            'work_informations.employee_type_id' => $employee_type,
            'work_informations.job_code' => $job_code,
            'work_informations.hire_date' => $hireDate,
            'work_informations.expected_regularization_date' => $expectRegularDate,
            'work_informations.regularization_date' => $regularizationDate,
            'work_schedules.work_hours_id' => $workHour,
            'work_schedules.schedule_type_id' => $schedule_type,
            'government_information.sss' => $sss,
            'government_information.phil_Health' => $philHealth,
            'government_information.tin' => $tin,
            'government_information.hdmf' => $hdmf,
            'government_information.pag_ibig' => $pagIbig,
            'government_information.tax_status' => $taxStatus,
            'education_backgrounds.education_type_id' => $education_type,
            'education_backgrounds.school' => $school,
            'education_backgrounds.from' => $from,
            'education_backgrounds.to' => $to,
            'education_backgrounds.degree' => $degree,
            'contact_information.mobile_number' => $mobile_number,
            'contact_information.local_trunk_line' => $local_trunk_line,
            'contact_information.pin' => $pin,
            'contact_information.home_address' => $home_address,
            'contact_information.home_city' => $city,
            'contact_information.state_province' => $province,
            'contact_information.zip_code' => $zip_code,
            'contact_information.country' => $country,
            'contact_information.contact_number' => $contact_number,
            'contact_information.contact_name' => $contact_name,
            'contact_information.relationship' => $relationship,
            'contact_information.address' => $contact_address,




        ]);




    }

    public function rules(): array{
        return [
            '*.first_name' => 'required',
            '*.middle_name' => 'required',
            '*.last_name' => 'required',
            '*.immediate_supervisor' => 'required',
            '*.designated_work_place' => 'required',
            '*.title' => 'required',
            '*.job_code' => 'required',

            '*.mobile_number' => [
                'required',
                'regex:/^[0]{1}[9]{1}[0-9]{2}[0-9]{3}[0-9]{4}$/',
            ],   
            '*.sss' => [
                'required',
                'regex:/^[0-9]{10}$/',
            ],   
            '*.philhealth' => [
                'required',
                'regex:/^[0-9]{12}$/',
            ],   
            '*.tin' => [
                'required',
                'regex:/^[0-9]{9}$/',
            ],   
            '*.hdmf' => [
                'required',
                'regex:/^[0-9]{10}$/',
            ],   
            '*.pag_ibig' => [
                'required',
                'regex:/^[0-9]{12}$/',
            ],   
            '*.tax_status' => [
                'required',
            ],   
            '*.school' => [
                'required',
            ],  
            '*.degree' => [
                'required',
            ],
            '*.local_trunk_line' => [
                'required',
            ],
            '*.pin' => [
                'required',
            ],
            '*.emergency_contact_number' => [
                'required',
                'regex:/^[0]{1}[9]{1}[0-9]{2}[0-9]{3}[0-9]{4}$/',
            ],   
            '*.emergency_contact_name' => [
                'required',
            ],   
            '*.emergency_contact_relationship' => [
                'required',
            ],   
            '*.emergency_contact_address' => [
                'required',
            ],   
            '*.gender' => [
                'required',
                function ($attribute, $value, $fail){
                    $genderNames = Gender::pluck('name')->toArray();
                    if (!in_array(strtoupper($value), $genderNames)) {
                        $fail('Invalid gender Value.');
                    }
                },
            ],
            '*.civil_status' => [
                'required',
                function ($attribute, $value, $fail){
                    $civilStatusNames = CivilStatus::pluck('name')->toArray();
                    if (!in_array(strtoupper($value), $civilStatusNames)) {
                        $fail('Invalid Civil Status Value.');
                    }
                },
            ],
            '*.company' => [
                'required',
                function ($attribute, $value, $fail){
                    $companyNames = company::pluck('name')->toArray();
                    if (!in_array(strtoupper($value), $companyNames)) {
                        $fail('Invalid company Value.');
                    }
                },
            ],
            '*.employee_type' => [
                'required',
                function ($attribute, $value, $fail){
                    $employeeTypeNames = employee_type::pluck('name')->toArray();
                    if (!in_array(strtoupper($value), $employeeTypeNames)) {
                        $fail('Invalid Employee Type Value.');
                    }
                },
            ],
            '*.employment_status' => [
                'required',
                function ($attribute, $value, $fail){
                    $employeeStatusNames = employment_status::pluck('name')->toArray();
                    if (!in_array(strtoupper($value), $employeeStatusNames)) {
                        $fail('Invalid Employment Status Value.');
                    }
                },
            ],
            '*.user_type' => [
                'required',
                function ($attribute, $value, $fail){
                    $userTypeNames = user_type::pluck('name')->toArray();
                    if (!in_array(strtoupper($value), $userTypeNames)) {
                        $fail('Invalid User Type Value.');
                    }
                },
            ],
            '*.schedule_type' => [
                'required',
                function ($attribute, $value, $fail){
                    $scheduleTypeNames = schedule_type::pluck('name')->toArray();
                    if (!in_array(strtoupper($value), $scheduleTypeNames)) {
                        $fail('Invalid Schedule Type Value.');
                    }
                },
            ],
            '*.working_hours' => [
                'required',
                function ($attribute, $value, $fail){
                    $workingHoursNames = work_hours::pluck('name')->toArray();
                    if (!in_array(strtoupper($value), $workingHoursNames)) {
                        $fail('Invalid Working Hours Value.');
                    }
                },
            ],
            '*.education_type' => [
                'required',
                function ($attribute, $value, $fail){
                    $educationTypeNames = education_type::pluck('name')->toArray();
                    if (!in_array(strtoupper($value), $educationTypeNames)) {
                        $fail('Invalid Education Type Value.');
                    }
                },
            ],
        ];
    }
    
    public function batchSize(): int
    {
        return 100; 
    }

    public function chunkSize(): int
    {   
        return 100;
    }
}
