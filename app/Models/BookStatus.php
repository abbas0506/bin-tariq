<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookStatus extends Model
{
    use HasFactory;
    protected $fillable = [
        'book_id',
        'copy_no',
        'status',
    ];
}
