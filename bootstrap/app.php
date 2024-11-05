<?php

use App\Http\Middleware\CheckAffiliatesAccess;
use App\Http\Middleware\CheckApprovalStatusandInstitutionalUnitAccess;
use App\Http\Middleware\CheckInstitutionalUnitAccess;
use App\Http\Middleware\RoleMiddleWare;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => RoleMiddleWare::class,
            'checkAffiliateAccess' => CheckAffiliatesAccess::class,
            'checkInstitutionalUnitAccess' => CheckInstitutionalUnitAccess::class,
            'checkApprovalStatusandInstitutionalUnitAccess' => CheckApprovalStatusandInstitutionalUnitAccess::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
