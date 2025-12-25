<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Attendance;
use App\Models\Fee;
use App\Models\Section;
use App\Policies\AttendancePolicy;
use App\Policies\FeePolicy;
use App\Policies\SectionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
        Section::class => SectionPolicy::class,
        Attendance::class => AttendancePolicy::class,
        Fee::class => FeePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
