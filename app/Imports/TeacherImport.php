<?php

namespace App\Imports;

use App\Models\Profile;
use App\Models\Teacher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TeacherImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $teacher = Profile::create([
                'name' => $row['name'],
                'designation' => $row['designation'],
                'bps' => $row['bps'],
                'qualification' => $row['qualification'],
                'phone' => $row['phone'],
                'email' => $row['email'],
                'cnic' => $row['cnic'],

            ]);
            $user = User::create([
                'email' => $teacher->cnic,
                'password' => Hash::make('password'),
                'userable_id' => $teacher->id,
                'userable_type' => 'App\Models\Teacher',
            ]);

            $user->assignRole('teacher');
        }
    }
}
