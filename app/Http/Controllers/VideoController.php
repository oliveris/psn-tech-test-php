<?php

namespace App\Http\Controllers;

use App\Exceptions\FailedToCreateVideos;
use App\Exceptions\VideoProviderNotFoundException;
use App\Http\Resources\{
    VideoResource,
    VideoFilteredResource
};
use App\Models\Channel;
use App\Services\Videos\VideoManagerService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\Video;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\{
    JsonResponse,
    Request
};
use Symfony\Component\HttpFoundation\Response;

/**
 * Class VideoController
 *
 * @package App\Http\Controllers
 */
final class VideoController extends Controller
{
    /**
     * Gets the Videos
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $videos = (new Video)->get();

        return $this->response->respond(VideoResource::collection($videos));
    }

    /**
     * Gets the Videos - Filtered
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function indexFilter(Request $request): JsonResponse
    {
        $videos = (new Video)
            ->filterResult($request)
            ->get();

        return $this->response->respond(VideoFilteredResource::collection($videos));
    }

    /**
     * @throws VideoProviderNotFoundException
     * @throws FailedToCreateVideos
     */
    public function store(): JsonResponse
    {
        // Define the array of filters
        $filters = ['pro', 'matt stephens', '5', 'Mitchelton-Scott', 'Dubai stage'];

        // Define the array of channels
        $channels = ['GlobalCyclingNetwork', 'globalmtb'];

        // Define the empty videos array
        $videos = collect();

        // Loop through the channels to obtain the videos
        foreach ($channels as $channel) {
            // Communicate with the service to obtain filtered videos for channels
            $videosFound = VideoManagerService::getChannelVideos('youtube', $channel, $filters);

            // Merge the videos into the videos collection
            $videos = $videos->merge($videosFound);
        }

        // Begin the database transaction
        DB::beginTransaction();

        try {
            // Create videos
            $this->createVideos($videos);

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw new FailedToCreateVideos;
        }

        return $this
            ->response
            ->setStatusCode(Response::HTTP_CREATED)
            ->respond('OK');
    }

    /**
     * Gets a single Video by its id
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $video = (new Video)->find($id);

        if ($video === null) {
            throw new ModelNotFoundException;
        }

        return $this
            ->response
            ->respond(new VideoResource($video));
    }

    /**
     * Deletes a video
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy (int $id): JsonResponse
    {
        $video = (new Video)->find($id);

        if ($video === null) {
            throw new ModelNotFoundException;
        }

        $video->delete();

        return $this
            ->response
            ->setStatusCode(Response::HTTP_NO_CONTENT)
            ->respond();
    }

    /**
     * Formats the unique channels
     *
     * @param Collection $videos
     *
     * @return array
     */
    private function createUniqueChannels(Collection $videos): array
    {
        // Map and filter the collection to find the unique channels
        $uniqueChannels = $videos->map(function ($item) {
            return $item->snippet->channelTitle;
        })->unique();

        // Define an empty formatted array
        $formatted = [];

        // Iterate through each unique channel and add them to the formatted array
        foreach ($uniqueChannels as $uniqueChannel) {
            // Find and return if match is found or create the new unique channel
            $channel = Channel::firstOrCreate(['channel_name' => $uniqueChannel]);

            // Set the formatted array for easy consumption when creating videos
            $formatted[$channel->channel_name] = $channel->id;
        }

        return $formatted;
    }

    /**
     * Creates the videos
     *
     * @param Collection $videos
     *
     * @return void
     */
    private function createVideos(Collection $videos): void
    {
        // Create the unique channels
        $channels = $this->createUniqueChannels($videos);

        // Define an empty formatted array
        $formattedVideos = [];

        // Loop through the videos and format the data
        foreach ($videos as $video) {
            $formattedVideos[] = [
                'title'      => $video->snippet->title,
                'date'       => Carbon::parse($video->snippet->publishedAt),
                'channel_id' => $channels[$video->snippet->channelTitle]
            ];
        }

        // Create all the formatted videos in one query
        Video::insert($formattedVideos);
    }
}
