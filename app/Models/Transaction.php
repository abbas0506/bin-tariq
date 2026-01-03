<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'reference',
        'description',
        'created_by'
    ];

    public function lines()
    {
        return $this->hasMany(TransactionLine::class);
    }
    public function feeInvoices()
    {
        return $this->hasMany(FeeInvoice::class);
    }
}
