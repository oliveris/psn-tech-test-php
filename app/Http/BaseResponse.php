<?php

namespace App\Http;

use Illuminate\Http\JsonResponse;

/**
 * Class BaseResponse
 *
 * @package App\Http
 */
class BaseResponse extends JsonResponse
{
    /**
     * Send a success response with optional message string or body
     *
     * @param mixed $data
     *
     * @return JsonResponse
     */
    public function respond($data = null): JsonResponse
    {
        $response = [];

        if (is_string($data)) {
            $response['message'] = $data;
        } elseif ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $this->status());
    }
}
