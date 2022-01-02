<?php

namespace App\Services\Videos\Providers;

use App\Exceptions\FiltersCannotBeEmpty;
use App\Exceptions\ProviderChannelCannotBeEmpty;

/**
 * Class Provider
 */
abstract class Provider
{
    /** @var string */
    protected string $channel;

    /** @var array */
    protected array $filters;

    /**
     * Sets the channel property
     *
     * @throws ProviderChannelCannotBeEmpty
     * @returns Provider
     */
    public function setChannel(string $channel): Provider
    {
        // Throw exception if channel is empty
        if (empty($channel)) {
            throw new ProviderChannelCannotBeEmpty;
        }

        $this->channel = $channel;

        return $this;
    }

    /**
     * Sets the query filters
     *
     * @param array $filters
     *
     * @throws FiltersCannotBeEmpty
     * @return Provider
     */
    public function setFilters(array $filters): Provider
    {
        // For the purpose of this tech test filters CANNOT be empty
        if (empty($filters)) {
            throw new FiltersCannotBeEmpty;
        }

        $this->filters = $filters;

        return $this;
    }

    /**
     * Abstract function to obtain the videos
     *
     * @return array
     */
    abstract function getVideos(): array;
}
