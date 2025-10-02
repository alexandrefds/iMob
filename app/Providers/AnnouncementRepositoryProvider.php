<?php

namespace App\Providers;

use App\Interfaces\Repositories\AnnouncementRepositoryInterface;
use App\Repositories\AnnouncementRepository;
use Illuminate\Support\ServiceProvider;

class AnnouncementRepositoryProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            AnnouncementRepositoryInterface::class,
            AnnouncementRepository::class
        );
    }

    public function boot(): void
    {
    }
}
