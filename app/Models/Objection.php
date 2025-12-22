<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objection extends Model
{
    use HasFactory;
    protected $fillables = [
        'objection',
        'resolved',
    ];
    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
