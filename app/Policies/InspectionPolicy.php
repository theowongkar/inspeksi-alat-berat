<?php

namespace App\Policies;

use App\Models\Inspection;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InspectionPolicy
{
    /**
     * Determine whether the user can export models.
     */
    public function export(User $user): bool
    {
        return in_array($user->role, ['Admin', 'Inspector']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['Admin', 'Inspector']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Inspection $inspection): bool
    {
        return $user->role === 'Admin';
    }
}
