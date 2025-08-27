<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use App\Http\Middleware\EnsureUserIsCompany as CompanyMiddleware;

class MiddlewareServiceProvider extends ServiceProvider
{
    // public function boot(Router $router): void
    // {
    //     // Register the 'company' middleware alias
    //     $router->aliasMiddleware('company', CompanyMiddleware::class);
    // }

    public function register(): void
    {

    }
}
