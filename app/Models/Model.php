<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Http\Request;

/**
 * Class Model
 *
 * @package App\Models
 *
 * @mixin Eloquent
 */
class Model extends BaseModel
{
    /** @var array */
    protected array $filterable = [];

    /**
     * Applies a filter to the query builder
     *
     * @param Builder $builder
     * @param Request $request
     *
     * @return Builder
     */
    public function scopeFilterResult(Builder $builder, Request $request): Builder
    {
        // Obtain the filters from the request
        $filters = $request->all();

        // Iterate through the query filters to check they are valid then filter the result
        foreach ($filters as $filterKey => $filterValue) {
            // if the query filter is not in array continue
            if (!array_key_exists($filterKey, $this->filterable)) {
                continue;
            }

            // Obtain the filter method name
            $method = $this->filterable[$filterKey];

            // Filter the entity for the passed value
            $builder = $this->$method($filterValue);
        }

        return $builder;
    }
}
