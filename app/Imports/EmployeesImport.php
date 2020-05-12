<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $fullName = $row[0];
        if(empty($fullName)) return null;

        $employeeDetail = Employee::where('full_name', $fullName)
            ->first();
        if(empty($employeeDetail)){
            $employeeDetail = Employee::create([
                'full_name' => $fullName,
            ]);
        }
        
        return $employeeDetail;
    }
}
