<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Mendaftarkan middleware global
        // $middleware->append(\App\Http\Middleware\TrustProxies::class);
        
        // Mendaftarkan middleware web
        $middleware->web(append: [
            // Menambahkan custom middleware di sini
        ]);
        
        // Mendaftarkan middleware api
        $middleware->api(append: [
            // Middleware API di sini
        ]);
        
        // Mendaftarkan alias middleware
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'active.user' => \App\Http\Middleware\ActiveUser::class,
            'active' => \App\Http\Middleware\ActiveUser::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
