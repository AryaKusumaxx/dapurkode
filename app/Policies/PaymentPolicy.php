<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PaymentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['admin', 'superadmin']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Payment $payment): bool
    {
        // Admin can view any payment
        if ($user->hasRole(['admin', 'superadmin'])) {
            return true;
        }
        
        // Users can view their own payments
        return $user->id === $payment->invoice->order->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Any authenticated user can make a payment
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Payment $payment): bool
    {
        // Only admins can update payment details
        return $user->hasRole(['admin', 'superadmin']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Payment $payment): bool
    {
        // Only admins can delete payments
        return $user->hasRole(['admin', 'superadmin']);
    }

    /**
     * Determine whether the user can verify payments.
     */
    public function verify(User $user, Payment $payment): bool
    {
        // Only admins can verify payments
        return $user->hasRole(['admin', 'superadmin']);
    }
}
