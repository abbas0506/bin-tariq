<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'student_id',
        'voucher_id',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
