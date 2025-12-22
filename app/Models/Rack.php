<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rack extends Model
{
    use HasFactory;
    protected $fillable = [
        'label',
    ];

    public function domain()
    {
        return $this->belongsTo(Rack::class, 'domain_id');
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
    public function rangeOfQr()
    {
        $from =  $this->books->first()->serial();
        $to =  $this->books->last()->serial();
        return $from . ' - ' . $to;
    }
}
