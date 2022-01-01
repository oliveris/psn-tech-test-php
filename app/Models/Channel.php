<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Channel
 *
 * @package App\Models
 * @property int         $id
 * @property string      $name
 *
 * @mixin Eloquent
 */
final class Channel extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'channel_name'
    ];

    /**
     * A channel has many videos
     *
     * @return Video|HasMany
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }
}
