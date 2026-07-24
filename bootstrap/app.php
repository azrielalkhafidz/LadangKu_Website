<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->validateCsrfTokens(except: [
            'api/sensor/data',
        ]);

        // FIX: Railway (dan platform serupa) meng-handle HTTPS di reverse
        // proxy-nya, tapi koneksi ke container Laravel di baliknya adalah
        // HTTP biasa. Tanpa mempercayai header X-Forwarded-Proto dari
        // proxy, Laravel selalu menyangka request itu HTTP — sehingga
        // semua URL yang di-generate (termasuk asset CSS/JS dari @vite,
        // dan action form) ikut salah jadi http://, dipicu mixed content
        // block oleh browser.
        $middleware->trustProxies(
            at: '*',
            headers: Request::HEADER_X_FORWARDED_FOR |
                     Request::HEADER_X_FORWARDED_HOST |
                     Request::HEADER_X_FORWARDED_PORT |
                     Request::HEADER_X_FORWARDED_PROTO |
                     Request::HEADER_X_FORWARDED_AWS_ELB
        );

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();