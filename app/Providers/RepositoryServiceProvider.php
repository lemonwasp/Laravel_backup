<?php

namespace App\Providers;

use App\Repository\UserRepositoryInterface;
use App\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // UserRepositoryInterface를 요청하면 UserRepository 인스턴스를 반환
        $this->app->bind(
            PublisherRepositoryInterface::class,
            EloquentPublisherRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
