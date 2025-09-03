<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActiveUser
{
    /**
     * Handle an incoming request.
     * Blokir user yang tidak aktif.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        
        if ($user && !$user->isActive()) {
            auth()->logout();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Akun Anda tidak aktif. Silahkan hubungi administrator.'
                ], 403);
            }
            
            return redirect()->route('login')
                ->with('error', 'Akun Anda tidak aktif. Silahkan hubungi administrator.');
        }
        
        return $next($request);
    }
}
