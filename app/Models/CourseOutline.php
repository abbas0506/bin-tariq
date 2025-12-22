<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseOutline extends Model
{
    use HasFactory;
    protected $fillable = [
        'day_no',   //1 to 80
        'subject_id',
        'grade',
        'topic',
        'activity',
        'assignment',
        'meida_url',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
