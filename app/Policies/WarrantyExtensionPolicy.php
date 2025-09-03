<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WarrantyExtension;
use Illuminate\Auth\Access\HandlesAuthorization;

class WarrantyExtensionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the warranty extension.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WarrantyExtension  $extension
     * @return bool
     */
    public function view(User $user, WarrantyExtension $extension): bool
    {
        // Admin can view any warranty extension
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return true;
        }
        
        // Regular users can only view their own warranty extensions
        return $extension->user_id === $user->id;
    }
    
    /**
     * Determine whether the user can pay for the warranty extension.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WarrantyExtension  $extension
     * @return bool
     */
    public function pay(User $user, WarrantyExtension $extension): bool
    {
        // Only allow paying for pending extensions
        if (!$extension->isPending()) {
            return false;
        }
        
        // Admin can pay for any warranty extension
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return true;
        }
        
        // Regular users can only pay for their own warranty extensions
        return $extension->user_id === $user->id;
    }
}
