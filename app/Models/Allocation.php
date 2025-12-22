<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_id',
        'lecture_no',
        'subject_id',
        'teacher_id',
        'day1',
        'day2',
        'day3',
        'day4',
        'day5',
        'day6',
        'room_no'
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function testAllocations()
    {
        return $this->hasMany(TestAllocation::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function scopeHavingLectureNo($query, $lecture_no)
    {
        return $query->where('lecture_no', $lecture_no);
    }

    public function tests()
    {
        return $this->belongsToMany(Test::class, 'test_allocations', 'test_id', 'allocation_id')
            ->withTimestamps(); // Include timestamps if present
    }
}
