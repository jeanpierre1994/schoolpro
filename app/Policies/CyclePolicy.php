<?php

namespace App\Policies;

use App\Models\Cycles;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CyclePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('viewAny cycle');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cycles  $cycle
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Cycles $cycle)
    {
        return $user->can('view cycle');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create cycle');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cycles  $cycle
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Cycles $cycle)
    {
        return $user->can('update cycle');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cycles  $cycle
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Cycles $cycle)
    {
        return $user->can('delete cycle');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cycles  $cycle
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Cycles $cycle)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Cycles  $cycle
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Cycles $cycle)
    {
        //
    }
}
