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
        'phone',
        'address',
        'cnic',
        'qualification',
        'photo',
        'status',
        'seniority',
        'gender',
        'salary',
        'joined_at',

        //bise tag will be in separate model
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }
}
