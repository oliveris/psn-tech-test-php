<?php

namespace App\Services\Videos\Providers;

use App\Exceptions\NoChannelFound;
use App\Exceptions\ProviderChannelCannotBeEmpty;
use Google\Client;
use Google\Service\YouTube as YouTubeService;
use Illuminate\Support\Collection;

/**
 * Class YouTube
 */
final class YouTube extends Provider
{
    /** @var YouTubeService */
    private YouTubeService $service;

    /**
     * YouTube constructor
     */
    public function __construct()
    {
        $client = new Client;
        $client->setApplicationName('psn-tech-test');
        $client->setDeveloperKey(config('video.youtube.api_key'));

        $this->service = new YouTubeService($client);
    }

    /**
     * Gets a list of filtered videos from a YouTube channel
     *
     * @throws ProviderChannelCannotBeEmpty
     * @throws NoChannelFound
     * @return Collection
     */
    public function getVideos(): Collection
    {
        // Define an empty array to store the found videos
        $videos = collect();

        // Set the query params
        $queryParams = [
//            'channelId' => $this->getChannelId(),
            'channelId' => 'UC_A--fhX5gea0i4UtpD99Gg',
            'type'      => 'video',
            'part'      => 'snippet'
        ];

        // Loop through the filter of keywords
        foreach ($this->filters as $filter) {
            $queryParams['q'] = $filter;

            // Fire the request to search for videos
            $response = $this->service->search->listSearch('snippet', $queryParams);

            // Push the found items into the array
            $videos = $videos->merge($response->items);
        }

        return $videos;
    }

    /**
     * Gets the YouTube channels ID and sets it
     *
     * @throws ProviderChannelCannotBeEmpty
     * @throws NoChannelFound
     * @return string
     */
    private function getChannelId(): string
    {
        // Throw exception if channel is empty
        if (empty($this->channel)) {
            throw new ProviderChannelCannotBeEmpty;
        }

        // Set the query params
        $queryParams = [
            'forUsername' => $this->channel
        ];

        // Fire the request
        $response = $this->service
            ->channels
            ->listChannels('contentDetails', $queryParams);

        // If response items comes back empty
        if (empty($response->items)) {
            throw new NoChannelFound;
        }

        // Return the found channels ID
        return $response->items[0]->id;
    }
}
