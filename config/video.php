<?php

use App\Services\Videos\Providers\YouTube;

return [
    'youtube' => [
        'class'   => YouTube::class,
        'api_key' => env('YOU_TUBE_API_KEY')
    ]
];
