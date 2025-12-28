<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'max_marks',
        'user_id',   //test owner id , blank if combined test

        'is_open',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function allocations()
    {
        return $this->belongsToMany(Allocation::class, 'test_allocations', 'test_id', 'allocation_id');
    }

    public function testAllocations()
    {
        return $this->hasMany(TestAllocation::class);
    }

    public function scopeCombined($query)
    {
        return $query->whereNull('user_id');
    }
    public function scopeIndividual($query)
    {
        return $query->whereNotNull('user_id');
    }
}
