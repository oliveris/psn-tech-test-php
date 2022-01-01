<?php

namespace App\Http\Controllers;

use App\Http\BaseResponse;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * The Response object.
     *
     * @var BaseResponse
     */
    protected BaseResponse $response;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->response = new BaseResponse();
    }

    /**
     * A fallback 404 JSON Response for invalid routes
     *
     * @return JsonResponse
     */
    public function fallback(): JsonResponse
    {
        return response()->json(['message' => config('apiConstants.NOT_FOUND')], 404);
    }
}
