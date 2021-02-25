<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Project;
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
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            if ($user->isSupervisor()) {
                return true;
            }
        });

        Gate::define('view-project', function (Admin $user, Project $project) {
            return $user->id === $project->user_id;
        });
    }
}
