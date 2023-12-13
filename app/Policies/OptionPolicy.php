<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Option;
use Illuminate\Auth\Access\HandlesAuthorization;

class OptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the option can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the option can view the model.
     */
    public function view(User $user, Option $model): bool
    {
        return true;
    }

    /**
     * Determine whether the option can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the option can update the model.
     */
    public function update(User $user, Option $model): bool
    {
        return true;
    }

    /**
     * Determine whether the option can delete the model.
     */
    public function delete(User $user, Option $model): bool
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
     * Determine whether the option can restore the model.
     */
    public function restore(User $user, Option $model): bool
    {
        return false;
    }

    /**
     * Determine whether the option can permanently delete the model.
     */
    public function forceDelete(User $user, Option $model): bool
    {
        return false;
    }
}
