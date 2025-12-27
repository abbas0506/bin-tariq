<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        // 'user_id',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }
    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }
    public function tests()
    {
        return $this->hasMany(Test::class);
    }
    public function testAllocations()
    {
        return $this->hasMany(TestAllocation::class);
    }
    public function isIncharge()
    {
        return $this->allocations->where('lecture_no', 1)->count();
    }
    public function sectionAsIncharge()
    {
        $sectionIds = $this->allocations->where('lecture_no', 1)->pluck('section_id');
        $sections = Section::whereIn('id', $sectionIds)->get();
        if ($sections) return $sections;
        return collect();
    }
    public function tasks()
    {
        return $this->belongsToMany(Task::class)
            ->withPivot('status')
            ->withTimestamps();
    }
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
