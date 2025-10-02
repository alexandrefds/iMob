<?php

namespace App\Providers;

use App\Interfaces\Interfaces\Repositories\BaseRepositoryInterface;
use App\Repositories\BaseRepository;
use Illuminate\Support\ServiceProvider;

class BaseRepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            BaseRepositoryInterface::class,
            BaseRepository::class
        );
    }

    public function boot(): void
    {
    }
}
