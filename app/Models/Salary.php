<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'month',
        'year',
        'amount',
        'status',
        'transaction_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
    public function billingMonth()
    {
        return config('enums.months')[$this->month] . "-" . $this->year - 2000;
    }
}
