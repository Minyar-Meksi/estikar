<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Marque;
use Illuminate\Auth\Access\HandlesAuthorization;

class MarquePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the marque can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the marque can view the model.
     */
    public function view(User $user, Marque $model): bool
    {
        return true;
    }

    /**
     * Determine whether the marque can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the marque can update the model.
     */
    public function update(User $user, Marque $model): bool
    {
        return true;
    }

    /**
     * Determine whether the marque can delete the model.
     */
    public function delete(User $user, Marque $model): bool
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
     * Determine whether the marque can restore the model.
     */
    public function restore(User $user, Marque $model): bool
    {
        return false;
    }

    /**
     * Determine whether the marque can permanently delete the model.
     */
    public function forceDelete(User $user, Marque $model): bool
    {
        return false;
    }
}
