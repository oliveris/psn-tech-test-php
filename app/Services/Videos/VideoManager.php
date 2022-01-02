<?php

namespace App\Services\Videos;

use Illuminate\Support\Collection;

/**
 * Interface VideoManager
 */
interface VideoManager
{
    /**
     * Obtains videos for the passed channel and optional search query params
     *
     * @param string $provider
     * @param string $channel
     * @param array $filter
     *
     * @return Collection
     */
    public static function getChannelVideos(string $provider, string $channel, array $filter = []): Collection;
}
