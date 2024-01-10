<?php

namespace App\Imports;

use App\Models\User;
use App\Models\BasicInformation;
use App\Models\work_information;
use App\Models\GovernmentInformation;
use App\Models\EducationBackground;
use App\Models\ContactInformation;
use App\Models\WorkSchedule;
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
use Illuminate\Support\Facades\Hash;


class CreateUserAccounts implements 
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
        $firstName = strtoupper($row['first_name']);
        $lastName = strtoupper($row['last_name']);
        $id = User::insertGetId([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'name' => $firstName.' '.$lastName,
            'mobile_number' => $row['mobile_number'],
            'email' => $row['email'],
            'employee_name' => $lastName.'_'.$firstName,
            'approval_status' => 'PENDING',
            'password' => Hash::make($row['temporary_password']),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $user = User::find((int)$id);
        $user->assignRole('employee');

        $basic_information = new BasicInformation([
        'user_id' => $id,
        'created_at' => date('Y-m-d H:i:s'),
        ]);
        
        $work_information = new work_information([
            'user_id' => $id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $government_information = new GovernmentInformation([
            'user_id' => $id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $education_background = new EducationBackground([
            'user_id' => $id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $contact_information = new ContactInformation([
            'user_id' => $id,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // $work_schedule = new WorkSchedule([
        //     'user_id' => $id,
        //     'created_at' => date('Y-m-d H:i:s'),
        // ]);

        $basic_information->save();
        $work_information->save();
        $government_information->save();
        $education_background->save();
        $contact_information->save();
        // $work_schedule->save();
    }

    public function rules(): array{
        return [
            '*.email' => ['required', 'unique:users'],
            '*.first_name' => 'required',
            '*.last_name' => 'required',    
            '*.mobile_number' => [
                'required',
                'regex:/^[0]{1}[9]{1}[0-9]{2}[0-9]{3}[0-9]{4}$/',
                'unique:users'
            ],
            '*.temporary_password' => 'required|min:8'
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
