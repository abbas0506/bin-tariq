<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'description',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'assignments')
                    ->withPivot('status')
                    ->withTimestamps();
    }
    public function isOpen()
    {
        if ($this->due_date->gte(today()))
            return true;
        else
            return false;
    }
    public function whoHaveCompleted(){
        $teachers = $this->assignments()
            ->where('status', 1)
            ->with('teacher')
            ->get()
            ->pluck('teacher');
        return $teachers;
    }
    public function whoHaveNotCompleted(){
        $teachers = $this->assignments()
            ->where('status', 0)
            ->with('teacher')
            ->get()
            ->pluck('teacher');
        return $teachers;
    }
    public function whoHaveCompletedToday(){
        $teachers = $this->assignments()
            ->where('status', 1)
            ->with('teacher')
            ->whereDate('updated_at', today())
            ->get()
            ->pluck('teacher');
        return $teachers;
    }
   
}
