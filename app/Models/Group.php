<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'subjects_list',
        'admission_fee',

    ];
    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
