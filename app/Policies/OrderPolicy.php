<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any orders.
     */
    public function viewAny(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can view the order.
     */
    public function view(User $user, Order $model)
    {
        return $user->role === 'admin' || $user->id === $model->user_id;
    }

    /**
     * Determine whether the user can create orders.
     */
    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the order.
     */
    public function update(User $user, Order $model)
    {
        return $user->role === 'admin' || $user->id === $model->user_id;
    }

    /**
     * Determine whether the user can delete the order.
     */
    public function delete(User $user, Order $model)
    {
        return $user->role === 'admin' || $user->id === $model->user_id;
    }


    public function restore(User $user, Order $model): bool
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Order $model): bool
    {
        return $user->role === 'admin' || $user->id === $model->user_id;
    }
}
