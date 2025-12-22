<?php

namespace App\Imports;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;

class StudentImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    //
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $dob = $row['dob'];

            // Handle both Excel date formats (numeric and string)
            if (is_numeric($dob)) {
                // Convert Excel serial date to Y-m-d
                $dob = Carbon::instance(ExcelDate::excelToDateTimeObject($dob))->format('Y-m-d');
            } else {
                // Parse string format dd-mm-yy safely
                try {
                    $dob = Carbon::createFromFormat('d-m-y', $dob)->format('Y-m-d');
                } catch (\Exception $e) {
                    $dob = null; // invalid or empty date
                }
            }
            $student = Student::create([
                'rollno' => $row['rollno'],
                'name' => $row['name'],
                'father_name' => $row['father'],
                'bform' => $row['bform'],
                'dob' => $dob,
                'admission_no' => $row['admission_no'],
                'section_id' => session('section_id'),
            ]);
        }
    }
}
