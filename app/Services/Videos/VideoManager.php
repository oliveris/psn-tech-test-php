<?php

namespace App\Services\Videos;

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
     * @return array
     */
    public static function getChannelVideos(string $provider, string $channel, array $filter = []): array;
}
