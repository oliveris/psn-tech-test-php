<?php

namespace Feature;

use App\Models\Channel;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use TestCase;

/**
 * Class VideoDeleteFeatureTest
 */
final class VideoDeleteFeatureTest extends TestCase
{
    /**
     * @test
     * @group core
     * @return void
     */
    public function destroy(): void
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

        $response = $this->delete(route('videos.delete', ['id' => $videos[0]->id]));

        $response->assertResponseStatus(Response::HTTP_NO_CONTENT);

        $found = Video::find($videos[0]->id);

        $this->assertNull($found);

        DB::rollBack();
    }
}
