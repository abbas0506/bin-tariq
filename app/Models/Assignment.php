<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;
    protected $fillable = [
        'task_id',
        'teacher_id',
        'status', //boolean
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
