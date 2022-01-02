<?php

namespace Feature;

use App\Models\Channel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use TestCase;

/**
 * Class VideoListFeatureTest
 */
final class VideoListFeatureTest extends TestCase
{
    /**
     * @test
     * @group core
     * @return void
     */
    public function index(): void
    {
        DB::beginTransaction();

        $channel = (new Channel)->create([
            'channel_name' => 'Test Channel'
        ]);

        $videos = [
            [
                'title' => 'Test Title',
                'date'  => Carbon::now()->subYear()
            ],
            [
                'title' => 'Test Title 2',
                'date'  => Carbon::now()->subYears(2)
            ],
        ];

        $channel->videos()->createMany($videos);

        $response = $this->get(route('videos.index'));

        $response->assertResponseOk();

        $response->seeJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'date'
                ]
            ]
        ]);

        DB::rollBack();
    }
}
