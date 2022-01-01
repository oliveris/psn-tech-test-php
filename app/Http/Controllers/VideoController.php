<?php

namespace App\Http\Controllers;

use App\Http\Resources\VideoResource;
use App\Models\Video;
use Illuminate\Http\JsonResponse;

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
        $videos = (new Video)
            ->eagerLoad()
            ->get();

        return $this->response->respond(VideoResource::collection($videos));
    }
}
