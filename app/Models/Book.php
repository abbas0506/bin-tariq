<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'author',
        'publisher',
        'publish_year',
        'num_of_copies',
        'price',

        'language_id',
        'domain_id',
        'rack_id',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
    public function domain()
    {
        return $this->belongsTo(Domain::class, 'domain_id');
    }
    public function rack()
    {
        return $this->belongsTo(Rack::class, 'rack_id');
    }

    public function book_issuances()
    {
        return $this->hasMany(BookIssuance::class);
    }
    public function reference()
    {
        $pre = '';
        if ($this->id < 10) $pre = '000';
        elseif ($this->id < 100) $pre = '00';
        elseif ($this->id < 1000) $pre = '0';
        else $pre = '';
        return  $this->rack->label . "-" . $pre . $this->id;
    }
    public function serial()
    {
        $pre = '';
        if ($this->id < 10) $pre = '000';
        elseif ($this->id < 100) $pre = '00';
        elseif ($this->id < 1000) $pre = '0';
        else $pre = '';
        return  $pre . $this->id;
    }

    // readers
    public function readers()
    {
        return $this->hasManyThrough(Student::class, BookIssuance::class, 'reader_id');
    }
    public function scopeCreatedToday($query)
    {
        return $query->whereDate('created_at', today());
    }
}
