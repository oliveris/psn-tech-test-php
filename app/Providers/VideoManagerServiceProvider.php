<?php

namespace App\Providers;

use App\Services\Videos\VideoManagerService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Class VideoManagerServiceProvider
 */
final class VideoManagerServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider functionality
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(VideoManagerService::class, function () {
            return new VideoManagerService;
        });
    }
}
