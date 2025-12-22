<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    protected $fillable = [
        'photo',
        'name',
        'bform',
        'gender',
        'phone',
        'dob',
        'id_mark',
        'address',
        'caste',
        'is_orphan',
        'father_name',
        'mother_name',
        'father_cnic',
        'mother_cnic',
        'profession',
        'income',

        'grade',
        'group_id',
        'pass_year',
        'medium',
        'previous_school',
        'bise',
        'rollno',
        'obtained_marks',
        'max_marks',
        'status',
        'amount_paid',
        'payment_date',
        'payment_mehtod',
        'fee_concession',
        'rejection_note',
    ];

    protected $casts = [
        'dob' => 'date',
        'pass_year' => 'integer',
        'income' => 'integer',
        'grade' => 'integer',
        'obtained_marks' => 'integer',
        'max_marks' => 'integer',
        'amount_paid' => 'integer',
        'payment_date' => 'date',
        'fee_concession' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Optional: relationship to Group
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function  objections()
    {
        return $this->hasMany(Objection::class);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }
    public function scopePreEngg($query)
    {
        return $query->where('group_id', 1);
    }

    public function scopeIcs($query)
    {
        return $query->where('group_id', 2);
    }

    public function scopeArts($query)
    {
        return $query->where('group_id', 3);
    }
    public function scopeOtherBoard($query)
    {
        return $query->where('bise', '<>', 'sahiwal');
    }
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }
    public function scopeAdmitted($query)
    {
        return $query->where('status', 'admitted');
    }
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeUnderprocess($query)
    {
        return $query->whereNull('objection')->whereNull('amount_paid');
    }
    public function scopeObjectioned($query)
    {
        return $query->whereNotNull('objection');
    }
    public function scopeFeepaid($query)
    {
        return $query->whereNotNull('amount_paid');
    }
    public function scopeRecentlyPaid($query)
    {
        return $query->whereDate('payment_date', today());
    }

    public function obtained_percentage()
    {
        return round($this->obtained_marks / $this->max_marks * 100, 2);
    }
}
