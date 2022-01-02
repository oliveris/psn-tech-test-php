<?php

namespace App\Http\Resources;

use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ChannelResource
 *
 * @package App\Http\Resources
 * @mixin Channel
 */
final class ChannelResource extends JsonResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'channel_name' => $this->channel_name
        ];
    }
}
