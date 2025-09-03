<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Warranty;
use App\Models\WarrantyExtension;
use Illuminate\Support\Facades\Auth;

class WarrantyAuditService
{
    /**
     * Log a warranty action
     *
     * @param Warranty $warranty
     * @param string $action
     * @param string $message
     * @return bool
     */
    public function logWarrantyAction(Warranty $warranty, string $action, string $message): bool
    {
        try {
            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'model_type' => get_class($warranty),
                'model_id' => $warranty->id,
                'old_values' => null,
                'new_values' => ['message' => $message],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
            
            return true;
        } catch (\Throwable $e) {
            \Log::error('Failed to create warranty audit log: ' . $e->getMessage(), [
                'action' => $action,
                'warranty_id' => $warranty->id,
                'message' => $message,
                'exception' => $e,
            ]);
            
            return false;
        }
    }
    
    /**
     * Log a warranty extension action
     *
     * @param WarrantyExtension $extension
     * @param string $action
     * @param string $message
     * @return bool
     */
    public function logWarrantyExtensionAction(WarrantyExtension $extension, string $action, string $message): bool
    {
        try {
            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'model_type' => get_class($extension),
                'model_id' => $extension->id,
                'old_values' => null,
                'new_values' => ['message' => $message],
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
            
            return true;
        } catch (\Throwable $e) {
            \Log::error('Failed to create warranty extension audit log: ' . $e->getMessage(), [
                'action' => $action,
                'warranty_extension_id' => $extension->id,
                'message' => $message,
                'exception' => $e,
            ]);
            
            return false;
        }
    }
}
