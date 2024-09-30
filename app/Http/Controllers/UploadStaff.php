<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Staff;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Validation\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class UploadStaff extends Controller
{
   
    public function uploadStaff(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv|max:10240',
    ]);

    $file = $request->file('file');
    $array = Excel::toArray([], $file);

    // Map Excel columns to corresponding table fields
    $fields = [
        'staff_number' => 0,
        'nin_number' => 1,
        'name' => 2,
        'date_of_birth' => 3,
        'home_district' => 4,
        'title' => 5,
        'contract_start' => 6,
        'contract_end' => 7,
        'project' => 8,
        'region' => 9,
        'duty_station' => 10,
        'line_manager' => 11,
        'telephone' => 12,
        'email' => 13,
        'bank' => 14,
        'bank_account' => 15,
        'tin' => 16,
        'nssf' => 17,
        'marital_status' => 18,
        'next_of_kin' => 19,
        'contact_of_kin' => 20,
        'relationship' => 21,
    ];

    foreach (array_slice($array[0], 1) as $row) 
    {
        // Check if the row contains enough columns
        if (count($row) < count($fields)) {
            continue;  // Skip rows with missing columns
        }

        $staffData = [];

        foreach ($fields as $field => $index) {
            // Handle date fields and other fields
            if (in_array($field, ['contract_start', 'contract_end', 'date_of_birth'])) {
                $excelDate = $row[$index];
                if (is_numeric($excelDate)) {
                    $excelDateTime = Date::excelToDateTimeObject($excelDate);
                    $staffData[$field] = $excelDateTime->format('Y-m-d');
                } else {
                    $staffData[$field] = $excelDate; // Assuming date is in a proper string format
                }
            } else {
                $staffData[$field] = $row[$index];  // Directly map other fields
            }
        }

      
       // Validate required fields
       $validator = FacadesValidator::make($staffData, [
        'name' => 'required',
    ]);

        if ($validator->fails()) {
            continue;  // Skip invalid rows
        }

        // Check if staff exists, then update or create
        $existingStaff = Staff::where('staff_number', $staffData['staff_number'])->first();
        if ($existingStaff) {
            $existingStaff->update($staffData);
        } else {
            Staff::create($staffData);  // Create new record if not exists
        }
    }
}

}    
