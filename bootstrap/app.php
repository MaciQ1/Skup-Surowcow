<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withExceptions(function (Exceptions $exceptions) {
        $renderException = function ($e, Request $request, $view, $message, $statusCode) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $message,
                    'details' => $e->getMessage()
                ], $statusCode);
            }
            return response()->view($view, ['exception' => $e], $statusCode);
        };


    })
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->create();
