<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;
    protected $fillables = [
        'id',
        'lecture_no',
        'starts_at',
    ];
    protected $casts = [
        'starts_at' => 'datetime',
    ];
}
