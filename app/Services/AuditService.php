<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuditService
{
    /**
     * Log a create action.
     *
     * @param Model $model
     * @return bool
     */
    public function logCreated(Model $model): bool
    {
        return $this->log('create', $model, null, $model->getAttributes());
    }
    
    /**
     * Log an update action.
     *
     * @param Model $model
     * @param array $oldValues
     * @return bool
     */
    public function logUpdated(Model $model, array $oldValues): bool
    {
        return $this->log('update', $model, $oldValues, $model->getAttributes());
    }
    
    /**
     * Log a delete action.
     *
     * @param Model $model
     * @return bool
     */
    public function logDeleted(Model $model): bool
    {
        return $this->log('delete', $model, $model->getAttributes(), null);
    }
    
    /**
     * Log a custom action.
     *
     * @param string $action
     * @param Model $model
     * @param ?array $oldValues
     * @param ?array $newValues
     * @return bool
     */
    public function log(string $action, Model $model, ?array $oldValues = null, ?array $newValues = null): bool
    {
        try {
            // Filter sensitive data
            if ($oldValues) {
                $oldValues = $this->filterSensitiveData($model, $oldValues);
            }
            
            if ($newValues) {
                $newValues = $this->filterSensitiveData($model, $newValues);
            }
            
            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'model_type' => get_class($model),
                'model_id' => $model->getKey(),
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
            
            return true;
        } catch (Throwable $e) {
            Log::error('Failed to create audit log: ' . $e->getMessage(), [
                'action' => $action,
                'model' => get_class($model),
                'id' => $model->getKey(),
                'exception' => $e,
            ]);
            
            return false;
        }
    }
    
    /**
     * Filter sensitive data from the attributes.
     *
     * @param Model $model
     * @param array $attributes
     * @return array
     */
    protected function filterSensitiveData(Model $model, array $attributes): array
    {
        // List of sensitive fields to hide in logs
        $sensitiveFields = [
            'password', 'password_confirmation', 'remember_token',
            'api_token', 'auth_token', 'access_token', 'refresh_token',
            'secret', 'private_key'
        ];
        
        // Add model-specific sensitive fields if defined
        if (method_exists($model, 'getSensitiveFields')) {
            $sensitiveFields = array_merge($sensitiveFields, $model->getSensitiveFields());
        }
        
        // Filter out sensitive fields
        foreach ($sensitiveFields as $field) {
            if (isset($attributes[$field])) {
                $attributes[$field] = '******';
            }
        }
        
        return $attributes;
    }
}
