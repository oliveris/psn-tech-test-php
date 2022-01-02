<?php

namespace Feature;

use App\Models\Channel;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use TestCase;

/**
 * Class VideoListFilteredFeatureTest
 */
final class VideoListFilteredFeatureTest extends TestCase
{
    /**
     * @test
     * @group core
     * @return void
     */
    public function indexFilter(): void
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

        $video = (new Video)->where('title', 'Test Title 2')->first();

        $response = $this->get(route('filter-videos'), [
            'title' => 'Test Title 2'
        ]);

        $response->assertResponseOk();

        $response->seeJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title'
                ]
            ]
        ]);

        $response->seeJsonContains([
            'id'    => $video->id,
            'title' => $video->title
        ]);

        DB::rollBack();
    }
}
