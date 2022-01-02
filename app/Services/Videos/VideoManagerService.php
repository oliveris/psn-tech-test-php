<?php

namespace App\Services\Videos;

use App\Exceptions\VideoProviderNotFoundException;
use Illuminate\Support\Collection;

/**
 * Class VideoManagerService
 */
final class VideoManagerService implements VideoManager
{
    /**
     * Get a list of optionally filtered videos for a channel
     *
     * @param string $provider
     * @param string $channel
     * @param array  $filter
     *
     * @throws VideoProviderNotFoundException
     * @return Collection
     */
    public static function getChannelVideos(string $provider, string $channel, array $filter = []): Collection
    {
        // Check the video provider is configured
        if (!array_key_exists($provider, config('video'))) {
            throw new VideoProviderNotFoundException;
        }

        // Obtain the name of the provider to instantiate
        $className = config("video.{$provider}.class");

        // Instantiate the video provider and get the video
        return (new $className)
            ->setChannel($channel)
            ->setFilters($filter)
            ->getVideos();
    }
}
