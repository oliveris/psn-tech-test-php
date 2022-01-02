<?php

namespace App\Http\Resources;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class VideoFilteredResource
 *
 * @package App\Http\Resources
 * @mixin Video
 */
final class VideoFilteredResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'    => $this->id,
            'title' => $this->title
        ];
    }
}
