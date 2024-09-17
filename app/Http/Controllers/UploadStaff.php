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
    
        foreach (array_slice($array[0], 1) as $value) 
        {
            if (count($value) <= 20) {
                continue;
            }
    
            $staffData = [];
            foreach ($fields as $field => $index) {
                if ($field === 'contract_start' || $field === 'contract_end' || $field === 'date_of_birth') {
                    $excelDate = $value[$index];
                    if (is_numeric($excelDate)) {
                        // Adjust for Excel date origin (December 30, 1899)
                        $excelDateTime = Date::excelToDateTimeObject($excelDate);
                        // Format DateTime object as required
                        $staffData[$field] = $excelDateTime->format('Y-m-d');
                    } elseif (is_string($excelDate)) {
                        // Try to parse string date value
                        $excelDateTime = \DateTime::createFromFormat('d/m/Y', $excelDate);
                        if ($excelDateTime !== false) {
                            $staffData[$field] = $excelDateTime->format('Y-m-d');
                        } else {
                            $staffData[$field] = null;
                        }
                    } else {
                        $staffData[$field] = null;
                    }
                } else {
                    $staffData[$field] = $value[$index];
                }
            }
            
            // Validate required fields
            $validator = FacadesValidator::make($staffData, [
                'name' => 'required',
            ]);
    
            if ($validator->fails()) {
                continue;
            }
    
            // Check if a staff record with the same staff_number already exists
            $existingStaff = Staff::where('staff_number', $staffData['staff_number'])->first();
            
            if ($existingStaff) {
                // If a staff record with the same staff_number exists, update it instead of creating a new one
                $existingStaff->update($staffData);
            } else {
                // Otherwise, create a new staff record
                $new_staff = new Staff($staffData);
                $new_staff->save();
            }
        }
    }
}    
