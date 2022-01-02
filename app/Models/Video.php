<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;


/**
 * Class Video
 *
 * @package App\Models
 * @property int               $id
 * @property string            $title
 * @property Carbon|null       $date
 *
 * @property-read Channel|null $channel
 *
 * @mixin Eloquent
 */
final class Video extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'date'
    ];

    /**
     * Attributes to be cast as dates.
     *
     * @var array
     */
    protected $dates = [
        'date'
    ];

    /**
     * The relationships that are eager loadable
     *
     * @var array
     */
    public array $eagerLoadable = [
        'channel'
    ];

    /**
     * A video belongs to a channel
     *
     * @return Channel|BelongsTo
     */
    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }
}
