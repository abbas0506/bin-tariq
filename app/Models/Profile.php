<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'short_name',
        'father_name',
        'cnic',
        'dob',
        'blood_group',
        'address',
        'phone',
        'joined_at',
        'designation',
        'qualification',
        'bps',
        'personal_no',
        'seniority',
        'photo',
        'status',

        //bise tag will be in separate model
    ];

    protected $casts = [
        'dob' => 'date',   // Cast as Carbon date
        'joined_at' => 'date',   // Cast as Carbon date
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
