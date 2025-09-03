<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\AuditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SettingController extends Controller
{
    use AuthorizesRequests;
    
    protected $auditService;
    
    public function __construct(AuditService $auditService)
    {
        $this->auditService = $auditService;
    }
    
    /**
     * Display the settings form.
     */
    public function index(): View
    {
        $this->authorize('manageSettings');
        
        // Get all settings grouped by category
        $settings = Setting::all()->groupBy('category');
        
        return view('superadmin.settings.index', compact('settings'));
    }
    
    /**
     * Update the settings.
     */
    public function update(Request $request)
    {
        $this->authorize('manageSettings');
        
        // Validate the settings based on their types
        $validated = $request->validate([
            'settings' => 'required|array',
            'settings.*' => 'nullable',
        ]);
        
        $oldSettings = Setting::all()->keyBy('key')->map(function ($setting) {
            return $setting->value;
        })->toArray();
        
        // Update each setting
        foreach ($validated['settings'] as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            
            if ($setting) {
                $oldValue = $setting->value;
                
                // Cast the value based on setting type
                switch ($setting->type) {
                    case 'boolean':
                        $value = !empty($value) && $value !== '0';
                        break;
                    case 'integer':
                        $value = (int) $value;
                        break;
                    case 'float':
                        $value = (float) $value;
                        break;
                    case 'array':
                        // Handle arrays (comma-separated values)
                        $value = !empty($value) ? explode(',', $value) : [];
                        break;
                }
                
                $setting->value = $value;
                $setting->save();
                
                // If it's a sensitive setting, log the change
                if ($setting->is_sensitive) {
                    $this->auditService->log(
                        'setting.update',
                        "Updated setting: {$setting->name}",
                        [
                            'key' => $setting->key,
                            'old_value' => $setting->is_sensitive ? '******' : $oldValue,
                            'new_value' => $setting->is_sensitive ? '******' : $value,
                        ]
                    );
                }
            }
        }
        
        // Clear settings cache
        Cache::forget('settings');
        
        return redirect()->route('superadmin.settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
