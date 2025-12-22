<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibraryRule extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_type',
        'max_books',
        'max_days',
        'fine_per_day',
    ];
}
