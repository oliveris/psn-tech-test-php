<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * Class Model
 *
 * @package App\Models
 *
 * @mixin Eloquent
 */
class Model extends BaseModel
{
    /**
     * Eager load all missing relationships including those specified in the request
     *
     * @return mixed
     */
    public function eagerLoad()
    {
        $request = request();

        // If the request includes additional relationships, add them to the model
        if ($request->exists('with')) {
            foreach ($request->with as $with) {
                if (array_key_exists($with, $this->eagerLoadable ?? []) && $this->eagerLoadable[$with]) {
                    $this->with[] = $this->eagerLoadable[$with];
                }
            }
            $this->loadMissing($this->with);
        }

        return $this;
    }
}
