<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'amount',
        'bulk_invoice_id',
        'status', //paid, unpaid
    ];

    public function bulkInvoice()
    {
        return $this->belongsTo(BulkInvoice::class);
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }
}
