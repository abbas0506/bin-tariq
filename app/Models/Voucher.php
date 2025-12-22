<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'amount',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'fees', 'voucher_id', 'student_id');
    }
    public function fees()
    {
        return $this->hasMany(Fee::class);
    }

    public function sumOfPaidAmount()
    {
        return $this->fees->where('status',1)->count()*$this->amount;
    }
    public function isOpen()
    {
        if ($this->due_date->gte(today()))
            return true;
        else
            return false;
    }
    
    // Get students of a section who have paid this voucher
    public function studentsWhoHavePaid($sectionId)
    {
        return Student::where('section_id', $sectionId)
            ->whereHas('fees', function ($query) {
                $query->where('voucher_id', $this->id)
                      ->where('status', 1);
            })
            ->get();
    }
    public function studentsWhoHavePaidToday($sectionId)
    {
        return Student::where('section_id', $sectionId)
            ->whereHas('fees', function ($query) {
                $query->where('voucher_id', $this->id)
                      ->where('status', 1)
                      ->whereDate('updated_at',today());
            })
            ->get();
    }

    // Get students of a section who have NOT paid this voucher
    public function studentsWhoHaveNotPaid($sectionId)
    {
        return Student::where('section_id', $sectionId)
            ->whereDoesntHave('fees', function ($query) {
                $query->where('voucher_id', $this->id)
                      ->where('status', 1);
            })
            ->get();
    }

    public function studentsFromSection($sectionId)
    {
        return Student::where('section_id', $sectionId)
            ->whereHas('fees', function ($query) {
                $query->where('voucher_id', $this->id);
            })
            ->get();
    }
    public function sumOfPaidAmountForSection($sectionId)
    {
        return $this->studentsWhoHavePaid($sectionId)->count()*$this->amount;
    }
}


