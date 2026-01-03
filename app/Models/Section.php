<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',    //section label A, B, C
        'level',
    ];

    public function incharge()
    {
        //
        $inchargeId = $this->allocations->where('lecture_no', 1)->value('user_id');
        $incharge = User::findOrFail($inchargeId);
        return $incharge;
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }
    public function testAllocations()
    {
        return $this->hasMany(TestAllocation::class);
    }
    public function scopeActive($query)
    {
        return true;
    }
    public function  studentRank($sortedPercentages, $specificId)
    {
        $index = $sortedPercentages->search(function ($student) use ($specificId) {
            return $student['id'] === $specificId;
        });

        if ($index !== false) {
            return $index + 1;
        } else {
            return '';
        }
    }
    public function attendances()
    {
        return $this->hasManyThrough(Attendance::class, Student::class);
    }
    public function feeInvoices()
    {
        return $this->hasManyThrough(FeeInvoice::class, Student::class);
    }
    public function attendanceMarked()
    {
        return $this->attendances()->whereDate('date', today())->count();
    }
}
