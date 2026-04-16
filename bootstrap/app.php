<?php

use App\Http\Controllers\PageErrorController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\SuperAdminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ])->alias([
                    "auth.middleware" => AuthMiddleware::class,
                    "guest.middleware" => GuestMiddleware::class,
                    "admin.middleware" => AdminMiddleware::class,
                    "super.admin.middleware" => SuperAdminMiddleware::class,
                ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->respond(function (Response $response, Throwable $exception, Request $request) {
            if ($response->getStatusCode() == 404) {
                return Inertia::render("error/not-found-error");
            }
            if (in_array($request->getPathInfo(), ['/register', '/login'])) {
                return Inertia::render('error/incorrect-auth-path-error', ['path' => $request->getPathInfo()]);
            }
            return Inertia::render("error/unexpected-error");
        });
    })->create();
