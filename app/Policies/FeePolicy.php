<?php

namespace App\Policies;

use App\Models\Fee;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FeePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->hasAnyRole(['principal', 'admin', 'teacher']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Fee $fee): bool
    {
        //
        return $user->hasAnyRole(['principal', 'admin', 'teacher']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->hasAnyRole(['principal', 'admin']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Fee $fee): bool
    {
        //
        return $user->hasAnyRole(['principal', 'admin']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Fee $fee): bool
    {
        //
        return $user->hasRole(['principal']);
    }
}
