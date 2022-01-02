<?php

namespace App\Http\Requests;

use Laravel\Lumen\Http\Request;

/**
 * Class VideoIndexRequest
 */
final class VideoIndexRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'with' => ['array']
        ];
    }
}