<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'name',
        'type',
        'parent_id'
    ];

    public function lines()
    {
        return $this->hasMany(TransactionLine::class);
    }

    public function parent()
    {
        return $this->belongsTo(Account::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Account::class, 'parent_id');
    }

    // Dynamic balance (NO balance column)
    public function balance()
    {
        if (in_array($this->type, ['asset', 'expense'])) {
            return $this->lines()->sum('debit') - $this->lines()->sum('credit');
        }

        return $this->lines()->sum('credit') - $this->lines()->sum('debit');
    }
}
