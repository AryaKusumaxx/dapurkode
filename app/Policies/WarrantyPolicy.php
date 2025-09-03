<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Warranty;
use Illuminate\Auth\Access\HandlesAuthorization;

class WarrantyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the warranty.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Warranty  $warranty
     * @return bool
     */
    public function view(User $user, Warranty $warranty): bool
    {
        // Admin can view any warranty
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return true;
        }
        
        // Regular users can only view their own warranties
        return $warranty->orderItem->order->user_id === $user->id;
    }
    
    /**
     * Determine whether the user can extend the warranty.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Warranty  $warranty
     * @return bool
     */
    public function extend(User $user, Warranty $warranty): bool
    {
        // Only allow extending active warranties
        if (!$warranty->isActive() || $warranty->isExpired()) {
            return false;
        }
        
        // Admin can extend any warranty
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return true;
        }
        
        // Regular users can only extend their own warranties
        return $warranty->orderItem->order->user_id === $user->id;
    }
    
    /**
     * Determine whether the user can download warranty documents.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Warranty  $warranty
     * @return bool
     */
    public function download(User $user, Warranty $warranty): bool
    {
        // Admin can download any warranty document
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return true;
        }
        
        // Regular users can only download their own warranty documents
        // and only if the warranty is active
        return $warranty->orderItem->order->user_id === $user->id && 
               $warranty->isActive() && 
               !$warranty->isExpired();
    }
}
