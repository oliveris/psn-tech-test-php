<?php

namespace Feature;

use App\Models\Channel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use TestCase;

/**
 * Class VideoShowFeatureTest
 */
final class VideoShowFeatureTest extends TestCase
{
    /**
     * @test
     * @group core
     * @return void
     */
    public function show(): void
    {
        DB::beginTransaction();

        $channel = (new Channel)->create([
            'channel_name' => 'Test Channel'
        ]);

        $date = Carbon::now()->subYear();

        $videos = [
            [
                'title' => 'Test Title',
                'date'  => $date
            ],
            [
                'title' => 'Test Title 2',
                'date'  => Carbon::now()->subYears(2)
            ],
        ];

        $videos = $channel->videos()->createMany($videos);

        $response = $this->get(route('videos.show', ['id' => $videos[0]->id]));

        $response->assertResponseOk();

        $response->seeJson([
            'data' => [
                'id'    => $videos[0]->id,
                'title' => $videos[0]->title,
                'date'  => $videos[0]->date
            ]
        ]);

        DB::rollBack();
    }
}
