<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alumni extends Model
{
    use HasFactory;
    protected $fillable = [
        'prefix',
        'name',
        'phone',
        'address',
        'session',
        'introduction',
        'photo'
    ];
}
