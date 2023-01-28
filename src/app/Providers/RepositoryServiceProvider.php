<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Services\UserService;
use App\Http\Services\Interfaces\UserInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserInterface::class, 
            UserService::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
