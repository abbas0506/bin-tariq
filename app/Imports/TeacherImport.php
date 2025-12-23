<?php

namespace App\Imports;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class userImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $user = Profile::create([
                'name' => $row['name'],
                'designation' => $row['designation'],
                'bps' => $row['bps'],
                'qualification' => $row['qualification'],
                'phone' => $row['phone'],
                'email' => $row['email'],
                'cnic' => $row['cnic'],

            ]);
            $user = User::create([
                'email' => $user->cnic,
                'password' => Hash::make('password'),
                'userable_id' => $user->id,
                'userable_type' => 'App\Models\User',
            ]);

            $user->assignRole('user');
        }
    }
}
