<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',    //section label A, B, C
        'grade',
    ];

    public function fullName()
    {
        if ($this->name)
            if ($this->grade == 0)
                return $this->name;
            else
                return $this->grade . "(" . $this->name . ")";
        else
            return $this->grade;
    }

    public function incharge()
    {
        //
        $inchargeId = $this->allocations->where('lecture_no', 1)->value('teacher_id');
        $incharge = Teacher::findOrFail($inchargeId);
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
    public function fees()
    {
        return $this->hasManyThrough(Fee::class, Student::class);
    }
    public function attendanceMarked()
    {
        return $this->attendances()->whereDate('date', today())->count();
    }
}
