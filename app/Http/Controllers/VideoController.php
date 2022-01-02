<?php

namespace App\Http\Controllers;

use App\Exceptions\VideoProviderNotFoundException;
use App\Services\Videos\VideoManager;
use App\Services\Videos\VideoManagerService;
use App\Http\Requests\{
    VideoIndexRequest,
    VideoShowRequest
};
use App\Http\Resources\VideoResource;
use App\Models\Video;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
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
     * @noinspection PhpUnusedParameterInspection
     * @param VideoIndexRequest $request
     *
     * @return JsonResponse
     */
    public function index(VideoIndexRequest $request): JsonResponse
    {
        $videos = (new Video)
            ->eagerLoad()
            ->get();

        return $this->response->respond(VideoResource::collection($videos));
    }

    /**
     * @throws VideoProviderNotFoundException
     */
    public function store(): JsonResponse
    {
        // Define the array of filters
        $filters = ['pro', 'matt stephens', '5', 'Mitchelton-Scott', 'Dubai stage'];

        // Define the array of channels
        $channels = ['GlobalCyclingNetwork', 'globalmtb'];

        // Define the empty videos array
        $videos = [];

        // Loop through the channels to obtain the videos
        foreach ($channels as $channel) {
            // Communicate with the service to obtain filtered videos for channels
            $videosFound = VideoManagerService::getChannelVideos('youtube', $channel, ['pro']);

            $videos = array_merge($videos, $videosFound);
        }

        // Format the video data returned
        $videos = $this->formatVideoData($videos);
    }

    /**
     * Gets a single Video by its id
     *
     * @noinspection PhpUnusedParameterInspection
     * @param VideoShowRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show(VideoShowRequest $request, int $id): JsonResponse
    {
        $video = (new Video)->find($id);

        if ($video === null) {
            throw new ModelNotFoundException;
        }

        return $this
            ->response
            ->respond(new VideoResource($video->eagerLoad()));
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

    private function formatVideoData(array $videos): array
    {
        $formatted = [];

        foreach($videos as $video) {

        }
    }
}
