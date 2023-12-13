<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SousOption;
use Illuminate\Auth\Access\HandlesAuthorization;

class SousOptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the sousOption can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the sousOption can view the model.
     */
    public function view(User $user, SousOption $model): bool
    {
        return true;
    }

    /**
     * Determine whether the sousOption can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the sousOption can update the model.
     */
    public function update(User $user, SousOption $model): bool
    {
        return true;
    }

    /**
     * Determine whether the sousOption can delete the model.
     */
    public function delete(User $user, SousOption $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the sousOption can restore the model.
     */
    public function restore(User $user, SousOption $model): bool
    {
        return false;
    }

    /**
     * Determine whether the sousOption can permanently delete the model.
     */
    public function forceDelete(User $user, SousOption $model): bool
    {
        return false;
    }
}
