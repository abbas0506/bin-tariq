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
        'designation',
        'bps',
        'phone',
        'cnic',
        'qualification',
        'image',

        //bise tag will be in separate model
    ];

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function bookIssuances()
    {
        return $this->hasMany(BookIssuance::class, 'user_id');
    }
}
