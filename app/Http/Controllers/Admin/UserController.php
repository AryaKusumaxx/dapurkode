<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use AuthorizesRequests;
    
    /**
     * Display a listing of all users.
     */
    public function index(): View
    {
        $this->authorize('viewAny', User::class);
        
        $users = User::with('roles')
            ->latest()
            ->paginate(10);
            
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        $this->authorize('create', User::class);
        
        $roles = Role::all();
        
        return view('admin.users.create', compact('roles'));
    }
    
    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|max:1024', // Max 1MB
            'is_active' => 'boolean',
        ]);
        
        // Upload avatar if provided
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }
        
        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'avatar' => $avatarPath,
            'is_active' => $validated['is_active'] ?? true,
        ]);
        
        // Assign role
        $user->assignRole($validated['role']);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dibuat.');
    }
    
    /**
     * Display the specified user.
     */
    public function show(User $user): View
    {
        $this->authorize('view', $user);
        
        $user->load(['roles', 'orders.invoice']);
        
        return view('admin.users.show', compact('user'));
    }
    
    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        $this->authorize('update', $user);
        
        $roles = Role::all();
        
        return view('admin.users.edit', compact('user', 'roles'));
    }
    
    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|max:1024', // Max 1MB
            'is_active' => 'boolean',
        ]);
        
        // Upload avatar if provided
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $avatarPath;
        }
        
        // Update user data
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'avatar' => $validated['avatar'] ?? $user->avatar,
            'is_active' => $validated['is_active'] ?? $user->is_active,
        ]);
        
        // Update role
        $user->syncRoles([$validated['role']]);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui.');
    }
    
    /**
     * Update user password.
     */
    public function updatePassword(Request $request, User $user)
    {
        $this->authorize('update', $user);
        
        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        return redirect()->route('admin.users.edit', $user)
            ->with('success', 'Password berhasil diperbarui.');
    }
    
    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        
        // Check if user has orders
        if ($user->orders()->exists()) {
            // Don't delete, just deactivate
            $user->update(['is_active' => false]);
            
            return redirect()->route('admin.users.index')
                ->with('success', 'User berhasil dinonaktifkan karena memiliki transaksi.');
        }
        
        // Delete avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        
        // Delete user
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
    
    /**
     * Toggle user active status.
     */
    public function toggleStatus(User $user)
    {
        $this->authorize('update', $user);
        
        $user->update([
            'is_active' => !$user->is_active,
        ]);
        
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->route('admin.users.index')
            ->with('success', "User berhasil {$status}.");
    }
}
