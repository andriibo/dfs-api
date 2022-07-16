<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    protected Builder $builder;

    public function __construct(private readonly Request $request)
    {
    }

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->filters() as $method => $value) {
            if (method_exists($this, $method) && $this->isNotEmptyValue($value, $method)) {
                call_user_func_array([$this, $method], [$value]);
            }
        }

        return $this->builder;
    }

    public function filters(): array
    {
        return $this->request->all();
    }

    abstract public function sort(string $sort): Builder;

    protected function isNotEmptyValue($value, $method): bool
    {
        return !empty($value);
    }
}
