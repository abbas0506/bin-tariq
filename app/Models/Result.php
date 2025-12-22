<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;
    protected $fillable = [
        'test_allocation_id',
        'student_id',
        'obtained_marks',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function testAllocation()
    {
        return $this->belongsTo(TestAllocation::class);
    }
    public function scopeTest($query, $testId)
    {
        return $query->whereHas('testAllocation', function ($query) use ($testId) {
            $query->where('test_id', $testId);
        });
    }

    public function scopeForLectureNo($query, $lectureNo)
    {
        return $query->whereHas('testAllocation', function ($query) use ($lectureNo) {
            $query->where('lecture_no', $lectureNo);
        });
    }
}
