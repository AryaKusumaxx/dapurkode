<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    use AuthorizesRequests;
    
    /**
     * Display a listing of the roles.
     */
    public function index(): View
    {
        // Only superadmin can access
        $this->authorize('manageRoles');
        
        $roles = Role::with('permissions')->get();
        
        return view('superadmin.roles.index', compact('roles'));
    }
    
    /**
     * Show the form for creating a new role.
     */
    public function create(): View
    {
        $this->authorize('manageRoles');
        
        $permissions = Permission::all();
        $permissionGroups = $permissions->groupBy(function ($item) {
            // Group by first segment of permission name (before the dot)
            $parts = explode('.', $item->name);
            return $parts[0];
        });
        
        return view('superadmin.roles.create', compact('permissionGroups'));
    }
    
    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('manageRoles');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Create role
            $role = Role::create(['name' => $validated['name'], 'guard_name' => 'web']);
            
            // Assign permissions
            $permissions = Permission::whereIn('id', $validated['permissions'])->get();
            $role->syncPermissions($permissions);
            
            DB::commit();
            
            return redirect()->route('superadmin.roles.index')
                ->with('success', 'Role berhasil dibuat.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat membuat role.')
                ->withInput();
        }
    }
    
    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role): View
    {
        $this->authorize('manageRoles');
        
        // Prevent editing superadmin role
        if ($role->name === 'superadmin') {
            return redirect()->route('superadmin.roles.index')
                ->with('error', 'Role superadmin tidak dapat diubah.');
        }
        
        $permissions = Permission::all();
        $permissionGroups = $permissions->groupBy(function ($item) {
            // Group by first segment of permission name (before the dot)
            $parts = explode('.', $item->name);
            return $parts[0];
        });
        
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        
        return view('superadmin.roles.edit', compact('role', 'permissionGroups', 'rolePermissions'));
    }
    
    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, Role $role)
    {
        $this->authorize('manageRoles');
        
        // Prevent editing superadmin role
        if ($role->name === 'superadmin') {
            return redirect()->route('superadmin.roles.index')
                ->with('error', 'Role superadmin tidak dapat diubah.');
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id',
        ]);
        
        DB::beginTransaction();
        
        try {
            // Update role name
            $role->update(['name' => $validated['name']]);
            
            // Sync permissions
            $permissions = Permission::whereIn('id', $validated['permissions'])->get();
            $role->syncPermissions($permissions);
            
            DB::commit();
            
            return redirect()->route('superadmin.roles.index')
                ->with('success', 'Role berhasil diperbarui.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui role.')
                ->withInput();
        }
    }
}
