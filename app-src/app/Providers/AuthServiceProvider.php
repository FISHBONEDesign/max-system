<?php

namespace App\Providers;

use App\Http\Middleware\AdminRequirePassword;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerAdminRequirePassword();
    }

    /**
     * Register a resolver for the authenticated user.
     *
     * @return void
     */
    protected function registerAdminRequirePassword()
    {
        $this->app->bind(
            AdminRequirePassword::class, function ($app) {
                return new AdminRequirePassword(
                    $app[ResponseFactory::class],
                    $app[UrlGenerator::class],
                    $app['config']->get('auth.password_timeout')
                );
            }
        );
    }

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::guessPolicyNamesUsing(function ($modelClass) {
            return 'App\\Policies\\' . class_basename($modelClass) . 'Policy';
        });
    }
}
