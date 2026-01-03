<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'fee_type_id',
        'amount',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }
}
