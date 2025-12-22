<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'photo',
        'name',
        'bform',
        'dob',
        'id_mark',
        'phone',
        'address',
        'caste',
        'distinction',
        'gender',
        'blood_group',
        'is_orphan',
        'father_name',
        'father_cnic',

        //academic info
        'group_id',
        'section_id',
        'rollno',
        'admission_no',
        'admission_date',
        'score',

        // guardian info
        'caste',
        'profession',
        'income',

        'card_printed',
        'library_banned',

    ];

    protected $casts = [
        'dob' => 'date',   // Cast as Carbon date
        'admission_date' => 'date',   // Cast as Carbon date
    ];
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class, 'fees', 'student_id', 'voucher_id');
    }

    public function fees()
    {
        return $this->hasMany(Fee::class);
    }


    public function bookIssuances()
    {
        return $this->hasMany(BookIssuance::class, 'user_id');
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function testAllocations()
    {
        return $this->hasManyThrough(TestAllocation::class, Result::class);
    }

    public function testRank($sortedPercentages)
    {
        $index = $sortedPercentages->search(function ($ranking) {
            return $ranking['id'] == $this->id;
        });

        //!== will only be false if record could not be found
        if ($index !== false) {
            $ranking = $sortedPercentages->get($index);
            return $ranking['position'];
        } else {
            return '';
        }
        // Find the key (position) of the specific student
        // $index = $sortedPercentages->search(function ($ranking) {
        //     return $ranking['id'] == $this->id;
        // });

        // //!== will only be false if record could not be found
        // if ($index !== false) {
        //     // $ranking = $sortedPercentages->get($index);
        //     return $index + 1;
        // } else {
        //     return '';
        // }
    }
    public function testTotal($sortedPercentages)
    {
        // Find the key (position) of the specific student
        $index = $sortedPercentages->search(function ($ranking) {
            return $ranking['id'] == $this->id;
        });

        //!== will only be false if record could not be found
        if ($index !== false) {
            $ranking = $sortedPercentages->get($index);
            return $ranking['max_marks'];
        } else {
            return '';
        }
    }
    public function testAggregate($sortedPercentages)
    {
        // Find the key (position) of the specific student
        $index = $sortedPercentages->search(function ($ranking) {
            return $ranking['id'] == $this->id;
        });

        //!== will only be false if record could not be found
        if ($index !== false) {
            $ranking = $sortedPercentages->get($index);
            return $ranking['obtained_marks'];
        } else {
            return '';
        }
    }

    public function testPercentage($sortedPercentages)
    {
        // Find the key (position) of the specific student
        $index = $sortedPercentages->search(function ($ranking) {
            return $ranking['id'] == $this->id;
        });

        //!== will only be false if record could not be found
        if ($index !== false) {
            $ranking = $sortedPercentages->get($index);
            return $ranking['percentage'];
        } else {
            return '';
        }
    }

    public function maximumMarks($testId)
    {
        $sumMarks = $this  // Find the student by ID
            ->results()  // Get the student's results
            ->whereHas('testAllocation', function ($query) use ($testId) {
                $query->where('test_id', $testId);  // Filter by test_id in the test_allocations
            })
            ->join('test_allocations', 'results.test_allocation_id', '=', 'test_allocations.id')  // Join test_allocations to results
            ->sum('test_allocations.max_marks');  // Sum the max_marks from the test_allocations


        return $sumMarks;
    }
    public function scopeCreatedToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function previousAbsences()
    {
        return $this->attendances()
            ->where('status', 0)
            ->whereDate('date', '<', today());
    }
    public function currentAbsences()
    {
        return $this->attendances()
            ->where('status', 0)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year);
    }
}
