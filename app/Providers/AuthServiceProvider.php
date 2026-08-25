<?php

namespace App\Providers;

use App\Models\Critique;
use App\Policies\CritiquePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Critique::class => CritiquePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
