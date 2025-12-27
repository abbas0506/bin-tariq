<?php

namespace App\Actions;

use App\Models\User;
use App\Models\Section;
use Illuminate\Support\Collection;

class GetAccessibleSections
{
    /**
     * Get sections accessible to the user based on role.
     */
    public function execute(User $user): Collection
    {
        // Principal & Admin → all sections
        if ($user->hasAnyRole(['principal', 'admin'])) {
            return Section::all();
        }

        // Teacher → only assigned sections
        if ($user->hasRole('teacher')) {
            return $user->sectionAsIncharge();
        }

        // Fallback → none
        return collect();
    }
}
