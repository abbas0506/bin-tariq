<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeType extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'amount',
    ];

    public function  fees()
    {
        return $this->hasMany(Fee::class);
    }
}
